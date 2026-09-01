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

    private function baseQuery()
    {
        return Tizin::select(['id', 'idsis', 'jen', 'tgl_mulai', 'tgl_akhir', 'ket', 'dok', 'sta', 'approved_by', 'approved_at', 'alasan_tolak', 'created_at'])
            ->with([
                'siswa:id,nis,namlen,nampan',
                'jenis:id,title',
                'documents:id,imagable_id,imagable_type,name,path,mime_type,size',
            ]);
    }

    private function applyFilters($query, array $filters)
    {
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

        if (!empty($filters['siswa_ids'])) {
            $query->whereIn('idsis', $filters['siswa_ids']);
        }

        if (!empty($filters['tgl'])) {
            $tanggal = \Carbon\Carbon::parse($filters['tgl'])->toDateString();
            $query->where('tgl_mulai', '<=', $tanggal)
                ->where(function ($q) use ($tanggal) {
                    $q->whereNull('tgl_akhir')
                        ->orWhere('tgl_akhir', '>=', $tanggal);
                });
        }

        return $query;
    }

    public function paginate(array $filters = [], int $perPage = self::PER_PAGE): LengthAwarePaginator
    {
        $query = $this->applyFilters($this->baseQuery(), $filters);

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

        $query = $this->baseQuery()
            ->whereIn('idsis', $siswaIds)
            ->where('sta', IzinStatus::PENDING->value);

        return $query->latest('created_at')->paginate($perPage)->withQueryString();
    }

    private function paginateByIds(array $filters, int $perPage): LengthAwarePaginator
    {
        $query = $this->applyFilters($this->baseQuery(), $filters);

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

        $employeeNo = $this->resolveEmployeeNoFromAttendance($approverKaryawanId);
        $this->syncAttendanceForIzin($izin, $employeeNo);

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

        return $izin;
    }

    private function syncAttendanceForIzin(Tizin $izin, ?string $employeeNo = null, string $action = 'approved'): void
    {
        if (!$izin->tgl_mulai) {
            return;
        }

        $employeeNo = $this->resolveEmployeeNoForAttendance($employeeNo, $izin->approved_by);

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
            $eventTime = ($izin->approved_at ?? now())->format('Y-m-d H:i:s');

            $existing = Attendance::query()
                ->where('student_id', $izin->idsis)
                ->where('device_id', 6)
                ->where('employee_no', $employeeNo)
                ->where('event_time', $eventTime)
                ->whereJsonContains('raw_payload->izin_id', $izin->id)
                ->where('raw_payload->action', $action)
                ->first();

            if ($existing) {
                continue;
            }

            Attendance::create([
                'device_id' => 6,
                'student_id' => $izin->idsis,
                'employee_no' => $employeeNo,
                'name' => $namaSiswa,
                'event_time' => $eventTime,
                'attendance_status' => $statusLabel,
                'serial_no' => null,
                'picture_path' => null,
                'raw_payload' => [
                    'source' => 'izin',
                    'izin_id' => $izin->id,
                    'jenis' => $izin->jenis?->title,
                    'approved_by' => $izin->approved_by,
                    'action' => $action,
                    'alasan_tolak' => $action === 'rejected' ? $izin->alasan_tolak : null,
                    'event_date' => $tanggal->toDateString(),
                ],
            ]);
        }
    }

    private function resolveEmployeeNoFromAttendance(string|int|null $approverKaryawanId): ?string
    {
        $latestEmployeeNo = Attendance::query()
            ->whereNotNull('employee_no')
            ->where('employee_no', '!=', '')
            ->latest('id')
            ->value('employee_no');

        if ($latestEmployeeNo) {
            return (string) $latestEmployeeNo;
        }

        if ($approverKaryawanId === null || $approverKaryawanId === '') {
            return null;
        }

        $value = (string) $approverKaryawanId;

        if (preg_match('/^\d+$/', $value)) {
            $karyawan = \App\Models\Karyawan::find((int) $value);

            return $karyawan?->nip ? (string) $karyawan->nip : $value;
        }

        return $value;
    }

    private function resolveEmployeeNoForAttendance(?string $employeeNo, string|int|null $fallbackApproverKaryawanId): string
    {
        $resolved = $employeeNo ?: $this->resolveEmployeeNoFromAttendance($fallbackApproverKaryawanId);

        if ($resolved === null || trim((string) $resolved) === '') {
            throw new \RuntimeException('employee_no tidak boleh null atau kosong saat membuat absensi izin.');
        }

        return (string) $resolved;
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