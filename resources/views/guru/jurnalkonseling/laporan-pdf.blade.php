<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Jurnal Konseling - {{ $isikelas->nam ?? 'Kelas' }}</title>
    <style>
        @page {
            margin: 18mm 14mm 15mm 14mm;
        }
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 13px;
            color: #000;
            line-height: 1.35;
        }

        /* ===== KOP SURAT ===== */
        .kop-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 6px;
        }
        .kop-table td {
            border: none;
            vertical-align: middle;
        }
        .kop-logo {
            width: 110px;
            text-align: left;
        }
        .kop-logo img {
            width: 110px;
            height: auto;
            display: block;
        }
        .kop-spacer {
            width: 110px;
        }
        .kop-text {
            text-align: center;
        }
        .kop-text h1 {
            font-size: 18px;
            font-weight: bold;
            margin: 0;
            letter-spacing: 0.3px;
            text-transform: uppercase;
            white-space: nowrap;
        }
        .kop-text p.sub-naungan {
            font-size: 11.5px;
            font-style: italic;
            margin: 2px 0 4px 0;
        }
        .kop-text p {
            font-size: 12px;
            margin: 1px 0;
        }

        .garis-tebal {
            border-bottom: 3px double #000;
            margin-bottom: 16px;
        }

        /* ===== JUDUL ===== */
        .judul {
            text-align: center;
            margin-bottom: 14px;
        }
        .judul h3 {
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            margin: 0 0 8px 0;
            text-decoration: underline;
        }

        /* ===== INFO KELAS ===== */
        table.meta {
            width: 100%;
            font-size: 13px;
            margin: 10px 0 14px 0;
        }
        table.meta td {
            padding: 2px 0;
        }
        table.meta td.label { width: 150px; }
        table.meta td.colon { width: 16px; }

        /* ===== TABEL JURNAL ===== */
        table.jurnal {
            width: 100%;
            border-collapse: collapse;
            margin-top: 6px;
            table-layout: fixed;
            page-break-inside: auto;
        }
        table.jurnal tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }
        table.jurnal th,
        table.jurnal td {
            border: 1.3px solid #000;
            padding: 8px 7px;
            font-size: 12px;
            vertical-align: top;
            word-wrap: break-word;
        }
        table.jurnal th {
            text-align: center;
            font-weight: bold;
            background: #f0f0f0;
            font-size: 11.5px;
        }
        .col-no      { width: 5%;  text-align: center; }
        .col-tanggal { width: 12%; text-align: center; }
        .col-nama    { width: 17%; }
        .col-keluhan { width: 22%; }
        .col-tindak  { width: 22%; }
        .col-hasil   { width: 22%; }
        .row-blank   { height: 24px; }

        .empty-note {
            text-align: center;
            font-style: italic;
            padding: 25px;
        }

        /* ===== FOOTER ===== */
        .footer-sekolah {
            margin-top: 12px;
            font-size: 11px;
            font-style: italic;
        }

        .ttd-wrap {
            width: 100%;
            margin-top: 20px;
            page-break-inside: avoid;
        }
        .ttd-wrap table {
            width: 100%;
            border-collapse: collapse;
        }
        .ttd-wrap td {
            width: 50%;
            text-align: center;
            font-size: 13px;
            vertical-align: top;
        }
        .ttd-nama {
            margin-top: 55px;
            font-weight: bold;
            text-decoration: underline;
        }
    </style>
</head>
<body>

    {{-- ===== KOP SURAT ===== --}}
    <table class="kop-table">
        <tr>
            <td class="kop-logo">
                @if(!empty($logoPath) && file_exists($logoPath))
                    <img src="{{ $logoPath }}" alt="Logo">
                @endif
            </td>
            <td class="kop-text">
                <h1>{{ $namaSekolah ?? 'Nama Sekolah' }}</h1>
                <p class="sub-naungan">Mewujudkan Generasi Berbudi Pekerti, Mandiri dan Berprestasi</p>
                <p>{{ $alamatSekolah ?? '' }}</p>
            </td>
            <td class="kop-spacer"></td>
        </tr>
    </table>
    <div class="garis-tebal"></div>

    {{-- ===== JUDUL ===== --}}
    <div class="judul">
        <h3>Jurnal &amp; Laporan Layanan Bimbingan Konseling</h3>
    </div>

    {{-- ===== INFO KELAS ===== --}}
    <table class="meta">
        <tr><td class="label">Kelas</td><td class="colon">:</td><td>{{ $isikelas->nam ?? '-' }}</td></tr>
        <tr><td class="label">Tahun Pelajaran</td><td class="colon">:</td><td>{{ $tahunajaran ?? '-' }}</td></tr>
        <tr><td class="label">Wali Kelas</td><td class="colon">:</td><td>{{ $namaWaliKelas ?? '-' }}</td></tr>
        <tr><td class="label">Jumlah Siswa</td><td class="colon">:</td><td>{{ $jumlahSiswa ?? '-' }}</td></tr>
    </table>

    {{-- ===== TABEL ===== --}}
    <table class="jurnal">
        <thead>
            <tr>
                <th class="col-no">No</th>
                <th class="col-tanggal">Hari / Tgl</th>
                <th class="col-nama">Nama Siswa</th>
                <th class="col-keluhan">Keluhan / Kejadian</th>
                <th class="col-tindak">Tindak Lanjut</th>
                <th class="col-hasil">Hasil Tindak Lanjut</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($data as $i => $item)
                <tr>
                    <td class="col-no">{{ $i + 1 }}</td>
                    <td class="col-tanggal">{{ optional($item->tanggal)->translatedFormat('d-m-Y') ?? '-' }}</td>
                    <td class="col-nama">{{ $item->siswa->namlen ?? '-' }}</td>
                    <td class="col-keluhan">{{ $item->deskripsi_kegiatan ?? '-' }}</td>
                    <td class="col-tindak">{{ $item->rencana_tindak_lanjut ?: '-' }}</td>
                    <td class="col-hasil row-blank"></td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="empty-note">Belum ada catatan jurnal konseling di kelas ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer-sekolah">{{ $namaSekolah ?? '-' }}</div>

    {{-- ===== TTD ===== --}}
    <div class="ttd-wrap">
        <table>
            <tr>
                <td></td>
                <td>
                    <div>Mengetahui,</div>
                    <div>Guru BK / Wali Kelas</div>
                    <div class="ttd-nama">{{ $namaWaliKelas ?? '(.......................................)' }}</div>
                </td>
            </tr>
        </table>
    </div>

</body>
</html>