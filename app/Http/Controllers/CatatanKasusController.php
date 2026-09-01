<?php

namespace App\Http\Controllers;

use App\Models\Tcatatankasus;
use App\Models\Tkelas;
use App\Models\Tsiswa;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CatatanKasusController extends Controller
{
    private function akunLogin()
    {
        return Auth::guard('guru')->user();
    }

    public function index($idkelas)
    {
        $kelas = Tkelas::findOrFail($idkelas);

        $siswaList = Tsiswa::where('kel', $kelas->nam)
            ->orderBy('namlen')
            ->get();

        // Rekap per idsis, dihitung terpisah karena beda koneksi DB dgn tsiswa
        $rekap = Tcatatankasus::where('idkel', $idkelas)
            ->selectRaw('idsis, COUNT(*) as total_kasus, SUM(jumlah_poin) as total_poin')
            ->groupBy('idsis')
            ->get()
            ->keyBy('idsis');

        $siswaList->each(function ($siswa) use ($rekap) {
            $siswa->total_kasus = $rekap[$siswa->id]->total_kasus ?? 0;
            $siswa->total_poin  = $rekap[$siswa->id]->total_poin ?? 0;
        });

        return view('guru.catatankasus.index', compact('kelas', 'siswaList'));
    }

    public function show($idkelas, $idsis)
    {
        $kelas = Tkelas::findOrFail($idkelas);
        $siswa = Tsiswa::findOrFail($idsis);

        $catatan = Tcatatankasus::where('idsis', $idsis)
            ->where('idkel', $idkelas)
            ->with('guru')
            ->orderByDesc('tanggal')
            ->get();

        return view('guru.catatankasus.show', compact('kelas', 'siswa', 'catatan'));
    }

    public function create($idkelas, $idsis)
    {
        $kelas = Tkelas::findOrFail($idkelas);
        $siswa = Tsiswa::findOrFail($idsis);

        $akun = Auth::guard('guru')->user();
        $guru = $akun?->guru;

        return view('guru.catatankasus.create', compact('kelas', 'siswa', 'guru'));
    }

    public function store(Request $request, $idkelas, $idsis)
    {
        $data = $request->validate([
            'tanggal'         => 'required|date',
            'deskripsi_kasus' => 'required|string',
            'jumlah_poin'     => 'required|integer|min:0',
        ]);

        $akun = $this->akunLogin();

        Tcatatankasus::create([
            'idsis'           => $idsis,
            'idkel'           => $idkelas,
            'idguru'          => $akun->idguru,
            'tanggal'         => $data['tanggal'],
            'deskripsi_kasus' => $data['deskripsi_kasus'],
            'jumlah_poin'     => $data['jumlah_poin'],
        ]);

        return redirect()
            ->route('guru.catatankasus.show', ['idkelas' => $idkelas, 'idsis' => $idsis])
            ->with('success', 'Catatan kasus berhasil disimpan.');
    }

    public function edit($idkelas, $id)
    {
        $kelas   = Tkelas::findOrFail($idkelas);
        $catatan = Tcatatankasus::with('guru')->findOrFail($id);
        $siswa   = Tsiswa::findOrFail($catatan->idsis);
        $guru    = $catatan->guru; // guru yang menulis catatan ini

        return view('guru.catatankasus.edit', compact('kelas', 'siswa', 'catatan', 'guru'));
    }

    public function update(Request $request, $idkelas, $id)
    {
        $catatan = Tcatatankasus::findOrFail($id);

        $data = $request->validate([
            'tanggal'         => 'required|date',
            'deskripsi_kasus' => 'required|string',
            'jumlah_poin'     => 'required|integer|min:0',
        ]);

        $catatan->update($data);

        return redirect()
            ->route('guru.catatankasus.show', ['idkelas' => $idkelas, 'idsis' => $catatan->idsis])
            ->with('success', 'Catatan kasus berhasil diperbarui.');
    }

    public function destroy($idkelas, $id)
    {
        $catatan = Tcatatankasus::findOrFail($id);
        $idsis   = $catatan->idsis;
        $catatan->delete();

        return redirect()
            ->route('guru.catatankasus.show', ['idkelas' => $idkelas, 'idsis' => $idsis])
            ->with('success', 'Catatan kasus berhasil dihapus.');
    }

    public function pdf($idkelas, $idsis)
    {
        $kelas = Tkelas::findOrFail($idkelas);
        $siswa = Tsiswa::findOrFail($idsis);

        $catatan = Tcatatankasus::where('idsis', $idsis)
            ->where('idkel', $idkelas)
            ->with('guru')
            ->orderBy('tanggal')
            ->get();

        $totalPoin = $catatan->sum('jumlah_poin');

        $pdf = Pdf::loadView('guru.catatankasus.pdf', compact('kelas', 'siswa', 'catatan', 'totalPoin'))
            ->setPaper('a4', 'portrait');

        $namaFile = 'Buku-Kasus-' . str_replace(' ', '-', $siswa->namlen ?? $siswa->nampan) . '.pdf';

        return $pdf->stream($namaFile); // ganti ->stream() jadi ->download() kalau mau langsung terunduh
    }

    public function pdfKelas($idkelas)
    {
        $kelas = Tkelas::findOrFail($idkelas);

        // Ambil semua siswa di kelas ini untuk mapping nama (beda koneksi DB)
        $siswaMap = Tsiswa::where('kel', $kelas->nam)
            ->get()
            ->keyBy('id');

        $catatan = Tcatatankasus::where('idkel', $idkelas)
            ->with('guru')
            ->orderBy('tanggal')
            ->get();

        // Selipkan nama siswa ke tiap baris catatan
        $catatan->each(function ($item) use ($siswaMap) {
            $siswa = $siswaMap[$item->idsis] ?? null;
            $item->nama_siswa = $siswa->namlen ?? $siswa->nampan ?? '-';
        });

        $pdf = Pdf::loadView('guru.catatankasus.pdf-kelas', compact('kelas', 'catatan'))
            ->setPaper('a4', 'landscape'); // landscape biar tabel lega

        $namaFile = 'Catatan-Kasus-Kelas-' . str_replace(' ', '-', $kelas->nam) . '.pdf';

        return $pdf->stream($namaFile);
    }

}