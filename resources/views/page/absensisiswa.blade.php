<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi Siswa - {{ $isikelas->nam ?? 'Kelas' }}</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        /* ===== CSS Variables (sama dengan dashboard) ===== */
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
            --success: #16a34a;
            --success-bg: #dcfce7;
            --warning: #d97706;
            --warning-bg: #fef3c7;
            --info: #2563eb;
            --info-bg: #dbeafe;
            --danger: #dc2626;
            --danger-bg: #fee2e2;
            --shadow-sm: 0 1px 2px rgba(26, 42, 74, 0.05);
            --shadow: 0 1px 3px rgba(26, 42, 74, 0.08), 0 1px 2px rgba(26, 42, 74, 0.06);
            --shadow-md: 0 4px 6px rgba(26, 42, 74, 0.07), 0 2px 4px rgba(26, 42, 74, 0.06);
            --shadow-lg: 0 10px 15px rgba(26, 42, 74, 0.10), 0 4px 6px rgba(26, 42, 74, 0.05);
            --radius: 12px;
            --radius-lg: 16px;
            --radius-xl: 20px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            --font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: var(--font-family);
            background: var(--gray-50);
            color: var(--gray-800);
            min-height: 100vh;
            line-height: 1.6;
        }

        .dashboard {
            max-width: 1280px;
            margin: 0 auto;
            padding: 1.5rem;
        }

        /* ===== Top Navigation ===== */
        .top-nav {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
            padding: 0.5rem 0;
            flex-wrap: wrap;
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.65rem 1.5rem;
            background: var(--white);
            border: 1px solid var(--gray-200);
            border-radius: 50px;
            color: var(--gray-700);
            font-weight: 500;
            font-size: 0.875rem;
            font-family: var(--font-family);
            text-decoration: none;
            transition: var(--transition);
            box-shadow: var(--shadow-sm);
        }

        .btn-back:hover {
            background: var(--primary-blue);
            border-color: var(--primary-blue);
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
            color: var(--white);
        }

        .top-nav-title {
            font-size: 0.95rem;
            font-weight: 500;
            color: var(--gray-500);
            margin-left: 0.5rem;
        }

        .top-nav-title span { color: var(--primary-dark); font-weight: 600; }

        .top-nav-badge {
            margin-left: auto;
            background: var(--primary-bg);
            color: var(--primary-blue);
            padding: 0.3rem 1rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
            border: 1px solid var(--gray-200);
        }

        /* ===== Hero ===== */
        .hero {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-blue) 50%, var(--primary-light) 100%);
            border-radius: var(--radius-xl);
            padding: 2rem 2.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 8px 30px rgba(44, 95, 138, 0.30);
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 450px;
            height: 450px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
        }

        .hero-content { position: relative; z-index: 1; color: var(--white); }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(8px);
            padding: 0.2rem 1rem;
            border-radius: 50px;
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 0.5rem;
        }

        .hero-content h1 {
            font-size: 1.9rem;
            font-weight: 700;
            margin: 0 0 0.25rem 0;
            letter-spacing: -0.025em;
        }

        .hero-content .hero-subtitle {
            font-size: 0.95rem;
            opacity: 0.9;
            font-weight: 400;
        }

        /* ===== Toolbar (filter tanggal + rekap) ===== */
        .toolbar {
            background: var(--white);
            border-radius: var(--radius-lg);
            border: 1px solid var(--gray-200);
            box-shadow: var(--shadow-sm);
            padding: 1.25rem 1.5rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .toolbar-left {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .toolbar-left label {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--gray-600);
        }

        .toolbar-left select,
        .toolbar-left input[type="date"] {
            font-family: var(--font-family);
            font-size: 0.9rem;
            padding: 0.55rem 1rem;
            border-radius: 50px;
            border: 1px solid var(--gray-200);
            color: var(--gray-800);
            background: var(--gray-50);
        }

        .btn-filter {
            font-family: var(--font-family);
            font-size: 0.85rem;
            font-weight: 600;
            padding: 0.55rem 1.25rem;
            border-radius: 50px;
            border: none;
            background: var(--primary-blue);
            color: var(--white);
            cursor: pointer;
            transition: var(--transition);
        }

        .btn-filter:hover { background: var(--primary-dark); }

        .recap {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .recap-pill {
            display: flex;
            align-items: center;
            gap: 0.4rem;
            font-size: 0.8rem;
            font-weight: 600;
            padding: 0.4rem 0.9rem;
            border-radius: 50px;
        }

        .recap-pill.hadir { background: var(--success-bg); color: var(--success); }
        .recap-pill.izin  { background: var(--info-bg); color: var(--info); }
        .recap-pill.sakit { background: var(--warning-bg); color: var(--warning); }
        .recap-pill.alpa  { background: var(--danger-bg); color: var(--danger); }

        /* ===== Table Card ===== */
        .table-card {
            background: var(--white);
            border-radius: var(--radius-lg);
            border: 1px solid var(--gray-200);
            box-shadow: var(--shadow-sm);
            overflow: hidden;
        }

        .table-wrap { overflow-x: auto; }

        table.absensi {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.9rem;
        }

        table.absensi thead th {
            background: var(--primary-bg);
            color: var(--primary-dark);
            font-weight: 600;
            font-size: 0.78rem;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            padding: 0.9rem 1rem;
            text-align: left;
            white-space: nowrap;
        }

        table.absensi tbody tr {
            border-bottom: 1px solid var(--gray-100);
            transition: var(--transition);
        }

        table.absensi tbody tr:hover { background: var(--gray-50); }
        table.absensi tbody tr:last-child { border-bottom: none; }

        table.absensi td {
            padding: 0.85rem 1rem;
            vertical-align: middle;
        }

        .siswa-cell {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .siswa-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: var(--primary-bg);
            color: var(--primary-blue);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.85rem;
            flex-shrink: 0;
            overflow: hidden;
        }

        .siswa-avatar img { width: 100%; height: 100%; object-fit: cover; }

        .siswa-name { font-weight: 600; color: var(--gray-800); }
        .siswa-nis { font-size: 0.78rem; color: var(--gray-400); }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.35rem 0.9rem;
            border-radius: 50px;
            font-size: 0.78rem;
            font-weight: 700;
        }

        .status-badge.hadir { background: var(--success-bg); color: var(--success); }
        .status-badge.izin  { background: var(--info-bg); color: var(--info); }
        .status-badge.sakit { background: var(--warning-bg); color: var(--warning); }
        .status-badge.alpa  { background: var(--danger-bg); color: var(--danger); }
        .status-badge.kosong { background: var(--gray-100); color: var(--gray-400); }

        .keterangan-text {
            font-size: 0.82rem;
            color: var(--gray-500);
        }

        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
            color: var(--gray-400);
        }

        .empty-state i { font-size: 2.5rem; display: block; margin-bottom: 0.5rem; }

        /* ===== Responsive ===== */
        @media (max-width: 768px) {
            .dashboard { padding: 1rem; }
            .hero { padding: 1.5rem 1.25rem; }
            .hero-content h1 { font-size: 1.4rem; }
            .toolbar { flex-direction: column; align-items: stretch; }
            .recap { justify-content: flex-start; }
            table.absensi { font-size: 0.82rem; }
        }
    </style>
