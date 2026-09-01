<?php

namespace App\Http\Controllers;

use App\Models\Tkelas;
use App\Models\Ttingkat;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function jenjang()
    {
        /** @var \App\Models\Takunguru $akun */
        $akun = Auth::guard('guru')->user();


        $jenjang = Ttingkat::where('id', $akun->tin)->get();

        return view('page.halamanutama', compact('jenjang'));
    }

    public function sekolah($tin)
    {
        $jenjang = Ttingkat::where('id', $tin)->firstOrFail();

        /** @var \App\Models\Takunguru $akun */
        $akun  = Auth::guard('guru')->user();
        $idGuru = $akun->idguru; // FK ke tguru.id

        $idKelasYangDiajar = \App\Models\Tgurumengajar::query()
            ->where('idguru', $idGuru)
            ->whereHas('kelas', function ($q) use ($tin) {
                $q->where('tin', $tin);
            })
            ->pluck('idkelas')
            ->unique()
            ->values();

    $kelas = Tkelas::with(['tahunajaran', 'waliKelas'])
        ->withCount('jumlahsiswa')
        ->whereIn('id', $idKelasYangDiajar)
        ->where('tin', $tin)
        ->where('jen', $tin)
        ->whereHas('tahunajaran', function ($q) {
            $q->where('staakt', 1);
        })
        ->get();

            return view('page.kelas', compact('kelas', 'jenjang'));
    }

    public function kelas($id)
    {
        $akun   = Auth::guard('guru')->user();
        $idGuru = $akun->idguru;

        $bolehAkses = \App\Models\Tgurumengajar::where('idguru', $idGuru)
            ->where('idkelas', $id)
            ->exists();

        if (! $bolehAkses) {
            abort(403, 'Anda tidak memiliki akses ke kelas ini.');
        }

        $isikelas = Tkelas::withCount('jumlahsiswa')->findOrFail($id);

        return view('page.detailkelas', compact('isikelas'));
    }
}