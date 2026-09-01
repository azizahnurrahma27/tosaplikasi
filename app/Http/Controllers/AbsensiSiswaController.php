<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Tkelas;
use App\Models\Tkelsis;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AbsensiSiswaController extends Controller
{
    public function index($id, Request $request)
    {
        $isikelas = Tkelas::findOrFail($id);

        $tanggal = $request->input('tanggal', now()->format('Y-m-d'));
        $localTimezone = config('facedevice.local_timezone', 'Asia/Jakarta');

        $siswa = Tkelsis::with(['siswa', 'detailsiswa', 'kelas'])
            ->where('idkel', $id)
            ->get();

        // Ambil semua id siswa di kelas ini, buat query attendance sekali aja (bukan per-siswa)
        $studentIds = $siswa->pluck('siswa.id')->filter()->values();

        // event_time disimpan dalam UTC, tapi $tanggal yang diinput user itu
        // tanggal WIB. Biar "tanggal 20 Juli" beneran nangkep semua absen dari
        // jam 00:00 s.d 23:59 WIB (bukan UTC), kita hitung batas hari dalam
        // timezone lokal dulu, baru dikonversi ke UTC buat query-nya.
        $dayStartUtc = Carbon::parse($tanggal, $localTimezone)->startOfDay()->utc();
        $dayEndUtc = Carbon::parse($tanggal, $localTimezone)->endOfDay()->utc();

        // Cari data absensi (dari hasil pull device) untuk tanggal yang dipilih.
        // groupBy (bukan keyBy) soalnya 1 siswa bisa punya 2 record di hari yang
        // sama (hadir + pulang) - keyBy bakal nimpa salah satunya secara diam-diam.
        $attendances = Attendance::whereIn('student_id', $studentIds)
            ->whereBetween('event_time', [$dayStartUtc, $dayEndUtc])
            ->orderBy('event_time')
            ->get()
            ->groupBy('student_id');

        // Tempelkan status absensi ke tiap baris siswa, biar view tinggal pakai $item->absensiHariIni
        foreach ($siswa as $item) {
            $studentId = $item->siswa->id ?? null;
            $studentAttendances = $studentId ? $attendances->get($studentId) : null;

            if (!$studentAttendances || $studentAttendances->isEmpty()) {
                $item->absensiHariIni = null;
                continue;
            }

            // Jam ditampilkan dalam timezone lokal (WIB), bukan UTC mentah -
            // event_time di-cast 'datetime' oleh model, jadi ini Carbon instance.
            $waktuText = $studentAttendances
                ->map(function ($attendance) use ($localTimezone) {
                    $label = $attendance->attendance_status === 'pulang' ? 'Pulang' : 'Hadir';
                    $jamLocal = $attendance->event_time->copy()->setTimezone($localTimezone)->format('H:i');

                    return "{$label} {$jamLocal}";
                })
                ->implode(' · ');

            $item->absensiHariIni = (object) [
                'status' => 'H', // Hadir, karena ketemu record absen dari device
                'keterangan' => 'Absen via wajah: ' . $waktuText,
            ];

            // Catatan: Izin/Sakit/Alpa belum di-set di sini karena itu biasanya data terpisah
            // (misal dari sistem pengajuan izin kamu di IzinController). Kalau kamu punya
            // tabel izin/sakit terpisah, kabari saya field-nya biar saya gabungkan logikanya
            // di sini juga (supaya siswa yang izin tidak otomatis kelihatan "Belum diabsen").
        }

        $countHadir = $attendances->count();
        $countIzin = 0; // TODO: isi dari tabel izin kamu kalau ada
        $countSakit = 0; // TODO: isi dari tabel sakit kamu kalau ada
        $countAlpa = 0; // TODO: hitung dari siswa yang gak hadir & gak izin/sakit, kalau tanggalnya sudah lewat

        return view('page.absensisiswa', compact(
            'siswa',
            'isikelas',
            'countHadir',
            'countIzin',
            'countSakit',
            'countAlpa'
        ));
    }
}