</head>
<body>

    <div class="dashboard">

        <!-- ===== TOP NAVIGATION ===== -->
        <div class="top-nav">
            <a href="{{ url('guru/kelas/'.$isikelas->id) }}" class="btn-back">
                <i class='bx bx-arrow-back'></i>
                Kembali
            </a>
            <div class="top-nav-title">
                <i class='bx bx-check-circle' style="margin-right: 0.3rem;"></i>
                Absensi <span>Kelas {{ $isikelas->nam ?? '' }}</span>
            </div>
            <span class="top-nav-badge">
                <i class='bx bx-calendar'></i>
                Tahun Ajaran Aktif
            </span>
        </div>

        <!-- ===== HERO ===== -->
        <div class="hero">
            <div class="hero-content">
                <span class="hero-badge">
                    <i class='bx bx-check-circle'></i>
                    Absensi Siswa
                </span>
                <h1>Absensi Kelas {{ $isikelas->nam ?? 'Tidak Diketahui' }}</h1>
                <p class="hero-subtitle">Pantau rekap kehadiran siswa</p>
            </div>
        </div>

        <!-- ===== TOOLBAR (filter tanggal, hanya untuk lihat) ===== -->
        <form method="GET" action="{{ url()->current() }}">
            <div class="toolbar">
                <div class="toolbar-left">
                    <label for="tanggal"><i class='bx bx-calendar-event'></i> Tanggal</label>
                    <input type="date" id="tanggal" name="tanggal" value="{{ request('tanggal', date('Y-m-d')) }}">
                    <button type="submit" class="btn-filter">
                        <i class='bx bx-search'></i> Lihat
                    </button>
                </div>

                <div class="recap">
                    <span class="recap-pill hadir"><i class='bx bx-check'></i> {{ $countHadir ?? 0 }} Hadir</span>
                    <span class="recap-pill izin"><i class='bx bx-note'></i> {{ $countIzin ?? 0 }} Izin</span>
                    <span class="recap-pill sakit"><i class='bx bx-plus-medical'></i> {{ $countSakit ?? 0 }} Sakit</span>
                    <span class="recap-pill alpa"><i class='bx bx-x'></i> {{ $countAlpa ?? 0 }} Alpa</span>
                </div>
            </div>
        </form>

        <!-- ===== TABLE (read only) ===== -->
        <div class="table-card">
            <div class="table-wrap">
                <table class="absensi">
                    <thead>
                        <tr>
                            <th style="width: 48px;">No</th>
                            <th>Siswa</th>
                            <th>Status</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($siswa as $i => $item)
                            @php
                                $s = $item->siswa;

                                // $item->absensiHariIni (opsional) bisa di-load dari controller,
                                // berisi object status absensi untuk tanggal yang dipilih.
                                $status = $item->absensiHariIni->status ?? null;
                                $ket    = $item->absensiHariIni->keterangan ?? null;

                                $label = match($status) {
                                    'H' => ['Hadir', 'hadir'],
                                    'I' => ['Izin', 'izin'],
                                    'S' => ['Sakit', 'sakit'],
                                    'A' => ['Alpa', 'alpa'],
                                    default => ['Belum diabsen', 'kosong'],
                                };
                            @endphp
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>
                                    <div class="siswa-cell">
                                        <div class="siswa-avatar">
                                            {{ $s ? strtoupper(substr($s->namlen ?? $s->namnam ?? '?', 0, 1)) : '?' }}
                                        </div>
                                        <div>
                                            <div class="siswa-name">{{ $s->namlen ?? $s->namnam ?? '-' }}</div>
                                            <div class="siswa-nis">NIS: {{ $s->nis ?? '-' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="status-badge {{ $label[1] }}">{{ $label[0] }}</span>
                                </td>
                                <td>
                                    <span class="keterangan-text">{{ $ket ?? '-' }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">
                                    <div class="empty-state">
                                        <i class='bx bx-user-x'></i>
                                        Belum ada siswa terdaftar di kelas ini.
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>
</html>