<?php

namespace App\Http\Controllers;

use App\Models\Tinformasi;
use App\Models\Tkelas;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class InformasiController extends Controller
{
    public function index(int $idkelas): View
    {
        $isikelas = Tkelas::findOrFail($idkelas);

        $informasi = Tinformasi::where('idkel', $idkelas)
            ->orderByDesc('tanggal')
            ->orderByDesc('id')
            ->paginate(10);

        return view('guru.informasi.index', compact('isikelas', 'informasi'));
    }

    public function create(int $idkelas): View
    {
        $isikelas = Tkelas::findOrFail($idkelas);

        return view('guru.informasi.create', compact('isikelas'));
    }

    public function store(Request $request, int $idkelas): RedirectResponse
    {
        $isikelas = Tkelas::findOrFail($idkelas);

        $validated = $request->validate([
            'tanggal'         => 'required|date',
            'info'            => 'required|string|max:255',
            'deskripsi'       => 'nullable|string',
            'file_pendukung'  => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
        ], [], [
            'info'      => 'Judul Informasi',
            'tanggal'   => 'Tanggal',
            'deskripsi' => 'Deskripsi',
        ]);

        $data = [
            'idkel'     => $isikelas->id,
            'tanggal'   => $validated['tanggal'],
            'info'      => $validated['info'],
            'deskripsi' => $validated['deskripsi'] ?? null,
        ];

        if ($request->hasFile('file_pendukung')) {
            $data['file_pendukung'] = $request->file('file_pendukung')
                ->store('informasi', 'public');
        }

        Tinformasi::create($data);

        return redirect()
            ->route('guru.informasi.index', $isikelas->id)
            ->with('success', 'Informasi berhasil ditambahkan.');
    }

    public function edit(int $idkelas, int $id): View
    {
        $isikelas = Tkelas::findOrFail($idkelas);

        $informasi = Tinformasi::where('idkel', $idkelas)->findOrFail($id);

        return view('guru.informasi.edit', compact('isikelas', 'informasi'));
    }

    public function update(Request $request, int $idkelas, int $id): RedirectResponse
    {
        $isikelas = Tkelas::findOrFail($idkelas);

        $informasi = Tinformasi::where('idkel', $idkelas)->findOrFail($id);

        $validated = $request->validate([
            'tanggal'         => 'required|date',
            'info'            => 'required|string|max:255',
            'deskripsi'       => 'nullable|string',
            'file_pendukung'  => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
            'hapus_file'      => 'nullable|boolean',
        ], [], [
            'info'      => 'Judul Informasi',
            'tanggal'   => 'Tanggal',
            'deskripsi' => 'Deskripsi',
        ]);

        $data = [
            'tanggal'   => $validated['tanggal'],
            'info'      => $validated['info'],
            'deskripsi' => $validated['deskripsi'] ?? null,
        ];

        // Ganti file baru → hapus file lama
        if ($request->hasFile('file_pendukung')) {
            if ($informasi->file_pendukung) {
                Storage::disk('public')->delete($informasi->file_pendukung);
            }
            $data['file_pendukung'] = $request->file('file_pendukung')
                ->store('informasi', 'public');
        }
        // Centang "hapus file" tanpa upload file baru
        elseif ($request->boolean('hapus_file') && $informasi->file_pendukung) {
            Storage::disk('public')->delete($informasi->file_pendukung);
            $data['file_pendukung'] = null;
        }

        $informasi->update($data);

        return redirect()
            ->route('guru.informasi.index', $isikelas->id)
            ->with('success', 'Informasi berhasil diperbarui.');
    }

    public function destroy(int $idkelas, int $id): RedirectResponse
    {
        $informasi = Tinformasi::where('idkel', $idkelas)->findOrFail($id);

        if ($informasi->file_pendukung) {
            Storage::disk('public')->delete($informasi->file_pendukung);
        }

        $informasi->delete();

        return redirect()
            ->route('guru.informasi.index', $idkelas)
            ->with('success', 'Informasi berhasil dihapus.');
    }
}