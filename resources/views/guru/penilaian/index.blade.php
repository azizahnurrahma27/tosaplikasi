<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Nilai - {{ $kelas->nam ?? 'Kelas' }}</title>
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
            --gray-700: #334155;
            --gray-800: #1e293b;
            --success-bg: #ecfdf5;
            --success-text: #047857;
            --success-border: #a7f3d0;
            --shadow-sm: 0 1px 2px rgba(26, 42, 74, 0.05);
            --shadow: 0 1px 3px rgba(26, 42, 74, 0.08), 0 1px 2px rgba(26, 42, 74, 0.06);
            --shadow-md: 0 4px 6px rgba(26, 42, 74, 0.07), 0 2px 4px rgba(26, 42, 74, 0.06);
            --shadow-lg: 0 10px 15px rgba(26, 42, 74, 0.10), 0 4px 6px rgba(26, 42, 74, 0.05);
            --radius: 12px;
            --radius-lg: 16px;
            --transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            --font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: var(--font-family); background: var(--gray-50); color: var(--gray-800); min-height: 100vh; line-height: 1.6; }

        .dashboard { max-width: 1100px; margin: 0 auto; padding: 1.5rem; }

        /* Top nav */
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

        /* Header */
        .page-header {
            margin-bottom: 1.75rem; padding: 1.5rem 1.75rem; border-radius: var(--radius-lg);
            background: linear-gradient(135deg, var(--primary-dark), var(--primary-blue));
            box-shadow: var(--shadow-md); color: var(--white);
        }
        .page-header .eyebrow { font-size: 0.72rem; text-transform: uppercase; letter-spacing: 0.08em; color: rgba(255,255,255,0.7); font-weight: 600; }
        .page-header h1 { font-size: 1.5rem; margin: 0.3rem 0 0.35rem; color: var(--white); }
        .page-header p { color: rgba(255,255,255,0.85); font-size: 0.88rem; margin: 0; }

        /* Empty state */
        .empty-state {
            display: flex; flex-direction: column; align-items: center; gap: 0.6rem;
            color: var(--gray-400); font-size: 0.9rem; padding: 3rem 1rem; text-align: center;
            background: var(--white); border: 1px dashed var(--gray-300); border-radius: var(--radius-lg);
        }
        .empty-state i { font-size: 2.2rem; color: var(--gray-300); }

        /* Mapel grid -> card based */
        .mapel-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 1rem; }

        .mapel-card {
            position: relative; display: flex; flex-direction: column; gap: 0.9rem;
            padding: 1.25rem 1.35rem; border-radius: var(--radius-lg);
            border: 1px solid var(--gray-200); background: var(--white);
            text-decoration: none; color: inherit; transition: var(--transition);
            box-shadow: var(--shadow-sm);
        }
        .mapel-card:hover {
            border-color: var(--primary-light); box-shadow: var(--shadow-lg);
            transform: translateY(-3px);
        }
        .mapel-card.disabled {
            cursor: not-allowed; background: var(--gray-50); opacity: 0.7;
        }
        .mapel-card.disabled:hover { transform: none; box-shadow: var(--shadow-sm); border-color: var(--gray-200); }

        .mapel-top { display: flex; align-items: flex-start; justify-content: space-between; gap: 0.75rem; }

        .mapel-icon {
            width: 44px; height: 44px; flex-shrink: 0; border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            background: linear-gradient(135deg, var(--primary-blue), var(--primary-light));
            color: var(--white); font-size: 1.3rem;
        }
        .mapel-card.disabled .mapel-icon { background: var(--gray-300); }

        .mapel-nama { font-size: 1rem; font-weight: 600; color: var(--primary-dark); line-height: 1.35; }
        .mapel-card.disabled .mapel-nama { color: var(--gray-500); }

        .status-pill {
            display: inline-flex; align-items: center; gap: 0.3rem;
            padding: 0.3rem 0.7rem; border-radius: 50px; font-size: 0.68rem; font-weight: 600;
            white-space: nowrap; text-transform: uppercase; letter-spacing: 0.02em;
        }
        .status-pill.mine { background: var(--success-bg); color: var(--success-text); border: 1px solid var(--success-border); }
        .status-pill.other { background: var(--gray-100); color: var(--gray-400); border: 1px solid var(--gray-200); }

        .mapel-guru {
            display: flex; align-items: center; gap: 0.5rem;
            padding-top: 0.75rem; border-top: 1px solid var(--gray-100);
            font-size: 0.8rem; color: var(--gray-500);
        }
        .mapel-guru i { font-size: 1rem; color: var(--gray-400); }
        .mapel-guru b { color: var(--gray-700); font-weight: 600; }
        .mapel-card.disabled .mapel-guru b { color: var(--gray-500); }

        .mapel-cta {
            display: flex; align-items: center; gap: 0.35rem;
            font-size: 0.8rem; font-weight: 600; color: var(--primary-blue);
        }
        .mapel-cta i { font-size: 1rem; transition: var(--transition); }
        .mapel-card:hover .mapel-cta i { transform: translateX(4px); }

        @media (max-width: 480px) {
            .dashboard { padding: 1rem; }
            .page-header { padding: 1.15rem 1.25rem; }
            .page-header h1 { font-size: 1.25rem; }
            .mapel-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <div class="top-nav">
            <a href="{{ route('guru.detailkelas', $kelas->id) }}" class="btn-back">
                <i class='bx bx-arrow-back'></i>
                Kembali
            </a>
            <div class="top-nav-title">
                <i class='bx bxs-dashboard' style="margin-right: 0.3rem;"></i>
                Input Nilai <span>Kelas {{ $kelas->nam ?? '' }}</span>
            </div>
        </div>

        <div class="page-header">
            <div class="eyebrow">Penilaian</div>
            <h1>Pilih Mata Pelajaran</h1>
            <p>Anda hanya bisa membuka mata pelajaran yang Anda ampu.</p>
        </div>

        @if ($mapel->isEmpty())
            <div class="empty-state">
                <i class='bx bx-book-open'></i>
                <span>Belum ada mata pelajaran yang diajarkan di kelas ini pada tahun ajaran aktif.</span>
            </div>
        @else
            <div class="mapel-grid">
                @foreach ($mapel as $m)
                    @if ($m->is_milik_saya)
                        <a href="{{ route('guru.penilaiansiswa.show', ['idKelas' => $kelas->id, 'idPelajaran' => $m->idpelajaran]) }}"
                           class="mapel-card">
                            <div class="mapel-top">
                                <div class="mapel-icon"><i class='bx bx-book-content'></i></div>
                                <span class="status-pill mine"><i class='bx bx-check-circle'></i> Anda</span>
                            </div>
                            <div class="mapel-nama">{{ $m->nama_pelajaran }}</div>
                            <div class="mapel-guru">
                                <i class='bx bx-user'></i>
                                Guru mengajar: <b>{{ $m->nama_guru }}</b>
                            </div>
                            <div class="mapel-cta">
                                Input nilai <i class='bx bx-right-arrow-alt'></i>
                            </div>
                        </a>
                    @else
                        <span class="mapel-card disabled" title="Bukan mata pelajaran Anda">
                            <div class="mapel-top">
                                <div class="mapel-icon"><i class='bx bx-lock-alt'></i></div>
                                <span class="status-pill other">Guru lain</span>
                            </div>
                            <div class="mapel-nama">{{ $m->nama_pelajaran }}</div>
                            <div class="mapel-guru">
                                <i class='bx bx-user'></i>
                                Guru mengajar: <b>{{ $m->nama_guru }}</b>
                            </div>
                        </span>
                    @endif
                @endforeach
            </div>
        @endif
    </div>
</body>
</html>