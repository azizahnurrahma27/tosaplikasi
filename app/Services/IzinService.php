<?php

namespace App\Services;

use App\Enums\IzinStatus;
use App\Models\Attendance;
use App\Models\Tizin;
use App\Models\Tkelas;
use App\Models\Tkelsis;
use Carbon\CarbonPeriod;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class IzinService
{
    private const PER_PAGE = 20;

    public function paginate(array $filters = [], int $perPage = self::PER_PAGE): LengthAwarePaginator
    {
        $query = Tizin::select(['id', 'idsis', 'jen', 'tgl_mulai', 'tgl_akhir', 'ket', 'dok', 'sta', 'approved_by', 'approved_at', 'alasan_tolak', 'created_at'])
            ->with([
                'siswa:id,nis,namlen,nampan',
                'jenis:id,title',
                'documents:id,imagable_id,imagable_type,name,path,mime_type,size',
            ]);

        if (!empty($filters['idsis'])) {
            $query->where('idsis', $filters['idsis']);
        }

        if (!empty($filters['jen'])) {
            $query->where('jen', $filters['jen']);
        }

        if (!empty($filters['sta'])) {
            $query->where('sta', $filters['sta']);
        }

        if (!empty($filters['search'])) {
            $query->where('ket', 'like', '%' . $filters['search'] . '%');
        }

        return $query->latest('created_at')->paginate($perPage)->withQueryString();
    }

    public function paginateByKelas(int $idkel, array $filters = [], int $perPage = self::PER_PAGE): LengthAwarePaginator
    {
        $siswaIds = Tkelsis::where('idkel', $idkel)->pluck('ids')->toArray();

        if (empty($siswaIds)) {
            return Tizin::whereRaw('1=0')->paginate($perPage);
        }

        $filters['siswa_ids'] = $siswaIds;
        return $this->paginateByIds($filters, $perPage);
    }

    public function paginatePendingByKelas(int $idkel, int $perPage = self::PER_PAGE): LengthAwarePaginator
    {
        $siswaIds = Tkelsis::where('idkel', $idkel)->pluck('ids')->toArray();

        if (empty($siswaIds)) {
            return Tizin::whereRaw('1=0')->paginate($perPage);
        }

        return Tizin::select(['id', 'idsis', 'jen', 'tgl_mulai', 'tgl_akhir', 'ket', 'dok', 'sta', 'approved_by', 'approved_at', 'alasan_tolak', 'created_at'])
            ->with([
                'siswa:id,nis,namlen,nampan',
                'jenis:id,title',
                'documents:id,imagable_id,imagable_type,name,path,mime_type,size',
            ])
            ->whereIn('idsis', $siswaIds)
            ->where('sta', IzinStatus::PENDING->value)
            ->latest('created_at')
            ->paginate($perPage)
            ->withQueryString();
    }

    private function paginateByIds(array $filters, int $perPage): LengthAwarePaginator
    {
        $query = Tizin::select(['id', 'idsis', 'jen', 'tgl_mulai', 'tgl_akhir', 'ket', 'dok', 'sta', 'approved_by', 'approved_at', 'alasan_tolak', 'created_at'])
            ->with([
                'siswa:id,nis,namlen,nampan',
                'jenis:id,title',
                'documents:id,imagable_id,imagable_type,name,path,mime_type,size',
            ]);

        if (!empty($filters['siswa_ids'])) {
            $query->whereIn('idsis', $filters['siswa_ids']);
        }

        if (!empty($filters['jen'])) {
            $query->where('jen', $filters['jen']);
        }

        if (!empty($filters['tgl'])) {
            $tanggal = \Carbon\Carbon::parse($filters['tgl'])->toDateString();
            $query->where('tgl_mulai', '<=', $tanggal)
                  ->where(function ($q) use ($tanggal) {
                      $q->whereNull('tgl_akhir')
                        ->orWhere('tgl_akhir', '>=', $tanggal);
                  });
        }

        return $query->latest('created_at')->paginate($perPage)->withQueryString();
    }

    public function approve(int $izinId, string $approverKaryawanId): Tizin
    {
        $izin = Tizin::with(['siswa:id,nis,namlen,nampan', 'jenis:id,title'])->findOrFail($izinId);

        $izin->sta = IzinStatus::APPROVED->value;
        $izin->approved_by = $approverKaryawanId;
        $izin->approved_at = now();
        $izin->alasan_tolak = null;
        $izin->save();

        $this->syncAttendanceForIzin($izin);

        return $izin;
    }

    public function reject(int $izinId, string $approverKaryawanId, ?string $alasan = null): Tizin
    {
        $izin = Tizin::findOrFail($izinId);

        $izin->sta = IzinStatus::REJECTED->value;
        $izin->approved_by = $approverKaryawanId;
        $izin->approved_at = now();
        $izin->alasan_tolak = $alasan;
        $izin->save();

        $this->removeAttendanceForIzin($izin->id);

        return $izin;
    }

    private function syncAttendanceForIzin(Tizin $izin): void
    {
        if (!$izin->tgl_mulai) {
            return;
        }

        $mulai = $izin->tgl_mulai instanceof \Carbon\Carbon
            ? $izin->tgl_mulai->copy()
            : \Carbon\Carbon::parse($izin->tgl_mulai);

        $akhir = $izin->tgl_akhir
            ? ($izin->tgl_akhir instanceof \Carbon\Carbon ? $izin->tgl_akhir->copy() : \Carbon\Carbon::parse($izin->tgl_akhir))
            : $mulai->copy();

        $statusLabel = $this->resolveAttendanceStatus($izin);
        $namaSiswa = $izin->siswa
            ? trim($izin->siswa->namlen ?: $izin->siswa->nampan)
            : null;

        foreach (CarbonPeriod::create($mulai, $akhir) as $tanggal) {
            Attendance::updateOrCreate(
                [
                    'student_id' => $izin->idsis,
                    'event_time' => $tanggal->toDateString() . ' 00:00:00',
                ],
                [
                    'name' => $namaSiswa,
                    'attendance_status' => $statusLabel,
                    'employee_no' => null,
                    'serial_no' => null,
                    'picture_path' => null,
                    'raw_payload' => [
                        'source' => 'izin',
                        'izin_id' => $izin->id,
                        'jenis' => $izin->jenis?->title,
                    ],
                ]
            );
        }
    }

    private function removeAttendanceForIzin(int $izinId): void
    {
        Attendance::whereJsonContains('raw_payload->izin_id', $izinId)->delete();
    }

    private function resolveAttendanceStatus(Tizin $izin): string
    {
        $title = strtolower($izin->jenis?->title ?? '');

        if (str_contains($title, 'sakit')) {
            return 'Sakit';
        }

        return 'Izin';
    }

    public function isWaliKelas(int $idkel, ?string $userKaryawanId): bool
    {
        if (!$userKaryawanId) {
            return false;
        }

        $kelas = Tkelas::find($idkel);
        if (!$kelas || !$kelas->idk) {
            return false;
        }

        return (string) $kelas->idk === (string) $userKaryawanId;
    }

    public function resolveSiswaName(\App\Models\Tsiswa $siswa): string
    {
        return trim($siswa->namlen ?: $siswa->nampan);
    }
}