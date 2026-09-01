<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRaporRequest;
use App\Http\Requests\UpdateRaporRequest;
use App\Services\RaporService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RaporController extends Controller
{
    public function __construct(private readonly RaporService $raporService)
    {
    }

    public function index(Request $request): View
    {
        $idKelas = $request->integer('idkelas');
        $idSiswa = $request->filled('idsiswa') ? $request->integer('idsiswa') : null;

        $siswaList = $this->raporService->daftarSiswaKelas($idKelas);
        $namaKelas = $this->raporService->namaKelas($idKelas);
        $idTa      = $this->raporService->idTahunAjaranAktif();

        return view('guru.rapor.index', [
            'siswaList' => $siswaList,
            'idKelas'   => $idKelas,
            'namaKelas' => $namaKelas,
            'idTa'      => $idTa,
            'idSiswa'   => $idSiswa,
        ]);
    }

    public function showSiswa(Request $request, int $idsiswa): View
    {
        $idKelas = $request->integer('idkelas');
        $idTa    = $request->integer('idta');

        $siswa     = $this->raporService->siswa($idsiswa);
        $raporList = $this->raporService->raporSiswa($idsiswa, $idKelas, $idTa);

        return view('guru.rapor.show', [
            'siswa'     => $siswa,
            'raporList' => $raporList,
            'idKelas'   => $idKelas,
            'idTa'      => $idTa,
        ]);
    }
    public function create(Request $request): View
    {
        $idKelas = $request->integer('idkelas');
        $idTa    = $request->integer('idta');

        $siswa      = $this->raporService->siswa($request->integer('idsiswa'));
        $jenisRapot = $this->raporService->jenisRapotAktif();

        return view('guru.rapor.create', [
            'jenisRapot' => $jenisRapot,
            'siswa'      => $siswa,
            'idKelas'    => $idKelas,
            'idTa'       => $idTa,
        ]);
    }

    public function store(StoreRaporRequest $request): RedirectResponse
    {
        $this->raporService->create(
            $request->validatedData(),
            $request->file('lampiran')
        );

        return redirect()
            ->route('guru.raporsiswa.show', [
                'idsiswa' => $request->integer('idsiswa'),
                'idkelas' => $request->integer('idkelas'),
                'idta'    => $request->integer('idta'),
            ])
            ->with('success', 'Rapor berhasil disimpan.');
    }

    public function edit(int $id): View
    {
        $rapor      = $this->raporService->find($id);
        $jenisRapot = $this->raporService->jenisRapotAktif();

        return view('guru.rapor.edit', compact('rapor', 'jenisRapot'));
    }

    public function update(UpdateRaporRequest $request, int $id): RedirectResponse
    {
        $rapor = $this->raporService->find($id);

        $this->raporService->update(
            $rapor,
            $request->validatedData(),
            $request->file('lampiran')
        );

        return redirect()
            ->route('guru.raporsiswa.show', [
                'idsiswa' => $rapor->idsiswa,
                'idkelas' => $rapor->idkelas,
                'idta'    => $rapor->idta,
            ])
            ->with('success', 'Rapor berhasil diperbarui.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $rapor = $this->raporService->find($id);

        $idsiswa = $rapor->idsiswa;
        $idkelas = $rapor->idkelas;
        $idta    = $rapor->idta;

        $this->raporService->delete($rapor);

        return redirect()
            ->route('guru.raporsiswa.show', compact('idsiswa', 'idkelas', 'idta'))
            ->with('success', 'Rapor berhasil dihapus.');
    }
}