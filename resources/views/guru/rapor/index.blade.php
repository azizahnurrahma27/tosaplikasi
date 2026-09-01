<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rapor</title>
    @include('guru.rapor._styles')
    <style>
        .k-back { display:inline-flex; align-items:center; gap:6px; font-size:12px; color:rgba(0,0,0,0.5); text-decoration:none; margin-bottom:14px; }
        .k-back:hover { color:#0D2B5E; }
    </style>
</head>
<body>
<div class="page">

    @if ($idSiswa)
        <a href="{{ route('guru.siswa', $idSiswa) }}" class="k-back">
            &lsaquo; Kembali ke Detail Siswa
        </a>
    @else
        <a href="{{ route('guru.detailkelas', $idKelas) }}" class="k-back">
            &lsaquo; Kembali ke Detail Kelas
        </a>
    @endif

    <div class="title-row">
        <h1 class="title">Rapor</h1>
        <span class="badge-kelas">Kelas {{ $namaKelas ?? '-' }}</span>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <ul class="siswa-list">
            @forelse ($siswaList as $i => $siswa)
                <li>
                    <a
                        href="{{ route('guru.raporsiswa.show', ['idsiswa' => $siswa->id, 'idkelas' => $idKelas, 'idta' => $idTa]) }}"
                        class="siswa-item"
                    >
                        <span class="siswa-num">{{ $i + 1 }}</span>
                        <span class="siswa-name">{{ $siswa->namlen }}</span>

                        @if ($siswa->rapor_count > 0)
                            <span class="siswa-status status-ada">{{ $siswa->rapor_count }} rapor</span>
                        @else
                            <span class="siswa-status status-belum">Belum ada</span>
                        @endif

                        <span class="chevron">&rsaquo;</span>
                    </a>
                </li>
            @empty
                <li class="empty-state">
                    Belum ada siswa di kelas ini.
                </li>
            @endforelse
        </ul>
    </div>

</div>
</body>
</html>