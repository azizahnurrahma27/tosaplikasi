<?php

namespace App\Services;

use App\Models\BobotRapor;
use App\Models\JenisRapot;
use App\Models\Rapor;
use App\Models\RaporDetail;
use App\Models\Tgurumengajar;
use App\Models\Tkelas;
use App\Models\Tkelsis;
use App\Models\Tnilai;
use App\Models\Tsiswa;
use App\Models\Ttahunajaran;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RaporService
{
    private const LAMPIRAN_DISK  = 'public';
    private const LAMPIRAN_PATH  = 'rapor';
    private const CACHE_JENIS_RAPOT = 'jenisrapot:aktif';
    public function daftarSiswaKelas(int $idKelas): EloquentCollection
    {
        $idTa = $this->idTahunAjaranAktif();

        $siswaList = Tkelsis::query()
            ->with('siswa:id,namlen,nis')
            ->where('idkel', $idKelas)
            ->whereHas('tahunajaran', fn ($q) => $q->where('staakt', 1))
            ->get()
            ->pluck('siswa')
            ->filter()
            ->sortBy('namlen')
            ->values();

        $siswaList = new EloquentCollection($siswaList->all());
        $siswaList->loadCount(['rapor as rapor_count' => function ($q) use ($idTa) {
            $q->where('idta', $idTa);
        }]);

        return $siswaList;
    }

    public function siswa(int $idSiswa): Tsiswa
    {
        return Tsiswa::query()
            ->select('id', 'namlen', 'nis')
            ->findOrFail($idSiswa);
    }

    public function raporSiswa(int $idSiswa, int $idKelas, int $idTa): EloquentCollection
    {
        return Rapor::query()
            ->with('jenisRapot:id,nama,semester')
            ->where('idsiswa', $idSiswa)
            ->where('idkelas', $idKelas)
            ->where('idta', $idTa)
            ->orderByDesc('tanggal')
            ->get();
    }

    public function namaKelas(int $idKelas): ?string
    {
        return Tkelas::query()->where('id', $idKelas)->value('nam');
    }

    public function idTahunAjaranAktif(): ?int
    {
        return Ttahunajaran::query()->where('staakt', 1)->value('id');
    }

    public function find(int $id): Rapor
    {
        return Rapor::query()
            ->with([
                'siswa:id,namlen,nis',
                'kelas:id,nam',
                'jenisRapot:id,nama,semester',
                'detail.pelajaran:id,nam',
            ])
            ->findOrFail($id);
    }

    public function jenisRapotAktif(): Collection
    {
        return Cache::remember(self::CACHE_JENIS_RAPOT, now()->addHours(6), function () {
            return JenisRapot::query()
                ->select(['id', 'nama', 'semester'])
                ->aktif()
                ->orderBy('semester')
                ->orderBy('id')
                ->get();
        });
    }

    public function create(array $data, ?UploadedFile $lampiran = null): Rapor
    {
        return DB::transaction(function () use ($data, $lampiran) {
            if ($lampiran) {
                $data['lampiran'] = $this->storeLampiran($lampiran);
            }

            $data['createby'] = Auth::id();

            $rapor = Rapor::create($data);

            $this->generateRaporDetail($rapor);

            return $rapor;
        });
    }

    public function update(Rapor $rapor, array $data, ?UploadedFile $lampiran = null): Rapor
    {
        return DB::transaction(function () use ($rapor, $data, $lampiran) {
            if ($lampiran) {
                $this->deleteLampiran($rapor->lampiran);
                $data['lampiran'] = $this->storeLampiran($lampiran);
            }

            $data['updateby'] = Auth::id();

            $rapor->update($data);
            $rapor->refresh();

            // idjenisrapot/idkelas bisa berubah saat edit -> nilai per mapel
            // & bobot bisa beda, jadi detail lama dibuang & dihitung ulang.
            $this->generateRaporDetail($rapor, regenerate: true);

            return $rapor->fresh();
        });
    }

    public function delete(Rapor $rapor): void
    {
        DB::transaction(function () use ($rapor) {
            $this->deleteLampiran($rapor->lampiran);
            $rapor->delete(); 
            RaporDetail::where('idrapor', $rapor->id)->delete();
        });
    }

    private function generateRaporDetail(Rapor $rapor, bool $regenerate = false): void
    {
        $bobotPerJenisNilai = BobotRapor::query()
            ->where('idjenisrapot', $rapor->idjenisrapot)
            ->get()
            ->keyBy('idjenisnilai');

        if ($bobotPerJenisNilai->isEmpty()) {
            return;
        }

        $idMapelList = Tgurumengajar::query()
            ->where('idkelas', $rapor->idkelas)
            ->whereHas('tahunAjaran', fn ($q) => $q->where('staakt', 1))
            ->pluck('idpelajaran')
            ->unique();

        if ($idMapelList->isEmpty()) {
            return;
        }

        if ($regenerate) {
            RaporDetail::where('idrapor', $rapor->id)
                ->whereNotIn('idpelajaran', $idMapelList)
                ->delete();
        }

        foreach ($idMapelList as $idPelajaran) {
            $nilaiPerJenis = Tnilai::query()
                ->where('idsis', $rapor->idsiswa)
                ->where('idkelas', $rapor->idkelas)
                ->where('idpelajaran', $idPelajaran)
                ->whereIn('idjenisnilai', $bobotPerJenisNilai->keys())
                ->get()
                ->groupBy('idjenisnilai');

            if ($nilaiPerJenis->isEmpty()) {
                continue;
            }

            $totalBobot      = 0;
            $totalNilaiBobot = 0;

            foreach ($nilaiPerJenis as $idJenisNilai => $entries) {
                $bobot = (float) ($bobotPerJenisNilai->get($idJenisNilai)->bobot ?? 0);

                if ($bobot <= 0) {
                    continue;
                }

                $rataRataJenis = $entries->avg('nilai');

                $totalNilaiBobot += $rataRataJenis * $bobot;
                $totalBobot      += $bobot;
            }

            if ($totalBobot <= 0) {
                continue;
            }

            $nilaiAkhir = round($totalNilaiBobot / $totalBobot, 2);

            RaporDetail::updateOrCreate(
                [
                    'idrapor'     => $rapor->id,
                    'idpelajaran' => $idPelajaran,
                ],
                [
                    'nilai'     => $nilaiAkhir,
                    'predikat'  => null,
                    'updateby'  => Auth::id(),
                ]
            );
        }
    }

    private function storeLampiran(UploadedFile $file): string
    {
        return $file->store(self::LAMPIRAN_PATH, self::LAMPIRAN_DISK);
    }

    private function deleteLampiran(?string $path): void
    {
        if ($path && Storage::disk(self::LAMPIRAN_DISK)->exists($path)) {
            Storage::disk(self::LAMPIRAN_DISK)->delete($path);
        }
    }
}