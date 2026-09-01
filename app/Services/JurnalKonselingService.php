<?php

namespace App\Services;

use App\Models\JurnalKonseling;
use App\Models\Tkelas;
use App\Models\Tkelsis;
use App\Models\Tsiswa;
use App\Models\Ttahunajaran;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;

class JurnalKonselingService
{
    public function getSiswaByKelas(int $idKelas): Collection
    {
        $idSiswa = Tkelsis::query()
            ->where('idkel', $idKelas)
            ->whereHas('tahunajaran')
            ->pluck('ids');

        if ($idSiswa->isEmpty()) {
            return collect();
        }

        return Tsiswa::query()
            ->whereIn('id', $idSiswa)
            ->orderBy('namlen')
            ->get();
    }

    public function getSiswaWithJurnalCount(int $idKelas): Collection
    {
        $siswa = $this->getSiswaByKelas($idKelas);

        if ($siswa->isEmpty()) {
            return $siswa;
        }

        $idSiswa = $siswa->pluck('id');

        $counts = JurnalKonseling::query()
            ->whereIn('idsis', $idSiswa)
            ->selectRaw('idsis, count(*) as total')
            ->groupBy('idsis')
            ->pluck('total', 'idsis');

        return $siswa->map(function ($s) use ($counts) {
            $s->jumlah_jurnal = (int) ($counts[$s->id] ?? 0);
            return $s;
        });
    }

    public function getJurnalBySiswa(int $idSis, ?string $tanggal = null, int $perPage = 15)
    {
        $query = JurnalKonseling::query()
            ->with(['siswa', 'guru'])
            ->where('idsis', $idSis)
            ->orderByDesc('tanggal')
            ->orderByDesc('waktu_mulai');

        if (!empty($tanggal)) {
            $query->whereDate('tanggal', $tanggal);
        }

        return $query->paginate($perPage)->withQueryString();
    }


    public function getAllByKelasForExport(int $idKelas, ?string $tanggalDari = null, ?string $tanggalSampai = null): Collection
    {
        $idSiswaTerdaftar = $this->getSiswaByKelas($idKelas)->pluck('id');

        if ($idSiswaTerdaftar->isEmpty()) {
            return collect();
        }

        return JurnalKonseling::query()
            ->with(['siswa', 'guru'])
            ->whereIn('idsis', $idSiswaTerdaftar)
            ->when($tanggalDari, fn ($q) => $q->whereDate('tanggal', '>=', $tanggalDari))
            ->when($tanggalSampai, fn ($q) => $q->whereDate('tanggal', '<=', $tanggalSampai))
            ->orderBy('tanggal')
            ->orderBy('waktu_mulai')
            ->get();
    }

    public function getByKelas(int $idKelas, ?string $search = null, ?string $tanggal = null, int $perPage = 15)
    {
        $idSiswaTerdaftar = $this->getSiswaByKelas($idKelas)->pluck('id');

        $query = JurnalKonseling::query()
            ->with(['siswa', 'guru'])
            ->whereIn('idsis', $idSiswaTerdaftar)
            ->orderByDesc('tanggal')
            ->orderByDesc('waktu_mulai');

        if (!empty($search)) {
            $query->whereHas('siswa', function ($q) use ($search) {
                $q->where('namlen', 'like', "%{$search}%");
            });
        }

        if (!empty($tanggal)) {
            $query->whereDate('tanggal', $tanggal);
        }

        return $query->paginate($perPage)->withQueryString();
    }

    public function find(int $id): JurnalKonseling
    {
        return JurnalKonseling::with(['siswa', 'guru'])->findOrFail($id);
    }

    public function create(array $data, string $idkar, int $idKelas): JurnalKonseling
    {
        $this->assertWaktuValid($data);
        $this->assertSiswaTidakDuplikat($data);

        $kelasInfo = $this->resolveKelasAktif($idKelas);

        $data['idkar'] = $idkar;
        $data['idkel'] = $kelasInfo['idkel'];
        $data['idta']  = $kelasInfo['idta'];

        return JurnalKonseling::create($data);
    }
    public function update(int $id, array $data, ?int $idKelas = null): JurnalKonseling
    {
        $this->assertWaktuValid($data);

        if ($idKelas !== null) {
            $kelasInfo = $this->resolveKelasAktif($idKelas);
            $data['idkel'] = $kelasInfo['idkel'];
            $data['idta']  = $kelasInfo['idta'];
        }

        $jurnal = JurnalKonseling::findOrFail($id);
        $jurnal->update($data);

        return $jurnal->fresh(['siswa', 'guru']);
    }

    public function delete(int $id): void
    {
        JurnalKonseling::findOrFail($id)->delete();
    }

    protected function assertWaktuValid(array $data): void
    {
        if (!empty($data['waktu_mulai']) && !empty($data['waktu_selesai'])) {
            if ($data['waktu_selesai'] <= $data['waktu_mulai']) {
                throw ValidationException::withMessages([
                    'waktu_selesai' => 'Waktu selesai harus lebih besar dari waktu mulai.',
                ]);
            }
        }
    }

    protected function assertSiswaTidakDuplikat(array $data): void
    {
        if (empty($data['idsis']) || empty($data['tanggal'])) {
            return;
        }

        $bentrok = JurnalKonseling::where('idsis', $data['idsis'])
            ->whereDate('tanggal', $data['tanggal'])
            ->where(function ($q) use ($data) {
                $q->whereBetween('waktu_mulai', [$data['waktu_mulai'], $data['waktu_selesai']])
                  ->orWhereBetween('waktu_selesai', [$data['waktu_mulai'], $data['waktu_selesai']]);
            })
            ->exists();

        if ($bentrok) {
            throw ValidationException::withMessages([
                'waktu_mulai' => 'Sudah ada jadwal konseling lain untuk siswa ini pada rentang waktu tersebut.',
            ]);
        }
    }

    public function getAllBySiswaForExport(int $idSis, ?string $tanggalDari = null, ?string $tanggalSampai = null): Collection
    {
        return JurnalKonseling::query()
            ->with(['siswa', 'guru'])
            ->where('idsis', $idSis)
            ->when($tanggalDari, fn ($q) => $q->whereDate('tanggal', '>=', $tanggalDari))
            ->when($tanggalSampai, fn ($q) => $q->whereDate('tanggal', '<=', $tanggalSampai))
            ->orderBy('tanggal')
            ->orderBy('waktu_mulai')
            ->get();
    }

    protected function resolveKelasAktif(int $idKelas): array
    {
        $kelas = Tkelas::find($idKelas);

        if (! $kelas) {
            throw ValidationException::withMessages([
                'idkel' => 'Kelas tidak ditemukan.',
            ]);
        }

        $tahunAjaran = Ttahunajaran::find($kelas->idta);

        if (! $tahunAjaran || (int) $tahunAjaran->staakt !== 1) {
            throw ValidationException::withMessages([
                'idta' => 'Tahun ajaran tidak aktif. Tidak bisa menambahkan jurnal konseling.',
            ]);
        }

        return [
            'idkel' => $kelas->id,
            'idta'  => $tahunAjaran->id,
        ];
    }

}