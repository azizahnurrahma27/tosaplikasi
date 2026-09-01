<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catatan Kasus - {{ $kelas->nam ?? 'Kelas' }}</title>
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
            --gray-900: #0f172a;
            --danger: #c0392b;
            --danger-bg: #fdecea;
            --success: #1e7e34;
            --success-bg: #e6f4ea;
            --shadow-sm: 0 1px 2px rgba(26, 42, 74, 0.05);
            --shadow: 0 1px 3px rgba(26, 42, 74, 0.08), 0 1px 2px rgba(26, 42, 74, 0.06);
            --shadow-md: 0 4px 6px rgba(26, 42, 74, 0.07), 0 2px 4px rgba(26, 42, 74, 0.06);
            --shadow-lg: 0 10px 15px rgba(26, 42, 74, 0.10), 0 4px 6px rgba(26, 42, 74, 0.05);
            --radius: 12px;
            --radius-lg: 16px;
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
        .page-title { font-size: 1.25rem; font-weight: 600; color: var(--primary-dark); display: flex; align-items: center; gap: 0.5rem; }
        .page-title i { color: var(--primary-light); }

        .alert-success {
            background: var(--success-bg); color: var(--success); padding: 0.85rem 1.25rem;
            border-radius: var(--radius); margin-bottom: 1.25rem; font-size: 0.9rem; font-weight: 500;
        }

        .card-table { background: var(--white); border-radius: var(--radius); overflow: hidden; box-shadow: var(--shadow-sm); border: 1px solid var(--gray-200); }
        table { width: 100%; border-collapse: collapse; }
        thead tr { background: var(--primary-bg); text-align: left; }
        th { padding: 1rem 1.25rem; font-size: 0.85rem; color: var(--gray-600); font-weight: 600; text-transform: uppercase; letter-spacing: 0.03em; }
        td { padding: 1rem 1.25rem; font-size: 0.9rem; border-top: 1px solid var(--gray-200); }
        tbody tr { transition: var(--transition); }
        tbody tr:hover { background: var(--gray-50); }
        .text-center { text-align: center; }
        .poin-badge { font-weight: 700; }
        .poin-danger { color: var(--danger); }
        .poin-none { color: var(--gray-400); }
        .link-detail { color: var(--primary-blue); text-decoration: none; font-weight: 500; display: inline-flex; align-items: center; gap: 0.2rem; }
        .link-detail:hover { text-decoration: underline; }
        .empty-row { padding: 2.5rem; text-align: center; color: var(--gray-400); }

        @media (max-width: 640px) {
            .wrap { padding: 1rem; }
            th, td { padding: 0.75rem 0.85rem; font-size: 0.8rem; }
        }
    </style>
</head>
<body>
    <div class="wrap">
       <div class="top-nav">
    <a href="{{ route('guru.detailkelas', $kelas->id) }}" class="btn-back">
        <i class='bx bx-arrow-back'></i> Kembali
    </a>
    <div class="page-title">
        <i class='bx bx-note'></i> Catatan Kasus — Kelas {{ $kelas->nam }}
    </div>
    <a href="{{ route('guru.catatankasus.pdfkelas', $kelas->id) }}" target="_blank"
       style="margin-left:auto;display:inline-flex;align-items:center;gap:0.4rem;padding:0.65rem 1.5rem;background:var(--primary-blue);color:var(--white);border-radius:50px;text-decoration:none;font-size:0.875rem;font-weight:500;transition:var(--transition);box-shadow:var(--shadow-sm);">
        <i class='bx bx-printer'></i> Cetak Buku Kasus
    </a>
</div>
        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        <div class="card-table">
            <table>
                <thead>
                    <tr>
                        <th>Nama Siswa</th>
                        <th>NIS</th>
                        <th class="text-center">Jumlah Kasus</th>
                        <th class="text-center">Total Poin</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($siswaList as $siswa)
                        <tr>
                            <td>{{ $siswa->namlen ?? $siswa->nampan }}</td>
                            <td>{{ $siswa->nis }}</td>
                            <td class="text-center">{{ $siswa->total_kasus }}</td>
                            <td class="text-center">
                                <span class="poin-badge {{ $siswa->total_poin > 0 ? 'poin-danger' : 'poin-none' }}">
                                    {{ $siswa->total_poin }}
                                </span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('guru.catatankasus.show', ['idkelas' => $kelas->id, 'idsis' => $siswa->id]) }}" class="link-detail">
                                    Lihat Detail <i class='bx bx-chevron-right'></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="empty-row">Belum ada data siswa.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>