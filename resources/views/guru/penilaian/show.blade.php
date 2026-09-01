<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Nilai {{ $pelajaran->nam ?? '' }} - {{ $kelas->nam ?? 'Kelas' }}</title>
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
            --success-border: #a7f3d0;
            --success-text: #065f46;
            --error-bg: #fef2f2;
            --error-border: #fecaca;
            --error-text: #991b1b;
            --shadow-sm: 0 1px 2px rgba(26, 42, 74, 0.05);
            --shadow: 0 1px 3px rgba(26, 42, 74, 0.08), 0 1px 2px rgba(26, 42, 74, 0.06);
            --shadow-md: 0 4px 6px rgba(26, 42, 74, 0.07), 0 2px 4px rgba(26, 42, 74, 0.06);
            --radius: 12px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            --font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: var(--font-family); background: var(--gray-50); color: var(--gray-800); min-height: 100vh; line-height: 1.6; }

        .dashboard { max-width: 1180px; margin: 0 auto; padding: 1.5rem; }

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

        .page-header { margin-bottom: 1.25rem; }
        .page-header .eyebrow { font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; color: var(--primary-light); font-weight: 600; }
        .page-header h1 { font-size: 1.5rem; color: var(--primary-dark); margin: 0.2rem 0 0; }

        .alert { padding: 0.75rem 1rem; border-radius: 10px; margin-bottom: 1rem; font-size: 0.875rem; }
        .alert-success { background: var(--success-bg); border: 1px solid var(--success-border); color: var(--success-text); }
        .alert-error { background: var(--error-bg); border: 1px solid var(--error-border); color: var(--error-text); }
        .alert-error ul { margin: 0.35rem 0 0 1.1rem; }

        table.nilai-table { width: 100%; border-collapse: collapse; background: var(--white); border-radius: var(--radius); overflow: hidden; box-shadow: var(--shadow); }
        table.nilai-table th {
            text-align: left; background: var(--primary-bg); color: var(--gray-700);
            font-size: 0.78rem; text-transform: uppercase; letter-spacing: 0.03em; padding: 0.75rem 1rem;
        }
        table.nilai-table td { padding: 0.85rem 1rem; border-top: 1px solid var(--gray-100); vertical-align: top; }
        .siswa-nama { font-weight: 600; color: var(--gray-800); }
        .siswa-nis { font-size: 0.75rem; color: var(--gray-400); }

        .entry-row { display: flex; gap: 0.5rem; margin-bottom: 0.5rem; align-items: center; flex-wrap: wrap; padding: 0.25rem; border-radius: 8px; }
        .entry-row.has-error { background: var(--error-bg); outline: 1px solid var(--error-border); }
        .entry-row select, .entry-row input[type=number], .entry-row input[type=text] {
            border: 1px solid var(--gray-200); border-radius: 8px; padding: 0.4rem 0.6rem;
            font-family: inherit; font-size: 0.85rem;
        }
        .entry-row select.select-jenis { flex: 1.3; min-width: 140px; }
        .entry-row select.select-tugas { flex: 1.3; min-width: 160px; }
        .entry-row select.select-tugas.is-hidden { display: none; }
        .entry-row select.select-tugas.is-loading { color: var(--gray-400); }
        .entry-row select.select-tugas.field-error,
        .entry-row input[type=number].field-error { border-color: #ef4444; }
        .entry-row input[type=number] { flex: 0.7; min-width: 70px; }
        .entry-row input.input-catatan { flex: 1.5; min-width: 160px; }
        .entry-row input.input-catatan.is-hidden { display: none; }
        .entry-remove { background: none; border: none; color: #ef4444; cursor: pointer; font-size: 1.1rem; line-height: 1; padding: 0.2rem; }
        .entry-error-msg { flex-basis: 100%; font-size: 0.75rem; color: var(--error-text); margin-top: -0.15rem; }

        .add-btn {
            border: 1px dashed var(--gray-300); background: var(--gray-50); color: var(--primary-blue);
            border-radius: 8px; padding: 0.35rem 0.75rem; font-size: 0.8rem; font-weight: 500;
            cursor: pointer; font-family: inherit;
        }
        .add-btn:hover { background: var(--primary-bg); }

        .form-actions { display: flex; gap: 0.75rem; margin-top: 1.5rem; flex-wrap: wrap; }
        .btn { border: none; border-radius: 50px; padding: 0.7rem 1.75rem; font-weight: 600; font-size: 0.875rem; cursor: pointer; text-decoration: none; display: inline-flex; align-items: center; gap: 0.4rem; font-family: inherit; transition: var(--transition); }
        .btn-primary { background: var(--primary-blue); color: var(--white); }
        .btn-primary:hover { background: var(--primary-dark); }
        .btn-outline { background: var(--white); color: var(--primary-blue); border: 1px solid var(--gray-300); }
        .btn-outline:hover { border-color: var(--primary-blue); }

        .empty-state { text-align: center; color: var(--gray-400); }

        @media (max-width: 768px) {
            .dashboard { padding: 1rem; }
            table.nilai-table th, table.nilai-table td { padding: 0.6rem 0.75rem; font-size: 0.85rem; }
            .entry-row { flex-wrap: wrap; }
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <div class="top-nav">
            <a href="{{ route('guru.penilaiansiswa', ['idKelas' => $kelas->id]) }}" class="btn-back">
                <i class='bx bx-arrow-back'></i>
                Kembali
            </a>
            <div class="top-nav-title">
                <i class='bx bxs-dashboard' style="margin-right: 0.3rem;"></i>
                Input Nilai <span>Kelas {{ $kelas->nam ?? '' }}</span>
            </div>
        </div>

        <div class="page-header">
            <div class="eyebrow">Kelas {{ $kelas->nam }}</div>
            <h1>{{ $pelajaran->nam }}</h1>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-error">
                <strong>Periksa lagi input nilai:</strong>
                <ul>
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST"
              action="{{ route('guru.penilaiansiswa.store', ['idKelas' => $kelas->id, 'idPelajaran' => $pelajaran->id]) }}">
            @csrf

            <table class="nilai-table">
                <thead>
                    <tr>
                        <th style="width: 26%;">Nama Siswa</th>
                        <th>Jenis Nilai &amp; Nilai</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($siswaList as $siswa)
                        @php
                            $existing = $nilaiTersimpan->get($siswa->id, collect());

                            // PENTING: kalau request sebelumnya gagal validasi, Laravel
                            // redirect()->back()->withErrors() otomatis nge-flash old
                            // input ke session. Karena request GAGAL divalidasi, TIDAK
                            // ADA yang tersimpan ke tnilai. Kalau kita render dari
                            // $nilaiTersimpan (data DB) di sini, hasilnya balik ke data
                            // lama/kosong -> kelihatan seperti pilihan user "hilang",
                            // padahal dia memang sudah memilihnya sebelum submit.
                            // Makanya old() harus diprioritaskan di atas data DB.
                            $oldEntries = old("nilai.{$siswa->id}");
                            $entries = $oldEntries !== null ? collect($oldEntries) : $existing;
                        @endphp
                        <tr>
                            <td>
                                <div class="siswa-nama">{{ $siswa->namlen }}</div>
                                <div class="siswa-nis">NIS {{ $siswa->nis }}</div>
                            </td>
                            <td>
                                <div class="entries" data-siswa="{{ $siswa->id }}">
                                    @foreach ($entries as $i => $n)
                                        @php
                                            // $n bisa array (hasil old(), sumbernya request lama)
                                            // atau object Eloquent (hasil $nilaiTersimpan / DB).
                                            $idJenisNilai = is_array($n) ? ($n['idjenisnilai'] ?? null) : $n->idjenisnilai;
                                            $idTugas      = is_array($n) ? ($n['idtugas'] ?? null)      : $n->idtugas;
                                            $nilaiVal     = is_array($n) ? ($n['nilai'] ?? null)        : $n->nilai;

                                            // Catatan: kalau dari old() ambil langsung dari input
                                            // sebelumnya; kalau dari DB, catatan aslinya ada di
                                            // ttugas1 (bukan tnilai), jadi di-lookup dari situ.
                                            $catatanVal = is_array($n)
                                                ? ($n['catatan'] ?? null)
                                                : optional($catatanTugasMap->get($siswa->id.'-'.$idTugas))->catatan;

                                            $judulTugasTersimpan = $idTugas ? optional($semuaTugas->get($idTugas))->judul : null;

                                            $errKeyTugas = "nilai.$siswa->id.$i.idtugas";
                                            $errKeyNilai = "nilai.$siswa->id.$i.nilai";
                                            $rowHasError = $errors->has($errKeyTugas) || $errors->has($errKeyNilai);
                                        @endphp
                                        <div class="entry-row @if($rowHasError) has-error @endif"
                                             data-existing-idtugas="{{ $idTugas }}"
                                             data-existing-judul="{{ $judulTugasTersimpan }}">
                                            <select class="select-jenis" name="nilai[{{ $siswa->id }}][{{ $i }}][idjenisnilai]">
                                                @foreach ($jenisNilaiList as $jn)
                                                    <option value="{{ $jn->id }}" data-tipe="{{ $jn->tipe }}" @selected($jn->id == $idJenisNilai)>{{ $jn->nama }}</option>
                                                @endforeach
                                            </select>
                                            <select class="select-tugas is-hidden @if($errors->has($errKeyTugas)) field-error @endif"
                                                    name="nilai[{{ $siswa->id }}][{{ $i }}][idtugas]" disabled>
                                                <option value="">- Pilih Tugas -</option>
                                            </select>
                                            <input type="number" step="0.01" min="0" max="100"
                                                   class="@if($errors->has($errKeyNilai)) field-error @endif"
                                                   name="nilai[{{ $siswa->id }}][{{ $i }}][nilai]"
                                                   value="{{ $nilaiVal }}" placeholder="Nilai">
                                            <input type="text" maxlength="255"
                                                   class="input-catatan @if(! $idTugas) is-hidden @endif"
                                                   name="nilai[{{ $siswa->id }}][{{ $i }}][catatan]"
                                                   value="{{ $catatanVal }}" placeholder="Catatan (opsional)">
                                            <button type="button" class="entry-remove" onclick="hapusBarisNilai(this)">&times;</button>
                                            @if ($errors->has($errKeyTugas))
                                                <div class="entry-error-msg">{{ $errors->first($errKeyTugas) }}</div>
                                            @endif
                                            @if ($errors->has($errKeyNilai))
                                                <div class="entry-error-msg">{{ $errors->first($errKeyNilai) }}</div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                                <button type="button" class="add-btn" onclick="tambahBarisNilai({{ $siswa->id }})">
                                    + Tambah Nilai
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="empty-state">Belum ada siswa aktif di kelas ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class='bx bx-check'></i> Submit
                </button>
                <a href="{{ route('guru.penilaiansiswa.laporan', ['idKelas' => $kelas->id, 'idPelajaran' => $pelajaran->id]) }}"
                   class="btn btn-outline">
                    <i class='bx bx-bar-chart-alt-2'></i> View Laporan
                </a>
            </div>
        </form>
    </div>

    <template id="row-template">
        <div class="entry-row">
            <select class="select-jenis" name="">
                @foreach ($jenisNilaiList as $jn)
                    <option value="{{ $jn->id }}" data-tipe="{{ $jn->tipe }}">{{ $jn->nama }}</option>
                @endforeach
            </select>
            <select class="select-tugas is-hidden" name="" disabled>
                <option value="">- Pilih Tugas -</option>
            </select>
            <input type="number" step="0.01" min="0" max="100" name="" placeholder="Nilai">
            <input type="text" maxlength="255" class="input-catatan is-hidden" name="" placeholder="Catatan (opsional)">
            <button type="button" class="entry-remove" onclick="hapusBarisNilai(this)">&times;</button>
        </div>
    </template>

    @php
        // Dipindah ke sini (bukan inline di dalam @json(...)) karena Blade
        // pernah gagal parse array multi-baris bersarang langsung di dalam
        // argumen directive @json(), menyebabkan error "Unclosed '['".
        $tugasEndpointUrl = route('guru.penilaiansiswa.tugas-by-context', [
            'idKelas' => $kelas->id,
            'idPelajaran' => $pelajaran->id,
        ]);
    @endphp

    <script>
        const TUGAS_ENDPOINT = @json($tugasEndpointUrl);

        // Cache PER SISWA (bukan global), karena sekarang daftar tugas
        // yang boleh dipilih beda-beda tiap siswa: tugas yang statusnya
        // "sudah" atau sudah dinilai di ttugas1/tnilai buat siswa itu
        // di-exclude di server (lihat PenilaianService::daftarTugasUntukKonteks).
        const tugasCacheBySiswa = {};
        function ambilDaftarTugas(idSiswa) {
            if (! tugasCacheBySiswa[idSiswa]) {
                const url = TUGAS_ENDPOINT + '?idsiswa=' + encodeURIComponent(idSiswa);
                tugasCacheBySiswa[idSiswa] = fetch(url, {
                    headers: { 'Accept': 'application/json' },
                })
                    .then(res => {
                        if (! res.ok) throw new Error('Gagal memuat daftar tugas');
                        return res.json();
                    })
                    .catch(err => {
                        delete tugasCacheBySiswa[idSiswa]; // biar bisa dicoba lagi kalau gagal
                        console.error(err);
                        return [];
                    });
            }
            return tugasCacheBySiswa[idSiswa];
        }

        function tampilkanOpsiTugas(selectTugas, daftarTugas, selectedId, existingJudul) {
            let opsi = daftarTugas.slice();

            // Tugas yang lagi dipilih di BARIS INI SENDIRI otomatis
            // ke-exclude dari hasil server (soalnya "sudah dinilai" oleh
            // baris ini). Kalau gak ditambahin manual, pas edit ulang
            // baris yang udah tersimpan, opsinya kelihatan hilang/kosong.
            if (selectedId && ! opsi.some(t => String(t.id) === String(selectedId))) {
                opsi = [{ id: selectedId, judul: existingJudul || '(tugas ini)' }, ...opsi];
            }

            selectTugas.innerHTML = '<option value="">- Pilih Tugas -</option>' +
                opsi.map(t => {
                    const selected = String(t.id) === String(selectedId) ? 'selected' : '';
                    return `<option value="${t.id}" ${selected}>${t.judul}</option>`;
                }).join('');
        }

        function toggleFieldsByJenis(entryRow, selectedIdTugas = null) {
            const selectJenis  = entryRow.querySelector('.select-jenis');
            const selectTugas  = entryRow.querySelector('.select-tugas');
            const inputCatatan = entryRow.querySelector('.input-catatan');
            const opt  = selectJenis.selectedOptions[0];
            const tipe = opt ? opt.dataset.tipe : '0';

            if (tipe === '1') {
                selectTugas.classList.remove('is-hidden');
                selectTugas.disabled = false;
                inputCatatan.classList.remove('is-hidden');
                inputCatatan.disabled = false;

                selectTugas.classList.add('is-loading');
                selectTugas.innerHTML = '<option value="">Memuat tugas...</option>';

                const idSiswa       = entryRow.closest('.entries').dataset.siswa;
                const existingJudul = entryRow.dataset.existingJudul || '';

                ambilDaftarTugas(idSiswa).then(daftarTugas => {
                    tampilkanOpsiTugas(selectTugas, daftarTugas, selectedIdTugas, existingJudul);
                    selectTugas.classList.remove('is-loading');
                });
            } else {
                selectTugas.classList.add('is-hidden');
                selectTugas.disabled = true; // biar tidak ikut ke-submit
                selectTugas.value = '';

                inputCatatan.classList.add('is-hidden');
                inputCatatan.disabled = true; // biar tidak ikut ke-submit
                inputCatatan.value = '';
            }
        }

        function tambahBarisNilai(idSiswa) {
            const container = document.querySelector('.entries[data-siswa="' + idSiswa + '"]');
            const index = container.querySelectorAll('.entry-row').length;

            const tpl = document.getElementById('row-template').content.cloneNode(true);
            const row = tpl.querySelector('.entry-row');
            const selectJenis  = row.querySelector('.select-jenis');
            const selectTugas  = row.querySelector('.select-tugas');
            const inputCatatan = row.querySelector('.input-catatan');
            const input = row.querySelector('input[type=number]');

            selectJenis.name  = 'nilai[' + idSiswa + '][' + index + '][idjenisnilai]';
            selectTugas.name  = 'nilai[' + idSiswa + '][' + index + '][idtugas]';
            input.name        = 'nilai[' + idSiswa + '][' + index + '][nilai]';
            inputCatatan.name = 'nilai[' + idSiswa + '][' + index + '][catatan]';

            container.appendChild(row);

            // PENTING: jangan nunggu event 'change'. Kalau opsi jenis nilai
            // yang otomatis ke-select duluan (opsi pertama di <select>)
            // kebetulan tipenya "tugas", user gak pernah beneran "mengubah"
            // pilihan itu -> event change gak pernah nyala -> dropdown tugas
            // gak pernah muncul/aktif walau kelihatannya jenis nilai udah
            // "tugas". Makanya state awal dicek manual persis setelah baris
            // ditambahkan, gak nunggu user ngoprek dropdown-nya.
            toggleFieldsByJenis(row);
        }

        function hapusBarisNilai(btn) {
            btn.closest('.entry-row').remove();
        }

        // Delegasi event: pasang listener sekali di document, bukan per-select,
        // supaya baris baru hasil tambahBarisNilai() otomatis ke-cover juga.
        document.addEventListener('change', function (e) {
            if (e.target.classList.contains('select-jenis')) {
                toggleFieldsByJenis(e.target.closest('.entry-row'));
            }
        });

        // Munculkan dropdown tugas + catatan utk baris yang SUDAH TERSIMPAN /
        // hasil old() dan tipe jenis nilainya "tugas".
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.entry-row[data-existing-idtugas]').forEach(row => {
                const idTugas = row.dataset.existingIdtugas;
                const opt = row.querySelector('.select-jenis').selectedOptions[0];
                if (idTugas && idTugas !== '' && opt && opt.dataset.tipe === '1') {
                    toggleFieldsByJenis(row, idTugas);
                }
            });
        });
    </script>
</body>
</html>