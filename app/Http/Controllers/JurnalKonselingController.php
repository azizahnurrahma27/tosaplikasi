<?php

namespace App\Http\Controllers;

use App\Models\Tkelas;
use App\Models\Ttahunajaran;
use App\Services\JurnalKonselingService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class JurnalKonselingController extends Controller
{
    public function __construct(protected JurnalKonselingService $service)
    {
    }

    public function index(int $idkelas): View
    {
        $isikelas = Tkelas::findOrFail($idkelas);
        $siswa = $this->service->getSiswaWithJurnalCount($idkelas);

        return view('guru.jurnalkonseling.index', compact('isikelas', 'siswa'));
    }

    public function show(Request $request, int $idkelas, int $idsis): View
    {
        $isikelas = Tkelas::findOrFail($idkelas);

        // Validasi: siswa ini memang terdaftar di kelas ini (tahun ajaran aktif)
        $siswaData = $this->service->getSiswaByKelas($idkelas)->firstWhere('id', $idsis);

        if (! $siswaData) {
            abort(404, 'Siswa tidak ditemukan di kelas ini.');
        }

        $jurnal = $this->service->getJurnalBySiswa($idsis, $request->query('tanggal'));

        return view('guru.jurnalkonseling.show', compact('isikelas', 'siswaData', 'jurnal'));
    }

    public function create(int $idkelas, int $idsis): View
    {
        $isikelas = Tkelas::findOrFail($idkelas);

        $siswaData = $this->service->getSiswaByKelas($idkelas)->firstWhere('id', $idsis);

        if (! $siswaData) {
            abort(404, 'Siswa tidak ditemukan di kelas ini.');
        }

        return view('guru.jurnalkonseling.create', compact('isikelas', 'siswaData'));
    }

    public function store(Request $request, int $idkelas, int $idsis): RedirectResponse
    {
        $data = $request->validate([
            'tanggal'               => 'required|date',
            'waktu_mulai'           => 'required|date_format:H:i',
            'waktu_selesai'         => 'required|date_format:H:i',
            'deskripsi_kegiatan'    => 'required|string',
            'rencana_tindak_lanjut' => 'nullable|string',
        ]);

        // Validasi siswa memang di kelas ini
        $siswaValid = $this->service->getSiswaByKelas($idkelas)->firstWhere('id', $idsis);
        if (! $siswaValid) {
            abort(404, 'Siswa tidak ditemukan di kelas ini.');
        }

        $data['idsis'] = $idsis;

        $akun = Auth::guard('guru')->user();

        if (! $akun) {
            abort(403, 'Anda harus login sebagai guru.');
        }

        $idkar = $akun->idguru;

        if (empty($idkar)) {
            abort(403, 'Akun ini tidak terhubung ke data karyawan (idguru kosong).');
        }

        $this->service->create($data, (string) $idkar, $idkelas);
        return redirect()
            ->route('guru.jurnalkonseling.show', [$idkelas, $idsis])
            ->with('success', 'Jurnal konseling berhasil ditambahkan.');
    }

    public function edit(int $idkelas, int $id): View
    {
        $isikelas = Tkelas::findOrFail($idkelas);
        $jurnal = $this->service->find($id);

        return view('guru.jurnalkonseling.edit', compact('isikelas', 'jurnal'));
    }
    public function update(Request $request, int $idkelas, int $id): RedirectResponse
    {
        $data = $request->validate([
            'tanggal'               => 'required|date',
            'waktu_mulai'           => 'required|date_format:H:i',
            'waktu_selesai'         => 'required|date_format:H:i',
            'deskripsi_kegiatan'    => 'required|string',
            'rencana_tindak_lanjut' => 'nullable|string',
        ]);

        $jurnal = $this->service->update($id, $data);

        return redirect()
            ->route('guru.jurnalkonseling.show', [$idkelas, $jurnal->idsis])
            ->with('success', 'Jurnal konseling berhasil diperbarui.');
    }

    public function destroy(int $idkelas, int $id): RedirectResponse
    {
        $jurnal = $this->service->find($id);
        $idsis = $jurnal->idsis;

        $this->service->delete($id);

        return redirect()
            ->route('guru.jurnalkonseling.show', [$idkelas, $idsis])
            ->with('success', 'Jurnal konseling berhasil dihapus.');
    }

    public function download(Request $request, int $idkelas): StreamedResponse
    {
        $isikelas = Tkelas::findOrFail($idkelas);

        $data = $this->service->getAllByKelasForExport(
            $idkelas,
            $request->query('dari'),
            $request->query('sampai')
        );

        $filename = 'jurnal-konseling-' . str($isikelas->nam ?? $idkelas)->slug() . '-' . now()->format('Ymd_His') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($data) {
            $handle = fopen('php://output', 'w');

            // BOM biar Excel baca UTF-8 dengan benar
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($handle, ['Tanggal', 'Waktu Mulai', 'Waktu Selesai', 'Siswa', 'Deskripsi Kegiatan', 'Rencana Tindak Lanjut', 'Guru BK']);

            foreach ($data as $item) {
                fputcsv($handle, [
                    optional($item->tanggal)->format('d-m-Y'),
                    optional($item->waktu_mulai)->format('H:i'),
                    optional($item->waktu_selesai)->format('H:i'),
                    $item->siswa->namlen ?? '-',
                    $item->deskripsi_kegiatan,
                    $item->rencana_tindak_lanjut,
                    $item->guru->Nam ?? '-',
                ]);
            }

            fclose($handle);
        };

        return response()->streamDownload($callback, $filename, $headers);
    }

    public function downloadSiswa(Request $request, int $idkelas, int $idsis): StreamedResponse
    {
        $isikelas = Tkelas::findOrFail($idkelas);

        $siswaData = $this->service->getSiswaByKelas($idkelas)->firstWhere('id', $idsis);
        if (! $siswaData) {
            abort(404, 'Siswa tidak ditemukan di kelas ini.');
        }

        $data = $this->service->getAllBySiswaForExport(
            $idsis,
            $request->query('dari'),
            $request->query('sampai')
        );

        $filename = 'jurnal-konseling-' . str($siswaData->namlen ?? $idsis)->slug() . '-' . now()->format('Ymd_His') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($data) {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($handle, ['Tanggal', 'Waktu Mulai', 'Waktu Selesai', 'Deskripsi Kegiatan', 'Rencana Tindak Lanjut', 'Guru BK']);

            foreach ($data as $item) {
                fputcsv($handle, [
                    optional($item->tanggal)->format('d-m-Y'),
                    optional($item->waktu_mulai)->format('H:i'),
                    optional($item->waktu_selesai)->format('H:i'),
                    $item->deskripsi_kegiatan,
                    $item->rencana_tindak_lanjut,
                    $item->guru->Nam ?? '-',
                ]);
            }

            fclose($handle);
        };

        return response()->streamDownload($callback, $filename, $headers);
    }


    public function downloadPdf(Request $request, int $idkelas)
    {
        $isikelas = Tkelas::findOrFail($idkelas);

        $data = $this->service->getAllByKelasForExport(
            $idkelas,
            $request->query('dari'),
            $request->query('sampai')
        );

        $jumlahSiswa = $this->service->getSiswaByKelas($idkelas)->count();

        // TODO: sesuaikan nama relasi/kolom wali kelas & tahun ajaran di model Tkelas kamu
        $namaWaliKelas = optional($isikelas->waliKelas)->nam ?? $isikelas->nama_wali ?? null;
        $tahunajaran = optional(Ttahunajaran::find($isikelas->idta))->nam;
        $namaSekolah   = config('sekolah.nama');
        $alamatSekolah = config('sekolah.alamat');

        // Dompdf butuh path file lokal (bukan URL asset()) supaya logo pasti kebaca.
        $logoPath = public_path('images/logo-sekolah.png');

        $pdf = Pdf::loadView('guru.jurnalkonseling.laporan-pdf', compact(
            'isikelas', 'data', 'jumlahSiswa', 'namaWaliKelas', 'tahunajaran',
            'namaSekolah', 'alamatSekolah', 'logoPath'
        ))->setPaper('a4', 'portrait');

        $filename = 'jurnal-konseling-' . str($isikelas->nam ?? $idkelas)->slug() . '-' . now()->format('Ymd_His') . '.pdf';

        return $pdf->download($filename);
     
    }

    public function downloadSiswaPdf(Request $request, int $idkelas, int $idsis)
    {
        $isikelas = Tkelas::findOrFail($idkelas);

        $siswaData = $this->service->getSiswaByKelas($idkelas)->firstWhere('id', $idsis);
        if (! $siswaData) {
            abort(404, 'Siswa tidak ditemukan di kelas ini.');
        }

        $data = $this->service->getAllBySiswaForExport(
            $idsis,
            $request->query('dari'),
            $request->query('sampai')
        );

        $namaWaliKelas = optional($isikelas->waliKelas)->nam ?? $isikelas->nama_wali ?? null;
        $tahunajaran = optional(Ttahunajaran::find($isikelas->idta))->nam;
        $namaSekolah   = config('sekolah.nama');
        $alamatSekolah = config('sekolah.alamat');

        $logoPath = public_path('images/logo-sekolah.png');

        $pdf = Pdf::loadView('guru.jurnalkonseling.laporan-siswa-pdf', compact(
            'isikelas', 'siswaData', 'data', 'namaWaliKelas', 'tahunajaran',
            'namaSekolah', 'alamatSekolah', 'logoPath'
        ))->setPaper('a4', 'portrait');

        $filename = 'jurnal-konseling-' . str($siswaData->namlen ?? $idsis)->slug() . '-' . now()->format('Ymd_His') . '.pdf';

        return $pdf->download($filename);
    }

}