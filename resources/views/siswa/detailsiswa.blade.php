<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Siswa - {{ $detailsiswa->namlen ?? 'Siswa' }}</title>
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
            --gray-500: #64748b;
            --gray-700: #334155;
            --gray-800: #1e293b;
            --shadow-sm: 0 1px 2px rgba(26, 42, 74, 0.05);
            --shadow-md: 0 4px 6px rgba(26, 42, 74, 0.07), 0 2px 4px rgba(26, 42, 74, 0.06);
            --radius: 12px;
            --radius-lg: 16px;
            --radius-xl: 20px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            --font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: var(--font-family); background: var(--gray-50); color: var(--gray-800); min-height: 100vh; }
        .dashboard { max-width: 1000px; margin: 0 auto; padding: 1.5rem; }

        .top-nav { display: flex; align-items: center; gap: 1rem; margin-bottom: 1.5rem; }
        .btn-back {
            display: inline-flex; align-items: center; gap: 0.5rem;
            padding: 0.65rem 1.5rem; background: var(--white);
            border: 1px solid var(--gray-200); border-radius: 50px;
            color: var(--gray-700); font-weight: 500; font-size: 0.875rem;
            font-family: var(--font-family); text-decoration: none;
            transition: var(--transition); box-shadow: var(--shadow-sm);
        }
        .btn-back:hover { background: var(--primary-blue); border-color: var(--primary-blue); color: var(--white); transform: translateY(-2px); }

        .profile-hero {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-blue) 50%, var(--primary-light) 100%);
            border-radius: var(--radius-xl);
            padding: 2.5rem;
            display: flex; align-items: center; gap: 2rem; flex-wrap: wrap;
            color: var(--white); margin-bottom: 2rem;
            box-shadow: 0 8px 30px rgba(44, 95, 138, 0.30);
        }
        .profile-photo {
            width: 120px; height: 120px; border-radius: var(--radius-lg);
            overflow: hidden; border: 3px solid rgba(255,255,255,0.25);
            background: rgba(255,255,255,0.1); flex-shrink: 0;
            display: flex; align-items: center; justify-content: center; font-size: 3rem;
        }
        .profile-photo img { width: 100%; height: 100%; object-fit: cover; }
        .profile-hero h1 { font-size: 1.75rem; font-weight: 700; margin-bottom: 0.25rem; }
        .profile-hero .badge {
            display: inline-block; background: rgba(255,255,255,0.15);
            padding: 0.25rem 1rem; border-radius: 50px; font-size: 0.8rem; margin-top: 0.5rem;
        }

        .info-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 1.25rem; }
        .info-card {
            background: var(--white); border: 1px solid var(--gray-200);
            border-radius: var(--radius); padding: 1.5rem; box-shadow: var(--shadow-sm);
        }
        .info-card h3 {
            font-size: 0.95rem; font-weight: 600; color: var(--primary-dark);
            margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;
        }
        .info-card h3 i { color: var(--primary-light); }
        .info-row { display: flex; justify-content: space-between; padding: 0.5rem 0; border-bottom: 1px solid var(--gray-100); font-size: 0.875rem; gap: 1rem; }
        .info-row:last-child { border-bottom: none; }
        .info-row .label { color: var(--gray-500); flex-shrink: 0; }
        .info-row .value { font-weight: 500; text-align: right; }

        @media (max-width: 640px) {
            .profile-hero { flex-direction: column; text-align: center; padding: 1.75rem 1.25rem; }
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <div class="top-nav">
            <a href="{{ url()->previous() }}" class="btn-back">
                <i class='bx bx-arrow-back'></i>
                Kembali
            </a>
        </div>

        @php
            $jenkelLabel = match($detailsiswa->jenkel ?? null) {
                'L' => 'Laki-laki',
                'P' => 'Perempuan',
                default => $detailsiswa->jenkel ?? '-',
            };
        @endphp

        <div class="profile-hero">
            <div class="profile-photo">
                @if(!empty($detailsiswa->detailsiswa->img_base64))
                    <img src="data:image/jpeg;base64,{{ $detailsiswa->detailsiswa->img_base64 }}" alt="{{ $detailsiswa->namlen ?? 'Siswa' }}">
                @else
                    <i class='bx bx-user'></i>
                @endif
            </div>
            <div>
                <h1>{{ $detailsiswa->namlen ?? '-' }}</h1>
                <div>NIS: {{ $detailsiswa->nis ?? $detailsiswa->nisn ?? '-' }}</div>
                <span class="badge">
                    <i class='bx bxs-school'></i>
                    Kelas {{ $namakelas ?? $detailsiswa->kel ?? '-' }}
                </span>
            </div>
        </div>

        <div class="info-grid">
            <div class="info-card">
                <h3><i class='bx bx-id-card'></i> Data Pribadi</h3>
                <div class="info-row"><span class="label">Nama Panggilan</span><span class="value">{{ $detailsiswa->nampan ?? '-' }}</span></div>
                <div class="info-row"><span class="label">Jenis Kelamin</span><span class="value">{{ $jenkelLabel }}</span></div>
                <div class="info-row"><span class="label">Tempat Lahir</span><span class="value">{{ $detailsiswa->temlah ?? '-' }}</span></div>
                <div class="info-row"><span class="label">Tanggal Lahir</span><span class="value">{{ $detailsiswa->tgllah ?? '-' }}</span></div>
            </div>

            <div class="info-card">
                <h3><i class='bx bx-phone'></i> Kontak</h3>
                <div class="info-row"><span class="label">Telepon</span><span class="value">{{ $detailsiswa->tel ?? '-' }}</span></div>
                <div class="info-row"><span class="label">NISN</span><span class="value">{{ $detailsiswa->nisn ?? '-' }}</span></div>
            </div>

            <div class="info-card">
                <h3><i class='bx bx-calendar-check'></i> Akademik</h3>
                <div class="info-row"><span class="label">Kelas</span><span class="value">{{ $namakelas ?? $detailsiswa->kel ?? '-' }}</span></div>
            </div>
        </div>
    </div>
</body>
</html>