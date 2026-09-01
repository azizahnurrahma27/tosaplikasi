<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Catatan Kasus</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-dark: #1a2a4a;
            --primary-blue: #2c5f8a;
            --primary-light: #4a8fc7;
            --white: #ffffff;
            --gray-50: #f8fafc;
            --gray-100: #f1f5f9;
            --gray-200: #e2e8f0;
            --gray-500: #64748b;
            --gray-700: #334155;
            --danger: #c0392b;
            --shadow-sm: 0 1px 2px rgba(26, 42, 74, 0.05);
            --shadow-md: 0 4px 6px rgba(26, 42, 74, 0.07), 0 2px 4px rgba(26, 42, 74, 0.06);
            --radius: 12px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            --font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: var(--font-family); background: var(--gray-50); color: var(--gray-700); min-height: 100vh; }
        .wrap { max-width: 650px; margin: 0 auto; padding: 1.5rem; }

        .btn-back {
            display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.6rem 1.4rem;
            background: var(--white); border: 1px solid var(--gray-200); border-radius: 50px;
            color: var(--gray-700); font-size: 0.875rem; text-decoration: none;
            margin-bottom: 1.5rem; transition: var(--transition); box-shadow: var(--shadow-sm);
        }
        .btn-back:hover { background: var(--primary-blue); border-color: var(--primary-blue); color: var(--white); }

        h2 { color: var(--primary-dark); margin-bottom: 1.5rem; font-size: 1.35rem; font-weight: 600; }

        form { background: var(--white); padding: 1.75rem; border-radius: var(--radius); border: 1px solid var(--gray-200); box-shadow: var(--shadow-sm); }

        .field { margin-bottom: 1.25rem; }
        label { display: block; font-weight: 500; margin-bottom: 0.4rem; color: var(--gray-700); font-size: 0.9rem; }
        input[type="text"], input[type="date"], input[type="number"], textarea {
            width: 100%; padding: 0.65rem 0.9rem; border: 1px solid var(--gray-200); border-radius: 8px;
            font-family: var(--font-family); font-size: 0.9rem; color: var(--gray-700);
            transition: var(--transition);
        }
        input:focus, textarea:focus { outline: none; border-color: var(--primary-light); box-shadow: 0 0 0 3px rgba(74,143,199,0.15); }
        input[disabled] { background: var(--gray-100); color: var(--gray-500); cursor: not-allowed; }
        textarea { resize: vertical; }

        .error-msg { color: var(--danger); font-size: 0.8rem; margin-top: 0.3rem; display: block; }

        .btn-submit {
            padding: 0.75rem 1.75rem; background: var(--primary-blue); color: var(--white);
            border: none; border-radius: 50px; font-weight: 500; font-size: 0.9rem;
            font-family: var(--font-family); cursor: pointer; transition: var(--transition);
        }
        .btn-submit:hover { background: var(--primary-dark); transform: translateY(-2px); box-shadow: var(--shadow-md); }
    </style>
</head>
<body>
    <div class="wrap">
        <a href="{{ route('guru.catatankasus.show', ['idkelas' => $kelas->id, 'idsis' => $siswa->id]) }}" class="btn-back">
            <i class='bx bx-arrow-back'></i> Kembali
        </a>

        <h2>Tambah Catatan Kasus — {{ $siswa->namlen ?? $siswa->nampan }}</h2>

        <form action="{{ route('guru.catatankasus.store', ['idkelas' => $kelas->id, 'idsis' => $siswa->id]) }}" method="POST">
            @csrf

            <div class="field">
                <label>Dicatat oleh</label>
                <input type="text" value="{{ $guru->nam ?? 'Guru tidak ditemukan' }}" disabled>
            </div>

            <div class="field">
                <label>Tanggal</label>
                <input type="date" name="tanggal" value="{{ old('tanggal', now()->format('Y-m-d')) }}" required>
                @error('tanggal') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            <div class="field">
                <label>Deskripsi Kasus</label>
                <textarea name="deskripsi_kasus" rows="5" required>{{ old('deskripsi_kasus') }}</textarea>
                @error('deskripsi_kasus') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            <div class="field">
                <label>Jumlah Poin</label>
                <input type="number" name="jumlah_poin" min="0" value="{{ old('jumlah_poin', 0) }}" required>
                @error('jumlah_poin') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="btn-submit">Simpan Catatan</button>
        </form>
    </div>
</body>
</html>