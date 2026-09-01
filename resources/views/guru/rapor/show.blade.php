<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rapor - {{ $siswa->namlen }}</title>
    @include('guru.rapor._styles')
</head>
<body>
<div class="page">

    <a href="{{ route('guru.raporsiswa', ['idkelas' => $idKelas, 'idta' => $idTa]) }}" class="back-link">
        &larr; Kembali
    </a>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="title-row">
        <h1 class="title">{{ $siswa->namlen }}</h1>
        <a
            href="{{ route('guru.raporsiswa.create', ['idsiswa' => $siswa->id, 'idkelas' => $idKelas, 'idta' => $idTa]) }}"
            class="btn btn-primary btn-sm"
        >
            + Tambah Rapor
        </a>
    </div>

    <div class="card">
        <ul class="siswa-list">
            @forelse ($raporList as $rapor)
                <li class="siswa-item" style="cursor: default;">
                    <span class="siswa-num"><i class='bx bx-file'></i></span>

                    <span class="siswa-name">
                        {{ $rapor->jenisRapot->nama ?? '-' }}
                        <div style="font-weight: 400; font-size: 12px; color: var(--muted); margin-top: 2px;">
                            {{ $rapor->tanggal?->format('d M Y') }}
                            @if ($rapor->deskripsi)
                                &middot; {{ \Illuminate\Support\Str::limit($rapor->deskripsi, 60) }}
                            @endif
                        </div>
                    </span>

                    <div style="display:flex; align-items:center; gap: 8px;">
                        @if ($rapor->lampiran)
                            <a
                                href="{{ \Illuminate\Support\Facades\Storage::url($rapor->lampiran) }}"
                                target="_blank"
                                rel="noopener"
                                class="btn btn-ghost btn-sm"
                            >
                                Lihat File
                            </a>
                        @endif

                        <a
                            href="{{ route('guru.raporsiswa.edit', $rapor->id) }}"
                            class="btn btn-ghost btn-sm"
                        >
                            Edit
                        </a>

                        <form
                            action="{{ route('guru.raporsiswa.destroy', $rapor->id) }}"
                            method="POST"
                            onsubmit="return confirm('Yakin hapus rapor ini?');"
                        >
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger-ghost btn-sm">Hapus</button>
                        </form>
                    </div>
                </li>
            @empty
                <li class="empty-state">
                    Belum ada rapor untuk siswa ini pada tahun ajaran berjalan.
                </li>
            @endforelse
        </ul>
    </div>

</div>
</body>
</html>