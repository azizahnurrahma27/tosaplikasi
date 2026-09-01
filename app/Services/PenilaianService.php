<?php

namespace App\Services;

use App\Models\Karyawan;
use App\Models\Tgurumengajar;
use App\Models\Tkelsis;
use App\Models\Tnilai;
use App\Models\TjenisNilai;
use App\Models\Ttahunajaran;
use App\Models\Ttugas;
use App\Models\Ttugas1;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class PenilaianService
{
    protected ?int $idTahunAjaranAktifCache = null;

    public function idGuruLogin(): int
    {
        return (int) Auth::guard('guru')->user()->idguru;
    }

    public function daftarMapelKelas(int $idKelas): \Illuminate\Support\Collection
    {
        $idGuruLogin = $this->idGuruLogin();

        $mapel = Tgurumengajar::query()
            ->with('pelajaran')
            ->where('idkelas', $idKelas)
            ->whereHas('tahunAjaran', fn ($q) => $q->where('staakt', 1))
            ->get();

        $karyawanById = Karyawan::query()
            ->whereIn('id', $mapel->pluck('idguru')->unique())
            ->get()
            ->keyBy('id');

        return $mapel
            ->map(function (Tgurumengajar $item) use ($idGuruLogin, $karyawanById) {
                $karyawan = $karyawanById->get($item->idguru);

                return (object) [
                    'idpelajaran'    => $item->idpelajaran,
                    'nama_pelajaran' => $item->pelajaran->nam ?? '-',
                    'nama_guru'      => $karyawan->nama ?? $karyawan->nam ?? '-',
                    'is_milik_saya'  => (int) $item->idguru === $idGuruLogin,
                ];
            })
            ->sortBy('nama_pelajaran')
            ->values();
    }

    public function pastikanBerhakMasuk(int $idKelas, int $idPelajaran): Tgurumengajar
    {
        $idGuruLogin = $this->idGuruLogin();

        $mengajar = Tgurumengajar::query()
            ->where('idkelas', $idKelas)
            ->where('idpelajaran', $idPelajaran)
            ->where('idguru', $idGuruLogin)
            ->whereHas('tahunAjaran', fn ($q) => $q->where('staakt', 1))
            ->with('pelajaran')
            ->first();

        if (! $mengajar) {
            throw new AccessDeniedHttpException('Anda tidak mengajar mata pelajaran ini di kelas tersebut.');
        }

        return $mengajar;
    }

    public function siswaDenganNilai(int $idKelas, int $idPelajaran)
    {
        $siswaList = Tkelsis::query()
            ->with('siswa')
            ->where('idkel', $idKelas)
            ->whereHas('tahunajaran')
            ->get()
            ->pluck('siswa')
            ->filter()
            ->sortBy('namlen')
            ->values();

        $nilaiTersimpan = Tnilai::query()
            ->where('idkelas', $idKelas)
            ->where('idpelajaran', $idPelajaran)
            ->get()
            ->groupBy('idsis');

        return [$siswaList, $nilaiTersimpan];
    }

    public function daftarJenisNilai()
    {
        return TjenisNilai::orderBy('nama')->get();
    }

    public function semuaTugasKonteks(int $idKelas, int $idPelajaran): \Illuminate\Support\Collection
    {
        $mengajar = $this->pastikanBerhakMasuk($idKelas, $idPelajaran);

        return Ttugas::query()
            ->where('idkelas', $idKelas)
            ->where('idpelajaran', $idPelajaran)
            ->where('idguru', $mengajar->idguru)
            ->get(['id', 'judul'])
            ->keyBy('id');
    }

    public function catatanTugasTersimpan(int $idKelas, int $idPelajaran): \Illuminate\Support\Collection
    {
        $idTugasList = $this->semuaTugasKonteks($idKelas, $idPelajaran)->keys();

        return Ttugas1::query()
            ->whereIn('idtugas', $idTugasList)
            ->get()
            ->keyBy(fn (Ttugas1 $t) => $t->idsiswa.'-'.$t->idtugas);
    }

    public function daftarTugasUntukKonteks(int $idKelas, int $idPelajaran, int $idSiswa): \Illuminate\Support\Collection
    {
        $mengajar = $this->pastikanBerhakMasuk($idKelas, $idPelajaran);

        $idTugasSudahSelesai = Ttugas1::query()
            ->where('idsiswa', $idSiswa)
            ->where('status', 'sudah')
            ->pluck('idtugas');

        $idTugasSudahDinilai = Tnilai::query()
            ->where('idkelas', $idKelas)
            ->where('idpelajaran', $idPelajaran)
            ->where('idsis', $idSiswa)
            ->whereNotNull('idtugas')
            ->pluck('idtugas');

        $idTugasDikecualikan = $idTugasSudahSelesai->merge($idTugasSudahDinilai)->unique();

        return Ttugas::query()
            ->where('idkelas', $idKelas)
            ->where('idpelajaran', $idPelajaran)
            ->where('idguru', $mengajar->idguru)
            ->whereNotIn('id', $idTugasDikecualikan)
            ->orderByDesc('tglpenugasan')
            ->get(['id', 'judul', 'tglpenugasan']);
    }

    public function simpanNilai(int $idKelas, int $idPelajaran, array $payload): void
    {
        $mengajar = $this->pastikanBerhakMasuk($idKelas, $idPelajaran);
        $idTa     = $this->idTahunAjaranAktif();

        $idsJenisNilai = collect($payload)->flatten(1)->pluck('idjenisnilai')->filter()->unique();
        $tipeMap = TjenisNilai::whereIn('id', $idsJenisNilai)->pluck('tipe', 'id');

        DB::connection('mai1')->transaction(function () use ($idKelas, $idPelajaran, $payload, $mengajar, $idTa, $tipeMap) {
            foreach ($payload as $idSiswa => $entries) {
                foreach ($entries as $entry) {
                    if (! isset($entry['idjenisnilai'], $entry['nilai'])) {
                        continue;
                    }

                    $idJenisNilai = (int) $entry['idjenisnilai'];
                    $tipe         = (int) ($tipeMap->get($idJenisNilai) ?? 0);
                    $idTugas      = $tipe === 1 ? ($entry['idtugas'] ?? null) : null;

                    if ($tipe === 1 && ! $idTugas) {
                        continue;
                    }

                    Tnilai::updateOrCreate(
                        [
                            'idsis'        => (int) $idSiswa,
                            'idkelas'      => $idKelas,
                            'idpelajaran'  => $idPelajaran,
                            'idjenisnilai' => $idJenisNilai,
                            'idtugas'      => $idTugas,
                        ],
                        [
                            'idguru' => $mengajar->idguru,
                            'idta'   => $idTa,
                            'nilai'  => $entry['nilai'],
                        ]
                    );

                    if ($tipe === 1 && $idTugas) {
                        $this->sinkronTtugas1(
                            (int) $idTugas,
                            (int) $idSiswa,
                            $entry['nilai'],
                            $entry['catatan'] ?? null,
                            $mengajar->idguru
                        );
                    }
                }
            }
        });
    }

    protected function sinkronTtugas1(int $idTugas, int $idSiswa, $nilai, ?string $catatan, int $idGuru): void
    {
        $row = Ttugas1::firstOrNew([
            'idtugas' => $idTugas,
            'idsiswa' => $idSiswa,
        ]);

        $isBaru = ! $row->exists;

        $row->status = 'sudah';
        $row->nilai  = $nilai;

        if ($catatan !== null && $catatan !== '') {
            $row->catatan = $catatan;
        }

        $row->updateat = now();
        $row->updateby = $idGuru;

        if ($isBaru) {
            $row->createat = now();
            $row->createby = $idGuru;
        }

        $row->save();
    }

    public function laporanNilai(int $idKelas, int $idPelajaran)
    {
        $this->pastikanBerhakMasuk($idKelas, $idPelajaran);

        $siswaList = Tkelsis::query()
            ->with('siswa')
            ->where('idkel', $idKelas)
            ->whereHas('tahunajaran')
            ->get()
            ->pluck('siswa')
            ->filter()
            ->sortBy('namlen')
            ->values();

        $nilai = Tnilai::query()
            ->with('tugas')
            ->where('idkelas', $idKelas)
            ->where('idpelajaran', $idPelajaran)
            ->whereIn('idsis', $siswaList->pluck('id'))
            ->get();

        // Semua jenis nilai yang terdaftar di sistem, bukan cuma yang sudah dipakai.
        $jenisList = $this->daftarJenisNilai();

        // Bangun daftar kolom: tiap jenis nilai bisa punya 1..n kolom
        // (n kolom kalau tipe tugas dgn banyak judul berbeda yg sudah dinilai,
        // 1 kolom placeholder "-" kalau belum ada nilai sama sekali).
        $headerGroups = $jenisList->map(function ($jenis) use ($nilai) {
            $tipe = (int) $jenis->tipe;

            if ($tipe === 1) {
                $kolomTugas = $nilai
                    ->where('idjenisnilai', $jenis->id)
                    ->pluck('tugas')
                    ->filter()
                    ->unique('id')
                    ->sortBy('tglpenugasan')
                    ->values()
                    ->map(fn ($t) => (object) [
                        'key'   => 'j'.$jenis->id.'-t'.$t->id,
                        'judul' => $t->judul ?? '-',
                    ]);

                if ($kolomTugas->isEmpty()) {
                    $kolomTugas = collect([(object) [
                        'key' => 'j'.$jenis->id.'-kosong', 'judul' => null,
                    ]]);
                }

                return (object) ['jenis' => $jenis, 'kolom' => $kolomTugas];
            }

            return (object) [
                'jenis' => $jenis,
                'kolom' => collect([(object) [
                    'key' => 'j'.$jenis->id, 'judul' => null,
                ]]),
            ];
        });

        // Lookup cepat: key kolom -> baris nilai
        $nilaiByKey = $nilai->groupBy(function ($n) {
            $keyTugas = $n->idtugas ? 'j'.$n->idjenisnilai.'-t'.$n->idtugas : null;
            return $keyTugas ?? 'j'.$n->idjenisnilai;
        });

        $rows = $siswaList->map(function ($siswa) use ($headerGroups, $nilaiByKey) {
            $cells = collect();

            foreach ($headerGroups as $group) {
                foreach ($group->kolom as $kolom) {
                    $entry = ($nilaiByKey->get($kolom->key) ?? collect())
                        ->firstWhere('idsis', $siswa->id);

                    $cells[$kolom->key] = $entry?->nilai;
                }
            }

            return (object) ['siswa' => $siswa, 'cells' => $cells];
        });

        return [$headerGroups, $rows];
    }
    protected function idTahunAjaranAktif(): int
    {
        return $this->idTahunAjaranAktifCache ??= (int) Ttahunajaran::where('staakt', 1)->value('id');
    }
}