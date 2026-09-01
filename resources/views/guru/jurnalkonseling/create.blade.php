<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Jurnal Konseling - {{ $siswaData->namlen ?? 'Siswa' }}</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-dark: #1a2a4a; --primary-blue: #2c5f8a; --primary-light: #4a8fc7; --primary-bg: #f0f4f8;
            --white: #ffffff; --gray-50: #f8fafc; --gray-100: #f1f5f9; --gray-200: #e2e8f0; --gray-500: #64748b;
            --gray-700: #334155; --gray-800: #1e293b; --radius: 12px; --shadow-sm: 0 1px 2px rgba(26,42,74,.05);
            --shadow-md: 0 4px 6px rgba(26,42,74,.07), 0 2px 4px rgba(26,42,74,.06);
            --transition: all .3s cubic-bezier(.4,0,.2,1); --font-family: 'Poppins', sans-serif;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: var(--font-family); background: var(--gray-50); color: var(--gray-800); min-height: 100vh; }
        .wrap { max-width: 720px; margin: 0 auto; padding: 1.5rem; }
        .btn-back {
            display: inline-flex; align-items: center; gap: .5rem; padding: .65rem 1.5rem; background: var(--white);
            border: 1px solid var(--gray-200); border-radius: 50px; color: var(--gray-700); font-weight: 500;
            font-size: .875rem; text-decoration: none; box-shadow: var(--shadow-sm); margin-bottom: 1.5rem; transition: var(--transition);
        }
        .btn-back:hover { background: var(--primary-blue); border-color: var(--primary-blue); color: var(--white); }
        .card { background: var(--white); border-radius: var(--radius); padding: 2rem; box-shadow: var(--shadow-sm); border: 1px solid var(--gray-200); }
        .card h1 { font-size: 1.35rem; color: var(--primary-dark); margin-bottom: .25rem; display: flex; align-items: center; gap: .5rem; }
        .card .subtitle { color: var(--gray-500); font-size: .875rem; margin-bottom: 1.75rem; }

        .siswa-info {
            display: flex; align-items: center; gap: .75rem; background: var(--primary-bg);
            border: 1px solid var(--gray-200); border-radius: var(--radius); padding: .9rem 1.1rem;
            margin-bottom: 1.5rem;
        }
        .siswa-info .avatar {
            width: 42px; height: 42px; border-radius: 50%; background: linear-gradient(135deg, var(--primary-blue), var(--primary-light));
            color: var(--white); display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 1rem; flex-shrink: 0;
        }
        .siswa-info .nama { font-weight: 600; color: var(--primary-dark); font-size: .95rem; }
        .siswa-info .label { font-size: .75rem; color: var(--gray-500); }

        .form-group { margin-bottom: 1.25rem; }
        .form-row { display: flex; gap: 1rem; }
        .form-row .form-group { flex: 1; }
        label { display: block; font-size: .85rem; font-weight: 600; color: var(--gray-700); margin-bottom: .4rem; }
        select, input, textarea {
            width: 100%; padding: .7rem .9rem; border: 1px solid var(--gray-200); border-radius: 8px;
            font-family: var(--font-family); font-size: .9rem; color: var(--gray-800); background: var(--white);
        }
        select:focus, input:focus, textarea:focus { outline: none; border-color: var(--primary-light); }
        textarea { resize: vertical; min-height: 90px; }

        .error-text { color: #dc2626; font-size: .8rem; margin-top: .3rem; }
        .errors-box { background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; padding: 1rem 1.25rem; border-radius: var(--radius); margin-bottom: 1.5rem; font-size: .875rem; }
        .errors-box ul { margin-left: 1.1rem; margin-top: .3rem; }

        .form-actions { display: flex; gap: .75rem; margin-top: 1.75rem; }
        .btn-submit {
            padding: .75rem 1.6rem; border: none; border-radius: 50px; font-weight: 600; font-size: .9rem; cursor: pointer;
            background: linear-gradient(135deg, var(--primary-blue), var(--primary-light)); color: var(--white);
            box-shadow: var(--shadow-md); transition: var(--transition); font-family: var(--font-family);
        }
        .btn-submit:hover { transform: translateY(-2px); }
        .btn-cancel {
            padding: .75rem 1.6rem; border-radius: 50px; font-weight: 600; font-size: .9rem; text-decoration: none;
            background: var(--gray-100); color: var(--gray-700); display: inline-flex; align-items: center;
        }
    </style>
</head>
<body>
    <div class="wrap">
        <a href="{{ route('guru.jurnalkonseling.show', [$isikelas->id, $siswaData->id]) }}" class="btn-back">
            <i class='bx bx-arrow-back'></i> Kembali ke Jurnal Konseling
        </a>

        <div class="card">
            <h1><i class='bx bx-chat'></i> Tambah Jurnal Konseling</h1>
            <p class="subtitle">Kelas {{ $isikelas->nam ?? '' }}</p>

            <div class="siswa-info">
                <div class="avatar">{{ strtoupper(substr($siswaData->namlen ?? '?', 0, 1)) }}</div>
                <div>
                    <div class="label">Siswa</div>
                    <div class="nama">{{ $siswaData->namlen ?? '-' }}</div>
                </div>
            </div>

            @if ($errors->any())
                <div class="errors-box">
                    Terdapat kesalahan pada input:
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('guru.jurnalkonseling.store', [$isikelas->id, $siswaData->id]) }}">
                @csrf

                <div class="form-group">
                    <label for="tanggal">Tanggal</label>
                    <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal') }}" required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="waktu_mulai">Waktu Mulai</label>
                        <input type="time" name="waktu_mulai" id="waktu_mulai" value="{{ old('waktu_mulai') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="waktu_selesai">Waktu Selesai</label>
                        <input type="time" name="waktu_selesai" id="waktu_selesai" value="{{ old('waktu_selesai') }}" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="deskripsi_kegiatan">Deskripsi Kegiatan</label>
                    <textarea name="deskripsi_kegiatan" id="deskripsi_kegiatan" required>{{ old('deskripsi_kegiatan') }}</textarea>
                </div>

                <div class="form-group">
                    <label for="rencana_tindak_lanjut">Rencana Tindak Lanjut</label>
                    <textarea name="rencana_tindak_lanjut" id="rencana_tindak_lanjut">{{ old('rencana_tindak_lanjut') }}</textarea>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-submit"><i class='bx bx-save'></i> Simpan</button>
                    <a href="{{ route('guru.jurnalkonseling.show', [$isikelas->id, $siswaData->id]) }}" class="btn-cancel">Batal</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>