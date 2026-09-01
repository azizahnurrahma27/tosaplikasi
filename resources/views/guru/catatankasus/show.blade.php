<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catatan Kasus - {{ $siswa->namlen ?? $siswa->nampan }}</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-dark: #1a2a4a;
            --primary-blue: #2c5f8a;
            --primary-light: #4a8fc7;
            --primary-bg: #f0f4f8;
            --white: #ffffff;
            --gray-50: #f8fafc;
            --gray-100: #f1f5f9;
            --gray-200: #e2e8f0;
            --gray-300: #cbd5e1;
            --gray-400: #94a3b8;
            --gray-500: #64748b;
            --gray-600: #475569;
            --gray-700: #334155;
            --gray-800: #1e293b;
            --danger: #c0392b;
            --danger-bg: #fdecea;
            --success: #1e7e34;
            --success-bg: #e6f4ea;
            --shadow-sm: 0 1px 2px rgba(26, 42, 74, 0.05);
            --shadow-md: 0 4px 6px rgba(26, 42, 74, 0.07), 0 2px 4px rgba(26, 42, 74, 0.06);
            --radius: 12px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            --font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: var(--font-family); background: var(--gray-50); color: var(--gray-800); min-height: 100vh; line-height: 1.6; }
        .wrap { max-width: 1100px; margin: 0 auto; padding: 1.5rem; }

        .top-nav { display: flex; align-items: center; gap: 1rem; margin-bottom: 1.5rem; flex-wrap: wrap; }
        .btn-back {
            display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.65rem 1.5rem;
            background: var(--white); border: 1px solid var(--gray-200); border-radius: 50px;
            color: var(--gray-700); font-weight: 500; font-size: 0.875rem; font-family: var(--font-family);
            text-decoration: none; transition: var(--transition); box-shadow: var(--shadow-sm);
        }
        .btn-back:hover { background: var(--primary-blue); border-color: var(--primary-blue); color: var(--white); transform: translateY(-2px); box-shadow: var(--shadow-md); }
        .page-title { font-size: 1.1rem; font-weight: 600; color: var(--primary-dark); }
        .btn-add {
            margin-left: auto; display: inline-flex; align-items: center; gap: 0.4rem;
            padding: 0.65rem 1.5rem; background: var(--primary-blue); color: var(--white);
            border-radius: 50px; text-decoration: none; font-size: 0.875rem; font-weight: 500;
            transition: var(--transition); box-shadow: var(--shadow-sm);
        }
        .btn-add:hover { background: var(--primary-dark); transform: translateY(-2px); box-shadow: var(--shadow-md); }

        .alert-success {
            background: var(--success-bg); color: var(--success); padding: 0.85rem 1.25rem;
            border-radius: var(--radius); margin-bottom: 1.25rem; font-size: 0.9rem; font-weight: 500;
        }

        .kasus-card {
            background: var(--white); border: 1px solid var(--gray-200); border-radius: var(--radius);
            padding: 1.25rem 1.5rem; margin-bottom: 1rem; box-shadow: var(--shadow-sm);
        }
        .kasus-head { display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem; flex-wrap: wrap; gap: 0.5rem; }
        .kasus-tanggal { font-weight: 600; color: var(--primary-dark); }
        .kasus-poin { background: var(--danger-bg); color: var(--danger); padding: 0.2rem 0.8rem; border-radius: 50px; font-size: 0.8rem; font-weight: 600; }
        .kasus-desc { margin: 0.5rem 0; color: var(--gray-700); font-size: 0.9rem; }
        .kasus-foot { display: flex; justify-content: space-between; align-items: center; margin-top: 0.75rem; flex-wrap: wrap; gap: 0.5rem; }
        .kasus-guru { font-size: 0.8rem; color: var(--gray-500); }
        .kasus-actions { display: flex; gap: 0.75rem; align-items: center; }
        .link-edit { color: var(--primary-blue); font-size: 0.85rem; text-decoration: none; font-weight: 500; }
        .link-edit:hover { text-decoration: underline; }
        .btn-delete { border: none; background: none; color: var(--danger); font-size: 0.85rem; cursor: pointer; font-family: var(--font-family); font-weight: 500; padding: 0; }
        .btn-delete:hover { text-decoration: underline; }

        .empty-state { color: var(--gray-400); text-align: center; padding: 3rem 1.5rem; background: var(--white); border-radius: var(--radius); border: 1px solid var(--gray-200); }

        @media (max-width: 640px) {
            .wrap { padding: 1rem; }
            .btn-add { margin-left: 0; width: 100%; justify-content: center; }
        }
    </style>
</head>
<body>
    <div class="wrap">
        <div class="top-nav">
            <a href="{{ route('guru.catatankasus', $kelas->id) }}" class="btn-back">
                <i class='bx bx-arrow-back'></i> Kembali
            </a>
            <div class="page-title">Catatan Kasus — {{ $siswa->namlen ?? $siswa->nampan }}</div>
            <a href="{{ route('guru.catatankasus.create', ['idkelas' => $kelas->id, 'idsis' => $siswa->id]) }}" class="btn-add">
                <i class='bx bx-plus'></i> Tambah Catatan
            </a>
            <a href="{{ route('guru.catatankasus.pdf', ['idkelas' => $kelas->id, 'idsis' => $siswa->id]) }}"
            target="_blank" class="btn-add" style="background: var(--gray-700);">
                <i class='bx bx-printer'></i> Cetak Buku Kasus
            </a>
        </div>

        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        @forelse($catatan as $item)
            <div class="kasus-card">
                <div class="kasus-head">
                    <span class="kasus-tanggal">{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}</span>
                    <span class="kasus-poin">{{ $item->jumlah_poin }} Poin</span>
                </div>
                <p class="kasus-desc">{{ $item->deskripsi_kasus }}</p>
                <div class="kasus-foot">
                    <span class="kasus-guru">Dicatat oleh: {{ $item->guru->nam ?? '-' }}</span>
                    <div class="kasus-actions">
                        <a href="{{ route('guru.catatankasus.edit', ['idkelas' => $kelas->id, 'id' => $item->id]) }}" class="link-edit">Edit</a>
                        <form action="{{ route('guru.catatankasus.destroy', ['idkelas' => $kelas->id, 'id' => $item->id]) }}" method="POST" onsubmit="return confirm('Hapus catatan ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-delete">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="empty-state">Belum ada catatan kasus untuk siswa ini.</div>
        @endforelse
    </div>
</body>
</html>