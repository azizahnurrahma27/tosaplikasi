<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jurnal Konseling - {{ $siswaData->namlen ?? 'Siswa' }}</title>
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
            --gray-400: #94a3b8;
            --gray-500: #64748b;
            --gray-700: #334155;
            --gray-800: #1e293b;
            --radius: 12px;
            --radius-lg: 16px;
            --shadow-sm: 0 1px 2px rgba(26, 42, 74, 0.05);
            --shadow-md: 0 4px 6px rgba(26, 42, 74, 0.07), 0 2px 4px rgba(26, 42, 74, 0.06);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            --font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: var(--font-family); background: var(--gray-50); color: var(--gray-800); min-height: 100vh; line-height: 1.6; }
        .wrap { max-width: 1180px; margin: 0 auto; padding: 1.5rem; }

        .top-nav { display: flex; align-items: center; gap: 1rem; margin-bottom: 1.5rem; flex-wrap: wrap; }
        .btn-back {
            display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.65rem 1.5rem;
            background: var(--white); border: 1px solid var(--gray-200); border-radius: 50px;
            color: var(--gray-700); font-weight: 500; font-size: 0.875rem; text-decoration: none;
            transition: var(--transition); box-shadow: var(--shadow-sm);
        }
        .btn-back:hover { background: var(--primary-blue); border-color: var(--primary-blue); color: var(--white); transform: translateY(-2px); }
        .top-nav-title { font-size: 0.95rem; font-weight: 500; color: var(--gray-500); }
        .top-nav-title span { color: var(--primary-dark); font-weight: 600; }

        .header-row { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem; }
        .header-row h1 { font-size: 1.4rem; font-weight: 700; color: var(--primary-dark); display: flex; align-items: center; gap: 0.6rem; }

        .header-actions { display: flex; gap: 0.6rem; flex-wrap: wrap; }
        .btn-primary, .btn-outline {
            display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.7rem 1.3rem;
            border-radius: 50px; text-decoration: none; font-weight: 600; font-size: 0.85rem;
            transition: var(--transition); cursor: pointer; font-family: var(--font-family); border: none;
        }
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-blue), var(--primary-light));
            color: var(--white); box-shadow: var(--shadow-md);
        }
        .btn-primary:hover { transform: translateY(-2px); }
        .btn-outline {
            background: var(--white); color: var(--primary-blue); border: 1.5px solid var(--primary-blue);
        }
        .btn-outline:hover { background: var(--primary-blue); color: var(--white); }

        .filter-bar {
            display: flex; gap: 0.75rem; flex-wrap: wrap; background: var(--white); padding: 1rem;
            border-radius: var(--radius); box-shadow: var(--shadow-sm); border: 1px solid var(--gray-200); margin-bottom: 1.5rem;
        }
        .filter-bar input {
            padding: 0.6rem 1rem; border: 1px solid var(--gray-200); border-radius: 8px; font-family: var(--font-family); font-size: 0.875rem;
        }
        .filter-bar button {
            padding: 0.6rem 1.2rem; border: none; border-radius: 8px; background: var(--primary-dark); color: var(--white);
            font-weight: 600; font-size: 0.875rem; cursor: pointer; font-family: var(--font-family);
        }

        .alert-success {
            background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; padding: 0.9rem 1.25rem;
            border-radius: var(--radius); margin-bottom: 1.5rem; font-size: 0.9rem;
        }

        table { width: 100%; border-collapse: collapse; background: var(--white); border-radius: var(--radius); overflow: hidden; box-shadow: var(--shadow-sm); border: 1px solid var(--gray-200); }
        thead th {
            text-align: left; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; color: var(--gray-500);
            padding: 0.9rem 1.1rem; background: var(--gray-100); border-bottom: 1px solid var(--gray-200);
        }
        tbody td { padding: 0.9rem 1.1rem; border-bottom: 1px solid var(--gray-100); font-size: 0.9rem; vertical-align: top; }
        tbody tr:last-child td { border-bottom: none; }
        tbody tr:hover { background: var(--gray-50); }

        .desc-cell { max-width: 320px; color: var(--gray-700); }
        .badge-time { display: inline-block; background: var(--primary-bg); color: var(--primary-blue); padding: 0.15rem 0.6rem; border-radius: 50px; font-size: 0.78rem; font-weight: 600; }

        .action-cell { display: flex; gap: 0.5rem; white-space: nowrap; }
        .btn-icon {
            display: inline-flex; align-items: center; justify-content: center; width: 34px; height: 34px;
            border-radius: 8px; border: 1px solid var(--gray-200); background: var(--white); color: var(--gray-700);
            text-decoration: none; cursor: pointer; transition: var(--transition);
        }
        .btn-icon.edit:hover { background: var(--primary-blue); color: var(--white); border-color: var(--primary-blue); }
        .btn-icon.delete:hover { background: #dc2626; color: var(--white); border-color: #dc2626; }

        .empty-state { text-align: center; padding: 3rem 1rem; color: var(--gray-400); }
        .empty-state i { font-size: 2.5rem; display: block; margin-bottom: 0.5rem; }

        .pagination-wrap { margin-top: 1.25rem; }
    </style>
</head>
<body>
    <div class="wrap">
        <div class="top-nav">
            <a href="{{ route('guru.jurnalkonseling', $isikelas->id) }}" class="btn-back">
                <i class='bx bx-arrow-back'></i>
                Kembali ke Daftar Siswa
            </a>
            <div class="top-nav-title">
                Kelas <span>{{ $isikelas->nam ?? '' }}</span>
            </div>
        </div>

        @if (session('success'))
            <div class="alert-success">
                <i class='bx bx-check-circle'></i> {{ session('success') }}
            </div>
        @endif

        <div class="header-row">
            <h1><i class='bx bx-chat'></i> Jurnal Konseling — {{ $siswaData->namlen ?? '-' }}</h1>
            <div class="header-actions">
                <a href="{{ route('guru.jurnalkonseling.download-siswa-pdf', [$isikelas->id, $siswaData->id]) }}" class="btn-outline">
                    <i class='bx bxs-file-pdf'></i> Download Buku Kasus Siswa
                </a>

                <a href="{{ route('guru.jurnalkonseling.create', [$isikelas->id, $siswaData->id]) }}" class="btn-primary">
                    <i class='bx bx-plus'></i> Tambah Jurnal
                </a>
            </div>
        </div>

        <form method="GET" action="{{ route('guru.jurnalkonseling.show', [$isikelas->id, $siswaData->id]) }}" class="filter-bar">
            <input type="date" name="tanggal" value="{{ request('tanggal') }}">
            <button type="submit"><i class='bx bx-filter-alt'></i> Filter</button>
        </form>

        @if ($jurnal->count() === 0)
            <div class="empty-state">
                <i class='bx bx-chat'></i>
                Belum ada catatan jurnal konseling untuk siswa ini.
            </div>
        @else
            <table>
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Waktu</th>
                        <th>Deskripsi Kegiatan</th>
                        <th>Rencana Tindak Lanjut</th>
                        <th>Guru BK</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($jurnal as $item)
                        <tr>
                            <td>{{ optional($item->tanggal)->format('d M Y') }}</td>
                            <td>
                                <span class="badge-time">
                                    {{ optional($item->waktu_mulai)->format('H:i') }} - {{ optional($item->waktu_selesai)->format('H:i') }}
                                </span>
                            </td>
                            <td class="desc-cell">{{ \Illuminate\Support\Str::limit($item->deskripsi_kegiatan, 120) }}</td>
                            <td class="desc-cell">{{ \Illuminate\Support\Str::limit($item->rencana_tindak_lanjut, 120) }}</td>
                            <td>{{ $item->guru->Nam ?? '-' }}</td>
                            <td>
                                <div class="action-cell">
                                    <a class="btn-icon edit" title="Edit" href="{{ route('guru.jurnalkonseling.edit', [$isikelas->id, $item->id]) }}">
                                        <i class='bx bx-edit'></i>
                                    </a>
                                    <form method="POST" action="{{ route('guru.jurnalkonseling.destroy', [$isikelas->id, $item->id]) }}"
                                          onsubmit="return confirm('Hapus jurnal konseling ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-icon delete" title="Hapus">
                                            <i class='bx bx-trash'></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="pagination-wrap">
                {{ $jurnal->links() }}
            </div>
        @endif
    </div>
</body>
</html>