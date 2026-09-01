<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Nilai {{ $pelajaran->nam ?? '' }} - {{ $kelas->nam ?? 'Kelas' }}</title>
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
            --shadow: 0 1px 3px rgba(26, 42, 74, 0.08), 0 1px 2px rgba(26, 42, 74, 0.06);
            --shadow-md: 0 4px 6px rgba(26, 42, 74, 0.07), 0 2px 4px rgba(26, 42, 74, 0.06);
            --shadow-sm: 0 1px 2px rgba(26, 42, 74, 0.05);
            --radius: 12px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            --font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: var(--font-family); background: var(--gray-50); color: var(--gray-800); min-height: 100vh; line-height: 1.6; }

        .dashboard { max-width: 100%; margin: 0 auto; padding: 1.5rem; }

        .top-nav { display: flex; align-items: center; gap: 1rem; margin-bottom: 1.5rem; padding: 0.5rem 0; flex-wrap: wrap; }
        .btn-back {
            display: inline-flex; align-items: center; gap: 0.5rem;
            padding: 0.65rem 1.5rem; background: var(--white); border: 1px solid var(--gray-200);
            border-radius: 50px; color: var(--gray-700); font-weight: 500; font-size: 0.875rem;
            font-family: var(--font-family); text-decoration: none; transition: var(--transition); box-shadow: var(--shadow-sm);
        }
        .btn-back:hover { background: var(--primary-blue); border-color: var(--primary-blue); transform: translateY(-2px); box-shadow: var(--shadow-md); color: var(--white); }
        .btn-back i { font-size: 1.2rem; line-height: 1; }
        .top-nav-title { font-size: 0.95rem; font-weight: 500; color: var(--gray-500); margin-left: 0.5rem; }
        .top-nav-title span { color: var(--primary-dark); font-weight: 600; }

        .page-header { margin-bottom: 1.5rem; }
        .page-header .eyebrow { font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; color: var(--primary-light); font-weight: 600; }
        .page-header h1 { font-size: 1.5rem; color: var(--primary-dark); margin: 0.2rem 0 0; }

        .table-wrap {
            background: var(--white);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            overflow-x: auto;
            border: 1px solid var(--gray-800);
        }
        table.matrix { width: 100%; border-collapse: collapse; min-width: 640px; }
        table.matrix th, table.matrix td {
            border: 1px solid var(--gray-800);
            padding: 0.55rem 0.7rem;
            font-size: 0.85rem;
            vertical-align: middle;
            text-align: center;
        }
        table.matrix thead th {
            background: var(--primary-bg);
            color: var(--gray-800);
            font-size: 0.74rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }
        table.matrix thead .th-judul {
            font-size: 0.7rem;
            text-transform: none;
            font-weight: 600;
            color: var(--gray-700);
            background: var(--gray-100);
        }
        table.matrix .col-nama {
            text-align: left;
            min-width: 170px;
            position: sticky;
            left: 0;
            background: var(--white);
            z-index: 1;
        }
        thead .col-nama { background: var(--primary-bg); z-index: 2; }

        .siswa-nama { font-weight: 700; color: var(--gray-800); }
        .siswa-nis { font-size: 0.72rem; color: var(--gray-500); }

        .cell-nilai {
            font-weight: 700;
            color: var(--gray-800);
            font-size: 0.9rem;
        }
        .cell-empty { color: var(--gray-400); font-weight: 400; }

        .empty-global {
            background: var(--white); border-radius: var(--radius); box-shadow: var(--shadow);
            padding: 2.5rem 1rem; text-align: center; color: var(--gray-400); font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            .dashboard { padding: 1rem; }
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <div class="top-nav">
            <a href="{{ route('guru.penilaiansiswa.show', ['idKelas' => $kelas->id, 'idPelajaran' => $pelajaran->id]) }}" class="btn-back">
                <i class='bx bx-arrow-back'></i>
                Kembali
            </a>
            <div class="top-nav-title">
                <i class='bx bx-bar-chart-alt-2' style="margin-right: 0.3rem;"></i>
                Laporan Nilai <span>Kelas {{ $kelas->nam }}</span>
            </div>
        </div>

        <div class="page-header">
            <div class="eyebrow">Kelas {{ $kelas->nam }} &middot; Laporan Nilai</div>
            <h1>{{ $pelajaran->nam }}</h1>
        </div>

        @if ($headerGroups->isEmpty())
            <div class="empty-global">
                <i class='bx bx-inbox' style="font-size: 2rem; display:block; margin-bottom: 0.5rem;"></i>
                Belum ada nilai yang tercatat untuk mata pelajaran ini.
            </div>
        @else
            <div class="table-wrap">
                <table class="matrix">
                    <thead>
                        <tr>
                            <th class="col-nama" rowspan="2">Nama Siswa</th>
                            @foreach ($headerGroups as $group)
                                @if ($group->kolom->count() === 1 && $group->kolom->first()->judul === null)
                                    <th rowspan="2">{{ $group->jenis->nama }}</th>
                                @else
                                    <th colspan="{{ $group->kolom->count() }}">{{ $group->jenis->nama }}</th>
                                @endif
                            @endforeach
                        </tr>
                        <tr>
                            @foreach ($headerGroups as $group)
                                @if ($group->kolom->count() === 1 && $group->kolom->first()->judul === null)
                                    {{-- sudah rowspan di baris atas, tidak perlu sel di sini --}}
                                @else
                                    @foreach ($group->kolom as $kolom)
                                        <th class="th-judul">{{ $kolom->judul ?? '—' }}</th>
                                    @endforeach
                                @endif
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rows as $row)
                            <tr>
                                <td class="col-nama">
                                    <div class="siswa-nama">{{ $row->siswa->namlen }}</div>
                                    <div class="siswa-nis">NIS {{ $row->siswa->nis }}</div>
                                </td>
                                @foreach ($headerGroups as $group)
                                    @foreach ($group->kolom as $kolom)
                                        @php $nilaiSel = $row->cells->get($kolom->key); @endphp
                                        <td>
                                            @if ($nilaiSel !== null)
                                                <span class="cell-nilai">{{ $nilaiSel }}</span>
                                            @else
                                                <span class="cell-empty">-</span>
                                            @endif
                                        </td>
                                    @endforeach
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</body>
</html>