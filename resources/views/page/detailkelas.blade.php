<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Kelas - {{ $isikelas->nam ?? 'Kelas' }}</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        /* ===== CSS Variables ===== */
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
            --shadow-sm: 0 1px 2px rgba(26, 42, 74, 0.05);
            --shadow: 0 1px 3px rgba(26, 42, 74, 0.08), 0 1px 2px rgba(26, 42, 74, 0.06);
            --shadow-md: 0 4px 6px rgba(26, 42, 74, 0.07), 0 2px 4px rgba(26, 42, 74, 0.06);
            --shadow-lg: 0 10px 15px rgba(26, 42, 74, 0.10), 0 4px 6px rgba(26, 42, 74, 0.05);
            --shadow-xl: 0 20px 25px rgba(26, 42, 74, 0.10), 0 10px 10px rgba(26, 42, 74, 0.04);
            --radius: 12px;
            --radius-lg: 16px;
            --radius-xl: 20px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            --font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        /* ===== Reset & Base ===== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: var(--font-family);
            background: var(--gray-50);
            color: var(--gray-800);
            min-height: 100vh;
            line-height: 1.6;
        }

        /* ===== Container ===== */
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

        .btn-back i {
            font-size: 1.2rem;
            line-height: 1;
        }

        .top-nav-title {
            font-size: 0.95rem;
            font-weight: 500;
            color: var(--gray-500);
            margin-left: 0.5rem;
        }

        .top-nav-title span {
            color: var(--primary-dark);
            font-weight: 600;
        }

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

        /* ===== Hero / Header ===== */
        .hero {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-blue) 50%, var(--primary-light) 100%);
            border-radius: var(--radius-xl);
            padding: 2.5rem 3rem;
            margin-bottom: 2.5rem;
            box-shadow: 0 8px 30px rgba(44, 95, 138, 0.30);
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 500px;
            height: 500px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            pointer-events: none;
        }

        .hero::after {
            content: '';
            position: absolute;
            bottom: -60%;
            left: 5%;
            width: 400px;
            height: 400px;
            background: rgba(255, 255, 255, 0.03);
            border-radius: 50%;
            pointer-events: none;
        }

        .hero-content {
            display: flex;
            align-items: center;
            gap: 2.5rem;
            position: relative;
            z-index: 1;
        }

        .hero-image {
            flex-shrink: 0;
            width: 140px;
            height: 140px;
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.20);
            border: 3px solid rgba(255, 255, 255, 0.25);
            background: var(--white);
        }

        .hero-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .hero-image .no-image {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, var(--gray-100) 0%, var(--gray-200) 100%);
            color: var(--gray-400);
            font-size: 48px;
        }

        .hero-text {
            color: var(--white);
            flex: 1;
        }

        .hero-text .hero-badge {
            display: inline-block;
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

        .hero-text h1 {
            font-size: 2.25rem;
            font-weight: 700;
            margin: 0 0 0.25rem 0;
            letter-spacing: -0.025em;
            line-height: 1.2;
        }

        .hero-text .hero-subtitle {
            font-size: 1.05rem;
            opacity: 0.9;
            margin: 0 0 0.5rem 0;
            font-weight: 400;
        }

        .hero-text .wali-kelas {
            font-size: 0.9rem;
            opacity: 0.9;
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(8px);
            padding: 0.35rem 1.25rem;
            border-radius: 50px;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .hero-text .wali-kelas i {
            font-size: 1.1rem;
        }

        .hero-stats {
            display: flex;
            gap: 2.5rem;
            margin-top: 1.25rem;
            flex-wrap: wrap;
        }

        .stat-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: rgba(255, 255, 255, 0.95);
        }

        .stat-item .stat-icon {
            font-size: 1.5rem;
            opacity: 0.8;
        }

        .stat-item .stat-number {
            font-size: 1.5rem;
            font-weight: 700;
            line-height: 1;
        }

        .stat-item .stat-label {
            font-size: 0.85rem;
            opacity: 0.75;
            font-weight: 400;
            margin-left: 0.2rem;
        }

        /* ===== Section Title ===== */
        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
            gap: 0.75rem;
        }

        .section-header h2 {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--primary-dark);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .section-header h2 i {
            color: var(--primary-light);
        }

        .section-header .menu-count {
            font-size: 0.8rem;
            color: var(--gray-500);
            background: var(--gray-100);
            padding: 0.2rem 0.8rem;
            border-radius: 50px;
        }

        /* ===== Menu Grid ===== */
        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 1.25rem;
        }

        .menu-card {
            background: var(--white);
            border-radius: var(--radius);
            padding: 1.5rem 1.25rem;
            text-decoration: none;
            color: var(--gray-800);
            border: 1px solid var(--gray-200);
            transition: var(--transition);
            box-shadow: var(--shadow-sm);
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
            position: relative;
            overflow: hidden;
            min-height: 140px;
        }

        .menu-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--primary-blue), var(--primary-light));
            opacity: 0;
            transition: var(--transition);
        }

        .menu-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
            border-color: var(--primary-light);
            color: var(--gray-900);
        }

        .menu-card:hover::before {
            opacity: 1;
        }

        .menu-card .icon-wrap {
            width: 48px;
            height: 48px;
            border-radius: var(--radius);
            background: var(--primary-bg);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: var(--primary-blue);
            transition: var(--transition);
            flex-shrink: 0;
        }

        .menu-card:hover .icon-wrap {
            background: var(--primary-blue);
            color: var(--white);
            transform: scale(1.05) rotate(-3deg);
        }

        .menu-card .menu-title {
            font-size: 1rem;
            font-weight: 600;
            margin: 0;
            letter-spacing: -0.01em;
            line-height: 1.3;
            font-family: var(--font-family);
        }

        .menu-card .menu-desc {
            font-size: 0.8rem;
            color: var(--gray-500);
            margin: 0;
            line-height: 1.4;
            font-weight: 400;
        }

        .menu-card .menu-arrow {
            margin-left: auto;
            color: var(--gray-300);
            transition: var(--transition);
            font-size: 1.1rem;
            opacity: 0;
            transform: translateX(-8px);
            margin-top: auto;
        }

        .menu-card:hover .menu-arrow {
            opacity: 1;
            transform: translateX(0);
            color: var(--primary-blue);
        }

        /* ===== Animation ===== */
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .menu-card {
            animation: fadeUp 0.4s ease forwards;
            opacity: 0;
        }

        .menu-card:nth-child(1) { animation-delay: 0.05s; }
        .menu-card:nth-child(2) { animation-delay: 0.10s; }
        .menu-card:nth-child(3) { animation-delay: 0.15s; }
        .menu-card:nth-child(4) { animation-delay: 0.20s; }
        .menu-card:nth-child(5) { animation-delay: 0.25s; }
        .menu-card:nth-child(6) { animation-delay: 0.30s; }
        .menu-card:nth-child(7) { animation-delay: 0.35s; }
        .menu-card:nth-child(8) { animation-delay: 0.40s; }
        .menu-card:nth-child(9) { animation-delay: 0.45s; }

        /* ===== Responsive ===== */

        /* Tablet & Small Desktop */
        @media (max-width: 1024px) {
            .dashboard {
                padding: 1.25rem;
            }

            .hero {
                padding: 2rem 2rem;
            }

            .hero-content {
                gap: 1.5rem;
                flex-wrap: wrap;
                justify-content: center;
                text-align: center;
            }

            .hero-image {
                width: 120px;
                height: 120px;
            }

            .hero-text h1 {
                font-size: 1.75rem;
            }

            .hero-stats {
                justify-content: center;
                gap: 1.5rem;
            }

            .menu-grid {
                grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
                gap: 1rem;
            }
        }

        /* Mobile */
        @media (max-width: 768px) {
            .dashboard {
                padding: 1rem;
            }

            .top-nav {
                gap: 0.75rem;
            }

            .top-nav-title {
                font-size: 0.85rem;
                width: 100%;
                margin-left: 0;
            }

            .top-nav-badge {
                margin-left: 0;
            }

            .hero {
                padding: 1.5rem 1.25rem;
                border-radius: var(--radius-lg);
            }

            .hero-content {
                gap: 1rem;
            }

            .hero-image {
                width: 100px;
                height: 100px;
            }

            .hero-text h1 {
                font-size: 1.5rem;
            }

            .hero-text .hero-subtitle {
                font-size: 0.95rem;
            }

            .hero-text .wali-kelas {
                font-size: 0.8rem;
                padding: 0.25rem 1rem;
            }

            .hero-stats {
                gap: 1rem;
                justify-content: center;
            }

            .stat-item .stat-number {
                font-size: 1.25rem;
            }

            .stat-item .stat-label {
                font-size: 0.75rem;
            }

            .menu-grid {
                grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
                gap: 0.875rem;
            }

            .menu-card {
                padding: 1.25rem 1rem;
                min-height: 120px;
                align-items: center;
                text-align: center;
            }

            .menu-card .icon-wrap {
                width: 42px;
                height: 42px;
                font-size: 1.25rem;
            }

            .menu-card .menu-title {
                font-size: 0.9rem;
            }

            .menu-card .menu-desc {
                display: none;
            }

            .menu-card .menu-arrow {
                display: none;
            }

            .btn-back {
                padding: 0.5rem 1.2rem;
                font-size: 0.8rem;
            }

            .section-header h2 {
                font-size: 1rem;
            }
        }

        /* Small Mobile */
        @media (max-width: 480px) {
            .dashboard {
                padding: 0.75rem;
            }

            .hero {
                padding: 1.25rem 1rem;
                border-radius: var(--radius);
            }

            .hero-image {
                width: 80px;
                height: 80px;
            }

            .hero-text h1 {
                font-size: 1.25rem;
            }

            .hero-text .hero-subtitle {
                font-size: 0.85rem;
            }

            .hero-text .wali-kelas {
                font-size: 0.7rem;
                padding: 0.2rem 0.75rem;
            }

            .hero-stats {
                gap: 0.75rem;
                margin-top: 0.75rem;
            }

            .stat-item .stat-number {
                font-size: 1rem;
            }

            .stat-item .stat-label {
                font-size: 0.7rem;
            }

            .stat-item .stat-icon {
                font-size: 1.1rem;
            }

            .menu-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 0.75rem;
            }

            .menu-card {
                padding: 1rem 0.75rem;
                min-height: 100px;
            }

            .menu-card .icon-wrap {
                width: 36px;
                height: 36px;
                font-size: 1.1rem;
            }

            .menu-card .menu-title {
                font-size: 0.8rem;
            }

            .btn-back {
                padding: 0.4rem 0.9rem;
                font-size: 0.75rem;
            }

            .btn-back i {
                font-size: 1rem;
            }

            .top-nav-title {
                font-size: 0.75rem;
            }

            .section-header h2 {
                font-size: 0.9rem;
            }

            .section-header .menu-count {
                font-size: 0.7rem;
                padding: 0.1rem 0.6rem;
            }
        }

        @media (max-width: 380px) {
            .menu-grid {
                grid-template-columns: 1fr 1fr;
                gap: 0.5rem;
            }

            .menu-card {
                padding: 0.75rem 0.5rem;
                min-height: 80px;
            }

            .menu-card .icon-wrap {
                width: 30px;
                height: 30px;
                font-size: 0.9rem;
            }

            .menu-card .menu-title {
                font-size: 0.7rem;
            }
        }
    </style>
