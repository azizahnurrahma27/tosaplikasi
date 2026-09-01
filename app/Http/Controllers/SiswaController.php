<?php

namespace App\Http\Controllers;

use App\Models\Tkelas;
use App\Models\Tkelsis;
use App\Models\Tsiswa;

class SiswaController extends Controller
{
        public function siswa($id){
        $isikelas = Tkelas::findOrFail($id);

        $siswa    = Tkelsis::with(['siswa','detailsiswa','kelas'])
                  ->where('idkel',$id)
                  ->get();
        return view('siswa.siswakelas', compact('siswa','isikelas'));
    }

    public function datasiswa($id){

        $detailsiswa    = Tsiswa::with('detailsiswa', 'detail', 'kelas.tahunajaran')
                         ->findOrFail($id);
        $namakelas      = $detailsiswa->kel;
        if($detailsiswa->detailsiswa && $detailsiswa->detailsiswa->img){
            $detailsiswa->detailsiswa->img_base64 = base64_encode($detailsiswa->detailsiswa->img);
        }
        return view('siswa.detailsiswa',compact('detailsiswa','namakelas') );
    }

}
