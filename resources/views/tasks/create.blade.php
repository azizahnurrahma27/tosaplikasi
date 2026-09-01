<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Tugas & Proyek - Kelas {{ $isikelas->nam ?? '' }}</title>
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
            --success: #059669;
            --success-bg: #ecfdf5;
            --danger: #dc2626;
            --danger-bg: #fef2f2;
            --shadow-sm: 0 1px 2px rgba(26, 42, 74, 0.05);
            --shadow: 0 1px 3px rgba(26, 42, 74, 0.08);
            --shadow-md: 0 4px 6px rgba(26, 42, 74, 0.07);
            --shadow-lg: 0 10px 15px rgba(26, 42, 74, 0.10);
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
            font-size: 14px;
        }

        /* ===== Container ===== */
        .dashboard {
            max-width: 1100px;
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
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        /* ===== Hero Header ===== */
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
            width: 400px;
            height: 400px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            pointer-events: none;
        }

        .hero::after {
            content: '';
            position: absolute;
            bottom: -60%;
            left: 5%;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.03);
            border-radius: 50%;
            pointer-events: none;
        }

        .hero-content {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            position: relative;
            z-index: 1;
        }

        .hero-image {
            flex-shrink: 0;
            width: 80px;
            height: 80px;
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            border: 3px solid rgba(255, 255, 255, 0.2);
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
            font-size: 32px;
        }

        .hero-text {
            color: var(--white);
            flex: 1;
        }

        .hero-text .hero-badge {
            display: inline-block;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(8px);
            padding: 0.15rem 1rem;
            border-radius: 50px;
            font-size: 0.65rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 0.25rem;
        }

        .hero-text h1 {
            font-size: 1.75rem;
            font-weight: 700;
            margin: 0;
            letter-spacing: -0.025em;
            line-height: 1.2;
        }

        .hero-text .hero-subtitle {
            font-size: 1rem;
            opacity: 0.9;
            font-weight: 400;
            margin: 0;
        }

        /* ===== Alert ===== */
        .alert {
            padding: 0.75rem 1rem;
            border-radius: var(--radius);
            margin-bottom: 1.25rem;
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            font-size: 0.875rem;
        }

        .alert i {
            font-size: 1.25rem;
            margin-top: 2px;
            flex-shrink: 0;
        }

        .alert-success {
            background: var(--success-bg);
            color: var(--success);
            border: 1px solid #a7f3d0;
        }

        .alert-danger {
            background: var(--danger-bg);
            color: var(--danger);
            border: 1px solid #fca5a5;
        }

        .alert-danger ul {
            margin: 0;
            padding-left: 1.25rem;
        }

        /* ===== Form Card ===== */
        .form-card {
            background: var(--white);
            border-radius: var(--radius-lg);
            border: 1px solid var(--gray-200);
            box-shadow: var(--shadow-sm);
            overflow: hidden;
        }

        .form-card-header {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid var(--gray-200);
            background: var(--gray-50);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .form-card-header i {
            font-size: 1.25rem;
            color: var(--primary-blue);
        }

        .form-card-header h5 {
            font-size: 1rem;
            font-weight: 600;
            margin: 0;
            color: var(--gray-800);
            font-family: var(--font-family);
        }

        .form-card-body {
            padding: 2rem 1.5rem;
        }

        /* ===== Form Elements ===== */
        .form-group {
            display: grid;
            grid-template-columns: 150px 1fr;
            gap: 1rem;
            margin-bottom: 1.25rem;
            align-items: start;
        }

        .form-group .form-label {
            font-weight: 600;
            font-size: 0.85rem;
            color: var(--gray-700);
            padding-top: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.25rem;
            font-family: var(--font-family);
        }

        .form-group .form-label .required {
            color: var(--danger);
            font-size: 1.1rem;
        }

        .form-control {
            width: 100%;
            padding: 0.6rem 0.8rem;
            border: 1px solid var(--gray-300);
            border-radius: var(--radius);
            font-size: 0.875rem;
            color: var(--gray-800);
            transition: var(--transition);
            background: var(--white);
            font-family: var(--font-family);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 3px rgba(44, 95, 138, 0.12);
        }

        .form-control[readonly] {
            background: var(--gray-100);
            cursor: not-allowed;
        }

        select.form-control {
            appearance: auto;
        }

        /* ===== Student Grid ===== */
        .student-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 0.5rem;
            max-height: 260px;
            overflow-y: auto;
            padding: 0.5rem 0.25rem;
            border: 1px solid var(--gray-200);
            border-radius: var(--radius);
            background: var(--gray-50);
        }

        .student-grid::-webkit-scrollbar {
            width: 6px;
        }

        .student-grid::-webkit-scrollbar-track {
            background: var(--gray-100);
            border-radius: 3px;
        }

        .student-grid::-webkit-scrollbar-thumb {
            background: var(--gray-300);
            border-radius: 3px;
        }

        .student-grid::-webkit-scrollbar-thumb:hover {
            background: var(--gray-400);
        }

        .student-item {
            background: var(--white);
            border: 1px solid var(--gray-200);
            border-radius: var(--radius);
            padding: 0.4rem 0.6rem;
            transition: var(--transition);
        }

        .student-item:hover {
            background: var(--primary-bg);
            border-color: var(--primary-light);
        }

        .student-item .form-check {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
            margin: 0;
        }

        .student-item .form-check input[type="checkbox"] {
            width: 16px;
            height: 16px;
            accent-color: var(--primary-blue);
            cursor: pointer;
            flex-shrink: 0;
        }

        .student-item .form-check .student-name {
            font-size: 0.8rem;
            font-weight: 500;
            color: var(--gray-700);
            font-family: var(--font-family);
        }

        /* ===== Form Actions ===== */
        .form-actions {
            display: flex;
            gap: 0.75rem;
            justify-content: flex-end;
            padding-top: 1.5rem;
            border-top: 1px solid var(--gray-200);
            margin-top: 1.5rem;
            flex-wrap: wrap;
        }

        .btn {
            padding: 0.6rem 1.5rem;
            border: none;
            border-radius: var(--radius);
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-family: var(--font-family);
        }

        .btn:active {
            transform: scale(0.97);
        }

        .btn-primary {
            background: var(--primary-blue);
            color: var(--white);
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .btn-secondary {
            background: var(--gray-200);
            color: var(--gray-700);
        }

        .btn-secondary:hover {
            background: var(--gray-300);
            transform: translateY(-2px);
        }

        /* ===== CKEditor Override ===== */
        .ck-powered-by {
            display: none !important;
        }

        .ck-balloon-panel[class*="powered-by"] {
            display: none !important;
        }

        .ck-editor__editable {
            min-height: 180px;
        }

        .ck-editor__editable:focus {
            border-color: var(--primary-blue) !important;
            box-shadow: 0 0 0 3px rgba(44, 95, 138, 0.12) !important;
        }

        /* ===== Responsive ===== */
        @media (max-width: 1024px) {
            .dashboard {
                padding: 1.25rem;
            }

            .hero-content {
                gap: 1rem;
            }

            .hero-text h1 {
                font-size: 1.5rem;
            }

            .form-group {
                grid-template-columns: 1fr;
                gap: 0.5rem;
            }

            .form-group .form-label {
                padding-top: 0;
            }
        }

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
                font-size: 0.7rem;
                padding: 0.2rem 0.8rem;
            }

            .hero {
                padding: 1.5rem 1.25rem;
                border-radius: var(--radius-lg);
            }

            .hero-image {
                width: 60px;
                height: 60px;
            }

            .hero-text h1 {
                font-size: 1.25rem;
            }

            .hero-text .hero-subtitle {
                font-size: 0.9rem;
            }

            .form-card-header {
                padding: 1rem 1.25rem;
            }

            .form-card-body {
                padding: 1.25rem 1rem;
            }

            .student-grid {
                grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
                max-height: 200px;
            }

            .form-actions {
                flex-direction: column-reverse;
            }

            .form-actions .btn {
                width: 100%;
                justify-content: center;
            }

            .btn-back {
                padding: 0.5rem 1.2rem;
                font-size: 0.8rem;
            }
        }

        @media (max-width: 480px) {
            .dashboard {
                padding: 0.75rem;
            }

            .btn-back {
                padding: 0.4rem 1rem;
                font-size: 0.75rem;
            }

            .btn-back i {
                font-size: 1rem;
            }

            .top-nav-title {
                font-size: 0.75rem;
            }

            .hero {
                padding: 1rem;
                border-radius: var(--radius);
            }

            .hero-image {
                width: 50px;
                height: 50px;
            }

            .hero-image .no-image {
                font-size: 24px;
            }

            .hero-text h1 {
                font-size: 1.1rem;
            }

            .hero-text .hero-subtitle {
                font-size: 0.8rem;
            }

            .hero-text .hero-badge {
                font-size: 0.55rem;
                padding: 0.1rem 0.6rem;
            }

            .form-card-header {
                padding: 0.75rem 1rem;
            }

            .form-card-header i {
                font-size: 1rem;
            }

            .form-card-header h5 {
                font-size: 0.9rem;
            }

            .form-card-body {
                padding: 1rem 0.75rem;
            }

            .form-group {
                margin-bottom: 1rem;
            }

            .form-group .form-label {
                font-size: 0.8rem;
            }

            .form-control {
                padding: 0.5rem 0.6rem;
                font-size: 0.8rem;
            }

            .student-grid {
                grid-template-columns: 1fr 1fr;
                gap: 0.4rem;
                max-height: 160px;
                padding: 0.35rem;
            }

            .student-item {
                padding: 0.3rem 0.4rem;
            }

            .student-item .form-check .student-name {
                font-size: 0.7rem;
            }

            .student-item .form-check input[type="checkbox"] {
                width: 14px;
                height: 14px;
            }

            .btn {
                padding: 0.5rem 1rem;
                font-size: 0.75rem;
            }

            .alert {
                font-size: 0.8rem;
                padding: 0.6rem 0.75rem;
            }

            .alert i {
                font-size: 1rem;
            }

            .ck-editor__editable {
                min-height: 120px;
            }
        }

        @media (max-width: 360px) {
            .student-grid {
                grid-template-columns: 1fr;
            }

            .hero-text h1 {
                font-size: 1rem;
            }

            .hero-image {
                width: 40px;
                height: 40px;
            }
        }

        /* ===== Animation ===== */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-card {
            animation: fadeIn 0.4s ease forwards;
        }

        #siswaList {
            animation: fadeIn 0.3s ease forwards;
        }
    </style>
