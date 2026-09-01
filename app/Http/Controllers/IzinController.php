<?php

namespace App\Http\Controllers;

use App\Models\Tkelas;
use App\Models\Tizinjenis;
use App\Services\IzinService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IzinController extends Controller
{
    public function __construct(
        private readonly IzinService $izinService
    ) {}

    public function byKelas(Request $request, int $id)
    {
        $isikelas    = Tkelas::findOrFail($id);
        $filters     = $request->only(['jen', 'tgl']);
        $izinList    = $this->izinService->paginateByKelas($id, $filters);
        $jenisList   = Tizinjenis::select('id', 'title')->get();
        $activeTgl   = $request->input('tgl', '');
        $isWaliKelas = $this->izinService->isWaliKelas($id, $this->currentKaryawanId());

        return view('izin.index', compact(
            'isikelas', 'izinList', 'jenisList', 'activeTgl', 'isWaliKelas'
        ));
    }

    public function pendingByKelas(int $id)
    {
        $isikelas = Tkelas::findOrFail($id);

        $this->authorizeWaliKelas($id);

        $izinList = $this->izinService->paginatePendingByKelas($id);

        return view('izin.pending', compact('isikelas', 'izinList'));
    }

    public function approve(int $idkel, int $izin)
    {
        $this->authorizeWaliKelas($idkel);

        $this->izinService->approve($izin, $this->currentKaryawanId());

        return back()->with('success', 'Izin berhasil disetujui.');
    }

    public function reject(Request $request, int $idkel, int $izin)
    {
        $this->authorizeWaliKelas($idkel);

        $request->validate([
            'alasan_tolak' => 'nullable|string|max:500',
        ]);

        $this->izinService->reject($izin, $this->currentKaryawanId(), $request->input('alasan_tolak'));

        return back()->with('success', 'Izin berhasil ditolak.');
    }

    private function authorizeWaliKelas(int $idkel): void
    {
        if (!$this->izinService->isWaliKelas($idkel, $this->currentKaryawanId())) {
            abort(403, 'Hanya wali kelas yang dapat menyetujui/menolak izin ini.');
        }
    }

    private function currentKaryawanId(): ?string
    {
        return Auth::guard('guru')->user()?->idguru;
    }
}