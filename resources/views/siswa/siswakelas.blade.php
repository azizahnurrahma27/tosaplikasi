<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Siswa - {{ $isikelas->nam ?? 'Kelas' }}</title>
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
        .dashboard { max-width: 1280px; margin: 0 auto; padding: 1.5rem; }

        .top-nav {
            display: flex; align-items: center; gap: 1rem;
            margin-bottom: 1.5rem; padding: 0.5rem 0; flex-wrap: wrap;
        }
        .btn-back {
            display: inline-flex; align-items: center; gap: 0.5rem;
            padding: 0.65rem 1.5rem; background: var(--white);
            border: 1px solid var(--gray-200); border-radius: 50px;
            color: var(--gray-700); font-weight: 500; font-size: 0.875rem;
            font-family: var(--font-family); text-decoration: none;
            transition: var(--transition); box-shadow: var(--shadow-sm);
        }
        .btn-back:hover {
            background: var(--primary-blue); border-color: var(--primary-blue);
            transform: translateY(-2px); box-shadow: var(--shadow-md); color: var(--white);
        }
        .btn-back i { font-size: 1.2rem; line-height: 1; }
        .top-nav-title { font-size: 0.95rem; font-weight: 500; color: var(--gray-500); margin-left: 0.5rem; }
        .top-nav-title span { color: var(--primary-dark); font-weight: 600; }

        .hero {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-blue) 50%, var(--primary-light) 100%);
            border-radius: var(--radius-xl);
            padding: 1.75rem 2.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 8px 30px rgba(44, 95, 138, 0.30);
            color: var(--white);
            display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem;
        }
        .hero h1 { font-size: 1.6rem; font-weight: 700; margin-bottom: 0.25rem; }
        .hero p { opacity: 0.85; font-size: 0.9rem; }
        .hero .count-badge {
            background: rgba(255,255,255,0.15); backdrop-filter: blur(8px);
            padding: 0.5rem 1.25rem; border-radius: 50px; font-weight: 600; font-size: 0.9rem;
            border: 1px solid rgba(255,255,255,0.15);
        }

        .search-bar { margin-bottom: 1.5rem; }
        .search-bar input {
            width: 100%; max-width: 360px; padding: 0.65rem 1rem 0.65rem 2.5rem;
            border: 1px solid var(--gray-200); border-radius: 50px;
            font-family: var(--font-family); font-size: 0.9rem; background: var(--white) url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="%2394a3b8" viewBox="0 0 16 16"><path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/></svg>') no-repeat 0.9rem center;
            background-size: 16px;
        }
        .search-bar input:focus { outline: none; border-color: var(--primary-light); }

        .siswa-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 1.25rem;
        }
        .siswa-card {
            background: var(--white);
            border: 1px solid var(--gray-200);
            border-radius: var(--radius);
            padding: 1.25rem;
            display: flex; align-items: center; gap: 1rem;
            text-decoration: none; color: var(--gray-800);
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
        }
        .siswa-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
            border-color: var(--primary-light);
        }
        .siswa-avatar {
            width: 52px; height: 52px; border-radius: 50%;
            overflow: hidden; flex-shrink: 0; background: var(--primary-bg);
            display: flex; align-items: center; justify-content: center;
            color: var(--primary-blue); font-size: 1.5rem;
        }
        .siswa-avatar img { width: 100%; height: 100%; object-fit: cover; }
        .siswa-info { flex: 1; min-width: 0; }
        .siswa-info .nama { font-weight: 600; font-size: 0.95rem; margin-bottom: 0.15rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .siswa-info .nis { font-size: 0.8rem; color: var(--gray-500); }
        .siswa-card .chevron { color: var(--gray-300); font-size: 1.2rem; transition: var(--transition); }
        .siswa-card:hover .chevron { color: var(--primary-blue); transform: translateX(3px); }

        .empty-state {
            text-align: center; padding: 4rem 1rem; color: var(--gray-500);
        }
        .empty-state i { font-size: 3rem; color: var(--gray-300); margin-bottom: 1rem; display: block; }

        @media (max-width: 768px) {
            .dashboard { padding: 1rem; }
            .hero { padding: 1.5rem; }
            .hero h1 { font-size: 1.3rem; }
            .siswa-grid { grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); }
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <div class="top-nav">
            <a href="{{ route('guru.detailkelas', $isikelas->id) }}" class="btn-back">
                <i class='bx bx-arrow-back'></i>
                Kembali
            </a>
            <div class="top-nav-title">
                <i class='bx bxs-group' style="margin-right: 0.3rem;"></i>
                Data Siswa <span>Kelas {{ $isikelas->nam ?? '' }}</span>
            </div>
        </div>

        <div class="hero">
            <div>
                <h1>Siswa Kelas {{ $isikelas->nam ?? '-' }}</h1>
                <p>Daftar siswa yang terdaftar pada kelas ini</p>
            </div>
            <div class="count-badge">
                <i class='bx bx-group'></i> {{ $siswa->count() }} Siswa
            </div>
        </div>

        <div class="search-bar">
            <input type="text" id="searchSiswa" placeholder="Cari nama siswa...">
        </div>

        @if($siswa->count())
            <div class="siswa-grid" id="siswaGrid">
                @foreach($siswa as $row)
                    @php
                        $s    = $row->siswa; // relasi Tsiswa dari Tkelsis
                        $nama = $s->namlen ?? '-';
                        $nis  = $s->nis ?? $s->nisn ?? '-';
                        $foto = $row->detailsiswa->img ?? null;
                        $sid  = $s->id ?? $row->ids ?? $row->idsis ?? null;
                    @endphp
                    <a href="{{ route('guru.datasiswa', $sid) }}" class="siswa-card siswa-item" data-nama="{{ strtolower($nama) }}">
                        <div class="siswa-avatar">
                            @if($foto)
                                <img src="data:image/jpeg;base64,{{ base64_encode($foto) }}" alt="{{ $nama }}">
                            @else
                                <i class='bx bx-user'></i>
                            @endif
                        </div>
                        <div class="siswa-info">
                            <div class="nama">{{ $nama }}</div>
                            <div class="nis">NIS: {{ $nis }}</div>
                        </div>
                        <i class='bx bx-chevron-right chevron'></i>
                    </a>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <i class='bx bx-user-x'></i>
                Belum ada siswa yang terdaftar di kelas ini.
            </div>
        @endif
    </div>

    <script>
        const searchInput = document.getElementById('searchSiswa');
        searchInput?.addEventListener('input', function () {
            const q = this.value.toLowerCase();
            document.querySelectorAll('.siswa-item').forEach(item => {
                item.style.display = item.dataset.nama.includes(q) ? 'flex' : 'none';
            });
        });
    </script>
</body>
</html>