</head>
<body>

    <div class="dashboard">
        <!-- ===== TOP NAVIGATION ===== -->
        <div class="top-nav">
            <a href="{{ route('guru.detailkelas', $isikelas->id) }}" class="btn-back">
                <i class='bx bx-arrow-back'></i>
                Kembali
            </a>
            <div class="top-nav-title">
                <i class='bx bxs-dashboard' style="margin-right: 0.3rem;"></i>
                Tambah Tugas <span>{{ $isikelas->nam ?? '' }}</span>
            </div>
            <span class="top-nav-badge">
                <i class='bx bx-calendar'></i>
                {{ date('d M Y') }}
            </span>
        </div>

        <!-- ===== HERO HEADER ===== -->
        <div class="hero">
            <div class="hero-content">
                <div class="hero-image">
                    @php
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
                        <i class='bx bxs-book-content'></i>
                        Tugas & Proyek
                    </span>
                    <h1>Kelas {{ $isikelas->nam ?? '' }}</h1>
                    <p class="hero-subtitle">Buat tugas dan proyek baru untuk siswa</p>
                </div>
            </div>
        </div>

        <!-- ===== ALERTS ===== -->
        @if(session('success'))
            <div class="alert alert-success">
                <i class='bx bx-check-circle'></i>
                <div>{{ session('success') }}</div>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <i class='bx bx-x-circle'></i>
                <div>
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <!-- ===== FORM ===== -->
        <div class="form-card">
            <div class="form-card-header">
                <i class='bx bx-edit-alt'></i>
                <h5>Form Tugas &amp; Proyek</h5>
            </div>
            <div class="form-card-body">
                <form action="{{ route('guru.admin.tasks.store', $isikelas->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="idkelas" value="{{ $isikelas->id }}">
                    <input type="hidden" name="idguru" value="{{ auth()->user()->id ?? '1' }}">

                    <!-- Mata Pelajaran -->
                    <div class="form-group">
                        <label class="form-label">
                            Mata Pelajaran <span class="required">*</span>
                        </label>
                        <div style="width: 100%;">
                            @if($mataPelajaran->count() === 1)
                                {{-- Kasus normal: 1 guru = 1 mapel di kelas ini --}}
                                <input type="text" class="form-control" value="{{ $mataPelajaran->first()['nam'] }}" disabled>
                                <input type="hidden" name="idpelajaran" value="{{ $mataPelajaran->first()['idpelajaran'] }}">
                            @else
                                {{-- Guru ini ngajar >1 mapel di kelas ini, wajib pilih --}}
                                <select name="idpelajaran" class="form-control" required>
                                    <option value="">-- Pilih Mata Pelajaran --</option>
                                    @foreach($mataPelajaran as $mp)
                                        <option value="{{ $mp['idpelajaran'] }}">{{ $mp['nam'] }}</option>
                                    @endforeach
                                </select>
                                <small style="color: var(--danger); font-size: 0.7rem; display: block; margin-top: 0.35rem;">
                                    <i class='bx bx-info-circle'></i>
                                    Anda mengajar lebih dari 1 mata pelajaran di kelas ini, silakan pilih salah satu.
                                </small>
                            @endif
                        </div>
                    </div>

                    <!-- Tanggal Pengugasan -->
                    <div class="form-group">
                        <label class="form-label">
                            Tanggal Pengugasan <span class="required">*</span>
                        </label>
                        <input type="date" name="tglpenugasan" class="form-control" value="{{ date('Y-m-d') }}" readonly>
                    </div>

                    <!-- Tanggal Pengumpulan -->
                    <div class="form-group">
                        <label class="form-label">
                            Tanggal Pengumpulan <span class="required">*</span>
                        </label>
                        <input type="date" name="tglpengumpulan" class="form-control" value="{{ date('Y-m-d', strtotime('+7 days')) }}" required>
                    </div>

                    <!-- Tugas Untuk -->
                    <div class="form-group">
                        <label class="form-label">
                            Tugas Untuk <span class="required">*</span>
                        </label>
                        <select class="form-control" name="tugasFor" id="tugasSiswa" required>
                            <option value="">-- Pilih Tugas Untuk --</option>
                            <option value="kelas">1 Kelas</option>
                            <option value="siswa">Anak Tertentu</option>
                        </select>
                    </div>

                    <!-- Siswa List (hidden by default) -->
                    <div class="form-group" id="siswaList" style="display: none;">
                        <label class="form-label">
                            Pilih Siswa <span class="required">*</span>
                        </label>
                        <div>
                            <div class="student-grid">
                                @foreach($siswa as $s)
                                    <div class="student-item">
                                        <label class="form-check">
                                            <input type="checkbox" name="siswa_ids[]" value="{{ $s->id }}" id="siswa{{ $s->id }}">
                                            <span class="student-name">{{ $s->namlen ?? $s->nampan ?? 'Siswa' }}</span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            <small style="color: var(--gray-400); font-size: 0.7rem; display: block; margin-top: 0.35rem;">
                                <i class='bx bx-info-circle'></i>
                                Pilih siswa yang akan menerima tugas ini
                            </small>
                        </div>
                    </div>

                    <!-- Judul Tugas -->
                    <div class="form-group">
                        <label class="form-label">
                            Judul Tugas <span class="required">*</span>
                        </label>
                        <input type="text" name="judul" class="form-control" placeholder="Masukkan judul tugas" required>
                    </div>

                    <!-- Deskripsi -->
                    <div class="form-group">
                        <label class="form-label">
                            Deskripsi <span class="required">*</span>
                        </label>
                        <div style="width: 100%;">
                            <div id="editorDeskripsi"></div>
                            <textarea name="deskripsi" id="deskripsi" style="display:none;" required></textarea>
                            <small style="color: var(--gray-400); font-size: 0.7rem; display: block; margin-top: 0.35rem;">
                                <i class='bx bx-info-circle'></i>
                                Berikan deskripsi tugas atau proyek secara detail
                            </small>
                        </div>
                    </div>

                    <!-- Lampiran -->
                    <div class="form-group">
                        <label class="form-label">Lampiran</label>
                        <div style="width: 100%;">
                            <input type="file" name="lampiran" class="form-control" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                            <small style="color: var(--gray-400); font-size: 0.7rem; display: block; margin-top: 0.25rem;">
                                <i class='bx bx-info-circle'></i>
                                Format: PDF, DOC, DOCX, JPG, PNG (Max: 5MB)
                            </small>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="form-actions">
                        <a href="{{ route('guru.detailkelas', $isikelas->id) }}" class="btn btn-secondary">
                            <i class='bx bx-x'></i> Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class='bx bx-save'></i> Simpan Tugas
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <!-- ===== SCRIPTS ===== -->
    <script src="https://cdn.ckeditor.com/ckeditor5/40.2.0/classic/ckeditor.js"></script>
    <script>
        (function() {
            'use strict';

            // ===== CKEditor =====
            let editorInstance = null;

            ClassicEditor
                .create(document.querySelector('#editorDeskripsi'), {
                    toolbar: [
                        'heading', '|',
                        'bold', 'italic', 'link', '|',
                        'bulletedList', 'numberedList', '|',
                        'outdent', 'indent', '|',
                        'blockQuote', 'insertTable', '|',
                        'undo', 'redo'
                    ],
                    heading: {
                        options: [
                            { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                            { model: 'heading1', view: 'h1', title: 'Heading 1' },
                            { model: 'heading2', view: 'h2', title: 'Heading 2' },
                            { model: 'heading3', view: 'h3', title: 'Heading 3' }
                        ]
                    }
                })
                .then(editor => {
                    editorInstance = editor;
                    editor.model.document.on('change:data', () => {
                        document.querySelector('#deskripsi').value = editor.getData();
                    });
                })
                .catch(error => console.error(error));

            // ===== Toggle Student List =====
            const tugasSelect = document.getElementById('tugasSiswa');
            const siswaList = document.getElementById('siswaList');

            if (tugasSelect) {
                tugasSelect.addEventListener('change', function() {
                    if (this.value === 'siswa') {
                        siswaList.style.display = 'grid';
                        // Add animation
                        siswaList.style.animation = 'fadeIn 0.3s ease forwards';
                    } else {
                        siswaList.style.display = 'none';
                        // Uncheck all checkboxes when hidden
                        document.querySelectorAll('input[name="siswa_ids[]"]').forEach(cb => cb.checked = false);
                    }
                });
            }

            // ===== Form Submit =====
            const form = document.querySelector('form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    // Sync CKEditor data
                    if (editorInstance) {
                        document.querySelector('#deskripsi').value = editorInstance.getData();
                    }

                    // Validate CKEditor content
                    const deskripsi = document.querySelector('#deskripsi');
                    if (deskripsi && !deskripsi.value.trim()) {
                        e.preventDefault();
                        alert('⚠️ Deskripsi tugas tidak boleh kosong!');
                        return false;
                    }

                    // Validate student selection if "siswa" is selected
                    const tugasFor = document.querySelector('select[name="tugasFor"]');
                    if (tugasFor && tugasFor.value === 'siswa') {
                        const checked = document.querySelectorAll('input[name="siswa_ids[]"]:checked');
                        if (checked.length === 0) {
                            e.preventDefault();
                            alert('⚠️ Pilih minimal 1 siswa untuk tugas ini!');
                            return false;
                        }
                    }

                    // Validate file size
                    const fileInput = document.querySelector('input[name="lampiran"]');
                    if (fileInput && fileInput.files.length > 0) {
                        const file = fileInput.files[0];
                        const maxSize = 5 * 1024 * 1024; // 5MB
                        if (file.size > maxSize) {
                            e.preventDefault();
                            alert('⚠️ Ukuran file terlalu besar! Maksimal 5MB.');
                            return false;
                        }
                    }
                });
            }

            // ===== Auto-hide alerts after 5 seconds =====
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.transition = 'opacity 0.5s ease';
                    alert.style.opacity = '0';
                    setTimeout(() => {
                        alert.style.display = 'none';
                    }, 500);
                }, 5000);
            });

        })();
    </script>

</body>
</html>