</head>
<body>

    <div class="dashboard">
        <!-- ===== TOP NAVIGATION ===== -->
        <div class="top-nav">
            <a href="{{ route('guru.sekolah', ['tin' => $isikelas->tin]) }}" class="btn-back">
                <i class='bx bx-arrow-back'></i>
                Kembali
            </a>
            <div class="top-nav-title">
                <i class='bx bxs-dashboard' style="margin-right: 0.3rem;"></i>
                Dashboard <span>Kelas {{ $isikelas->nam ?? '' }}</span>
            </div>
            <span class="top-nav-badge">
                <i class='bx bx-calendar'></i>
                Tahun Ajaran Aktif
            </span>
        </div>

        <!-- ===== HERO / HEADER ===== -->
        <div class="hero">
            <div class="hero-content">
                <div class="hero-image">
                    @php
                        // Cek foto
                        $imageUrl = asset('images/nullable.png');
                        $hasImage = false;
                        
                        if (!empty($isikelas->foto)) {
                            $pathsToCheck = [
                                $isikelas->foto,
                                'images/' . $isikelas->foto,
                                'uploads/' . $isikelas->foto,
                                'foto/' . $isikelas->foto,
                                'storage/' . $isikelas->foto
                            ];
                            
                            foreach ($pathsToCheck as $path) {
                                if (file_exists(public_path($path))) {
                                    $imageUrl = asset($path);
                                    $hasImage = true;
                                    break;
                                }
                            }
                        }
                    @endphp
                    
                    @if($hasImage)
                        <img src="{{ $imageUrl }}" alt="{{ $isikelas->nam ?? 'Kelas' }}">
                    @else
                        <div class="no-image">
                            <i class='bx bxs-school'></i>
                        </div>
                    @endif
                </div>
                <div class="hero-text">
                    <span class="hero-badge">
                        <i class='bx bxs-school'></i>
                        Kelas Aktif
                    </span>
                    <h1>Kelas {{ $isikelas->nam ?? 'Tidak Diketahui' }}</h1>
                    <p class="hero-subtitle">Dashboard Kelas</p>
