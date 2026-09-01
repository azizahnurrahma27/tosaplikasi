<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNilaiRequest;
use App\Models\Tkelas;
use App\Services\PenilaianService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PenilaianController extends Controller
{
    public function __construct(protected PenilaianService $service)
    {
    }

    public function index(int $idKelas): View
    {
        $kelas = Tkelas::findOrFail($idKelas);
        $mapel = $this->service->daftarMapelKelas($idKelas);

        return view('guru.penilaian.index', compact('kelas', 'mapel'));
    }

    public function show(int $idKelas, int $idPelajaran): View
    {
        $kelas    = Tkelas::findOrFail($idKelas);
        $mengajar = $this->service->pastikanBerhakMasuk($idKelas, $idPelajaran);

        [$siswaList, $nilaiTersimpan] = $this->service->siswaDenganNilai($idKelas, $idPelajaran);
        $jenisNilaiList  = $this->service->daftarJenisNilai();
        $semuaTugas      = $this->service->semuaTugasKonteks($idKelas, $idPelajaran);
        $catatanTugasMap = $this->service->catatanTugasTersimpan($idKelas, $idPelajaran);

        return view('guru.penilaian.show', [
            'kelas'           => $kelas,
            'pelajaran'       => $mengajar->pelajaran,
            'siswaList'       => $siswaList,
            'nilaiTersimpan'  => $nilaiTersimpan,
            'jenisNilaiList'  => $jenisNilaiList,
            'semuaTugas'      => $semuaTugas,
            'catatanTugasMap' => $catatanTugasMap,
        ]);
    }

    public function store(StoreNilaiRequest $request, int $idKelas, int $idPelajaran): RedirectResponse
    {
        $this->service->simpanNilai($idKelas, $idPelajaran, $request->validated()['nilai']);

        return redirect()
            ->route('guru.penilaiansiswa.show', ['idKelas' => $idKelas, 'idPelajaran' => $idPelajaran])
            ->with('success', 'Nilai berhasil disimpan.');
    }

    public function tugasByContext(Request $request, int $idKelas, int $idPelajaran): JsonResponse
    {
        $idSiswa = (int) $request->query('idsiswa');

        if (! $idSiswa) {
            return response()->json(['message' => 'idsiswa wajib diisi.'], 422);
        }

        return response()->json(
            $this->service->daftarTugasUntukKonteks($idKelas, $idPelajaran, $idSiswa)
        );
    }

    public function laporan(int $idKelas, int $idPelajaran): View
    {
        $kelas    = Tkelas::findOrFail($idKelas);
        $mengajar = $this->service->pastikanBerhakMasuk($idKelas, $idPelajaran);

        [$headerGroups, $rows] = $this->service->laporanNilai($idKelas, $idPelajaran);

        return view('guru.penilaian.laporan', [
            'kelas'        => $kelas,
            'pelajaran'    => $mengajar->pelajaran,
            'headerGroups' => $headerGroups,
            'rows'         => $rows,
        ]);
    }
}