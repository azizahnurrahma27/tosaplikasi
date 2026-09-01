<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informasi Kelas - {{ $isikelas->nam ?? 'Kelas' }}</title>
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
        .wrap { max-width: 1000px; margin: 0 auto; padding: 1.5rem; }

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
        .btn-primary {
            display: inline-flex; align-items: center; gap: .5rem; padding: .7rem 1.4rem;
            background: linear-gradient(135deg, var(--primary-blue), var(--primary-light));
            color: var(--white); border-radius: 50px; text-decoration: none; font-weight: 600;
            font-size: .875rem; box-shadow: var(--shadow-md); transition: var(--transition); border: none; cursor: pointer;
        }
        .btn-primary:hover { transform: translateY(-2px); }

        .alert-success {
            background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; padding: .9rem 1.25rem;
            border-radius: var(--radius); margin-bottom: 1.5rem; font-size: .9rem;
        }

        .info-list { display: flex; flex-direction: column; gap: 1rem; }
        .info-card {
            background: var(--white); border: 1px solid var(--gray-200); border-radius: var(--radius-lg);
            padding: 1.25rem 1.5rem; box-shadow: var(--shadow-sm); transition: var(--transition);
        }
        .info-card:hover { box-shadow: var(--shadow-md); }

        .info-top { display: flex; justify-content: space-between; align-items: flex-start; gap: 1rem; flex-wrap: wrap; }
        .info-title { font-size: 1.05rem; font-weight: 700; color: var(--primary-dark); margin-bottom: .3rem; }
        .info-date {
            display: inline-flex; align-items: center; gap: .3rem; font-size: .78rem; font-weight: 600;
            color: var(--primary-blue); background: var(--primary-bg); padding: .2rem .7rem; border-radius: 50px; white-space: nowrap;
        }
        .info-desc { color: var(--gray-700); font-size: .9rem; margin-top: .6rem; line-height: 1.5; }

        .info-file {
            display: inline-flex; align-items: center; gap: .4rem; margin-top: .8rem; font-size: .8rem;
            color: var(--primary-blue); text-decoration: none; font-weight: 600;
        }
        .info-file:hover { text-decoration: underline; }

        .action-cell { display: flex; gap: .5rem; margin-top: 1rem; }
        .btn-icon {
            display: inline-flex; align-items: center; justify-content: center; width: 34px; height: 34px;
            border-radius: 8px; border: 1px solid var(--gray-200); background: var(--white); color: var(--gray-700);
            text-decoration: none; cursor: pointer; transition: var(--transition);
        }
        .btn-icon.edit:hover { background: var(--primary-blue); color: var(--white); border-color: var(--primary-blue); }
        .btn-icon.delete:hover { background: #dc2626; color: var(--white); border-color: #dc2626; }

        .empty-state { text-align: center; padding: 3rem 1rem; color: var(--gray-400); }
        .empty-state i { font-size: 2.5rem; display: block; margin-bottom: .5rem; }

        .pagination-wrap { margin-top: 1.25rem; }
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
                Informasi <span>Kelas {{ $isikelas->nam ?? '' }}</span>
            </div>
        </div>

        @if (session('success'))
            <div class="alert-success">
                <i class='bx bx-check-circle'></i> {{ session('success') }}
            </div>
        @endif

        <div class="header-row">
            <h1><i class='bx bx-info-circle'></i> Informasi Kelas</h1>
            <a href="{{ route('guru.informasi.create', $isikelas->id) }}" class="btn-primary">
                <i class='bx bx-plus'></i> Tambah Informasi
            </a>
        </div>

        @if ($informasi->count() === 0)
            <div class="empty-state">
                <i class='bx bx-info-circle'></i>
                Belum ada informasi untuk kelas ini.
            </div>
        @else
            <div class="info-list">
                @foreach ($informasi as $item)
                    <div class="info-card">
                        <div class="info-top">
                            <div>
                                <div class="info-title">{{ $item->info }}</div>
                            </div>
                            <span class="info-date">
                                <i class='bx bx-calendar'></i>
                                {{ optional($item->tanggal)->format('d M Y') ?? \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}
                            </span>
                        </div>

                        @if ($item->deskripsi)
                            <div class="info-desc">{{ $item->deskripsi }}</div>
                        @endif

                        @if ($item->file_pendukung)
                            <a href="{{ Storage::disk('public')->url($item->file_pendukung) }}" target="_blank" class="info-file">
                                <i class='bx bx-paperclip'></i> Lihat File Pendukung
                            </a>
                        @endif

                        <div class="action-cell">
                            <a class="btn-icon edit" title="Edit" href="{{ route('guru.informasi.edit', [$isikelas->id, $item->id]) }}">
                                <i class='bx bx-edit'></i>
                            </a>
                            <form method="POST" action="{{ route('guru.informasi.destroy', [$isikelas->id, $item->id]) }}"
                                  onsubmit="return confirm('Hapus informasi ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-icon delete" title="Hapus">
                                    <i class='bx bx-trash'></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="pagination-wrap">
                {{ $informasi->links() }}
            </div>
        @endif
    </div>
</body>
</html>