<span class="wali-kelas">
    <i class='bx bx-user-circle'></i>
    Wali Kelas: {{ optional($isikelas->waliKelas)->nam ?? 'Belum Ditentukan' }}
</span>
                    <div class="hero-stats">
                        <div class="stat-item">
                            <div>
                                <span class="stat-number">{{ $isikelas->jumlahsiswa_count ?? 0 }}</span>
                                <span class="stat-label">Murid</span>
                            </div>
                        </div>
                        <div class="stat-item">
                            <div>
                                <span class="stat-number">9</span>
                                <span class="stat-label">Menu</span>
                            </div>
                        </div>
                        <div class="stat-item">
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ===== SECTION HEADER ===== -->
        <div class="section-header">
            <h2>
                <i class='bx bx-grid-alt'></i>
                Menu Kelas
            </h2>
            <span class="menu-count">
                <i class='bx bx-list-ul'></i>
                9 Menu
            </span>
        </div>

        <!-- ===== MENU GRID ===== -->
        <div class="menu-grid">
            <!-- Data Siswa -->
                    <a href="{{ route('guru.siswa', $isikelas->id) }}" class="menu-card">                <div class="icon-wrap">
                    <i class='bx bx-group'></i>
                </div>
                <h5 class="menu-title">Data Siswa</h5>
                <p class="menu-desc">Kelola data siswa kelas</p>
                <span class="menu-arrow"><i class='bx bx-chevron-right'></i></span>
            </a>

            <!-- Absensi Siswa -->
                <a href="{{ route('guru.absensisiswa', $isikelas->id) }}" class="menu-card">
                <div class="icon-wrap">
                    <i class='bx bx-check-circle'></i>
                </div>
                <h5 class="menu-title">Absensi Siswa</h5>
                <p class="menu-desc">Monitoring kehadiran siswa</p>
                <span class="menu-arrow"><i class='bx bx-chevron-right'></i></span>
            </a>

            <!-- Surat Izin Siswa -->
            <a href="{{ route('guru.izin.by_kelas', ['id' => $isikelas->id]) }}" class="menu-card">
                <div class="icon-wrap">
                    <i class='bx bx-file'></i>
                </div>
                <h5 class="menu-title">Surat Izin Siswa</h5>
                <p class="menu-desc">Kelola surat izin siswa</p>
                <span class="menu-arrow"><i class='bx bx-chevron-right'></i></span>
            </a>

            <!-- Tugas & Proyek -->
            <a href="{{ route('guru.tugas', ['id' => $isikelas->id]) }}" class="menu-card">
                <div class="icon-wrap">
                    <i class='bx bx-book-content'></i>
                </div>
                <h5 class="menu-title">Tugas & Proyek</h5>
                <p class="menu-desc">Berikan tugas dan proyek</p>
                <span class="menu-arrow"><i class='bx bx-chevron-right'></i></span>
            </a>

            <!-- Penilaian -->
            <a href="{{ route('guru.penilaiansiswa', $isikelas->id) }}" class="menu-card">
                <div class="icon-wrap">
                    <i class='bx bx-trophy'></i>
                </div>
                <h5 class="menu-title">Penilaian</h5>
                <p class="menu-desc">Kelola nilai siswa</p>
                <span class="menu-arrow"><i class='bx bx-chevron-right'></i></span>
            </a>

            <!-- Catatan Kasus -->
                <a href="{{ route('guru.catatankasus', $isikelas->id) }}" class="menu-card">                <div class="icon-wrap">
                    <i class='bx bx-note'></i>
                </div>
                <h5 class="menu-title">Catatan Kasus</h5>
                <p class="menu-desc">Catat kasus siswa</p>
                <span class="menu-arrow"><i class='bx bx-chevron-right'></i></span>
            </a>

            <!-- Jurnal Konseling -->
            <a href="{{ route('guru.jurnalkonseling', $isikelas->id) }}" class="menu-card">
                <div class="icon-wrap">
                    <i class='bx bx-chat'></i>
                </div>
                <h5 class="menu-title">Jurnal Konseling</h5>
                <p class="menu-desc">Catat jurnal konseling</p>
                <span class="menu-arrow"><i class='bx bx-chevron-right'></i></span>
            </a>

            <!-- Rapor -->
            <a href="{{ route('guru.raporsiswa', ['idkelas' => $isikelas->id]) }}" class="menu-card">
                <div class="icon-wrap">
                    <i class='bx bx-medal'></i>
                </div>
                <h5 class="menu-title">Rapor</h5>
                <p class="menu-desc">Lihat rapor siswa</p>
                <span class="menu-arrow"><i class='bx bx-chevron-right'></i></span>
            </a>

         <!-- Info -->
            <a href="{{ route('guru.informasi.index', ['idkelas' => $isikelas->id]) }}" class="menu-card">
                <div class="icon-wrap">
                    <i class='bx bx-info-circle'></i>
                </div>
                <h5 class="menu-title">Info</h5>
                <p class="menu-desc">Informasi kelas</p>
                <span class="menu-arrow"><i class='bx bx-chevron-right'></i></span>
            </a>
        </div>
    </div>

</body>
</html>