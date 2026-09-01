<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jurnal Konseling - {{ $isikelas->nam ?? 'Kelas' }}</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-dark: #1a2a4a; --primary-blue: #2c5f8a; --primary-light: #4a8fc7;
            --primary-bg: #f0f4f8; --white: #ffffff; --gray-50: #f8fafc; --gray-100: #f1f5f9;
            --gray-200: #e2e8f0; --gray-400: #94a3b8; --gray-500: #64748b; --gray-700: #334155; --gray-800: #1e293b;
            --radius: 12px; --radius-lg: 16px;
            --shadow-sm: 0 1px 2px rgba(26,42,74,.05); --shadow-md: 0 4px 6px rgba(26,42,74,.07), 0 2px 4px rgba(26,42,74,.06);
            --transition: all .3s cubic-bezier(.4,0,.2,1);
            --font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: var(--font-family); background: var(--gray-50); color: var(--gray-800); min-height: 100vh; line-height: 1.6; }
        .wrap { max-width: 1180px; margin: 0 auto; padding: 1.5rem; }

        .top-nav { display: flex; align-items: center; gap: 1rem; margin-bottom: 1.5rem; flex-wrap: wrap; }
        .btn-back {
            display: inline-flex; align-items: center; gap: .5rem; padding: .65rem 1.5rem;
            background: var(--white); border: 1px solid var(--gray-200); border-radius: 50px;
            color: var(--gray-700); font-weight: 500; font-size: .875rem; text-decoration: none;
            transition: var(--transition); box-shadow: var(--shadow-sm);
        }
        .btn-back:hover { background: var(--primary-blue); border-color: var(--primary-blue); color: var(--white); transform: translateY(-2px); }
        .top-nav-title { font-size: .95rem; font-weight: 500; color: var(--gray-500); }
        .top-nav-title span { color: var(--primary-dark); font-weight: 600; }

        .header-row { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem; }
        .header-row h1 { font-size: 1.5rem; font-weight: 700; color: var(--primary-dark); display: flex; align-items: center; gap: .6rem; }

        .header-actions { display: flex; gap: .6rem; flex-wrap: wrap; }
        .btn-primary, .btn-outline {
            display: inline-flex; align-items: center; gap: .5rem; padding: .7rem 1.3rem;
            border-radius: 50px; text-decoration: none; font-weight: 600; font-size: .85rem;
            transition: var(--transition); border: none; cursor: pointer; font-family: var(--font-family);
        }
        .btn-primary { background: linear-gradient(135deg, var(--primary-blue), var(--primary-light)); color: var(--white); box-shadow: var(--shadow-md); }
        .btn-primary:hover { transform: translateY(-2px); }
        .btn-outline { background: var(--white); color: var(--primary-blue); border: 1.5px solid var(--primary-blue); }
        .btn-outline:hover { background: var(--primary-blue); color: var(--white); }

        .alert-success {
            background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; padding: .9rem 1.25rem;
            border-radius: var(--radius); margin-bottom: 1.5rem; font-size: .9rem;
        }

        .siswa-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1rem; }
        .siswa-card {
            background: var(--white); border: 1px solid var(--gray-200); border-radius: var(--radius-lg);
            padding: 1.1rem 1.25rem; text-decoration: none; color: inherit; box-shadow: var(--shadow-sm);
            transition: var(--transition); display: flex; align-items: flex-start; gap: .9rem;
        }
        .siswa-card:hover { box-shadow: var(--shadow-md); transform: translateY(-3px); border-color: var(--primary-light); }

        .siswa-avatar {
            width: 44px; height: 44px; border-radius: 50%; background: var(--primary-bg); color: var(--primary-blue);
            display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: .95rem; flex-shrink: 0;
        }
        .siswa-info { flex: 1; min-width: 0; }
        .siswa-nama {
            font-weight: 600; color: var(--primary-dark); font-size: .95rem; line-height: 1.3;
            display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
        }
        .siswa-meta { font-size: .78rem; color: var(--gray-500); margin-top: .3rem; }

        .badge-count {
            display: inline-block; margin-top: .5rem;
            background: var(--primary-bg); color: var(--primary-blue); font-size: .75rem; font-weight: 700;
            padding: .2rem .6rem; border-radius: 50px; white-space: nowrap;
        }
        .badge-count.zero { background: var(--gray-100); color: var(--gray-500); }

        .empty-state { text-align: center; padding: 3rem 1rem; color: var(--gray-400); }
        .empty-state i { font-size: 2.5rem; display: block; margin-bottom: .5rem; }
    </style>
</head>
<body>
    <div class="wrap">
        <div class="top-nav">
            <a href="{{ route('guru.detailkelas', $isikelas->id) }}" class="btn-back">
                <i class='bx bx-arrow-back'></i>
                Kembali ke Dashboard Kelas
            </a>
            <div class="top-nav-title">
                Jurnal Konseling <span>Kelas {{ $isikelas->nam ?? '' }}</span>
            </div>
        </div>

        @if (session('success'))
            <div class="alert-success">
                <i class='bx bx-check-circle'></i> {{ session('success') }}
            </div>
        @endif

        <div class="header-row">
            <h1><i class='bx bx-chat'></i> Pilih Siswa</h1>
            <div class="header-actions">
                <a href="{{ route('guru.jurnalkonseling.download-pdf', $isikelas->id) }}" class="btn-outline">
                    <i class='bx bxs-file-pdf'></i> Download Buku Kasus Kelas
                </a>
            </div>
        </div>

        @if ($siswa->isEmpty())
            <div class="empty-state">
                <i class='bx bx-user-x'></i>
                Belum ada siswa terdaftar di kelas ini pada tahun ajaran aktif.
            </div>
        @else
            <div class="siswa-grid">
                @foreach ($siswa as $s)
                    <a href="{{ route('guru.jurnalkonseling.show', [$isikelas->id, $s->id]) }}" class="siswa-card">
                        <div class="siswa-avatar">{{ strtoupper(substr($s->namlen ?? '-', 0, 2)) }}</div>
                        <div class="siswa-info">
                            <div class="siswa-nama">{{ $s->namlen ?? '-' }}</div>
                            <div class="siswa-meta">NIS: {{ $s->nis ?? '-' }}</div>
                            <div class="badge-count {{ $s->jumlah_jurnal == 0 ? 'zero' : '' }}">
                                {{ $s->jumlah_jurnal }} jurnal
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</body>
</html>