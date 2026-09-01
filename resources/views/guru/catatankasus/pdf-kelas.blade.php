<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Catatan Kasus - Kelas {{ $kelas->nam }}</title>
    <style>
        @page {
            margin: 20mm 15mm 15mm 15mm;
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
    width: 150px;       /* lebar kolom, disamain sama lebar gambar */
    text-align: left;   /* dari center -> left, biar nempel ke tulisan */
}
.kop-logo img {
    width: 150px;       /* dari 130px -> diperbesar beneran */
    height: auto;
    display: block;
}
.kop-spacer {
    width: 150px;        /* WAJIB disamain sama .kop-logo, biar teks tetap center halaman */
}
        .kop-text {
            text-align: center;
        }
        .kop-text h1 {
            font-size: 20px;
            font-weight: bold;
            margin: 0;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }
        .kop-text p.sub-naungan {
            font-size: 12px;
            font-style: italic;
            margin: 1px 0 4px 0;
        }
        .kop-text p {
            font-size: 12.5px;
            margin: 1px 0;
        }
        .kop-spacer {
            width: 100px;
        }

        .garis-tebal {
            border-bottom: 3px double #000;
            margin-bottom: 16px;
        }

        /* ===== JUDUL ===== */
        .judul {
            text-align: center;
            margin-bottom: 18px;
        }
        .judul h3 {
            font-size: 17px;
            font-weight: bold;
            text-transform: uppercase;
            margin: 0 0 8px 0;
            text-decoration: underline;
        }
        .judul p {
            font-size: 14px;
            margin: 2px 0;
        }

        /* ===== TABEL KASUS ===== */
        table.kasus {
            width: 100%;
            border-collapse: collapse;
            margin-top: 4px;
        }
        table.kasus th,
        table.kasus td {
            border: 1.3px solid #000;
            padding: 9px 8px;
            font-size: 13px;
            vertical-align: top;
        }
        table.kasus th {
            text-align: center;
            font-weight: bold;
            background: #f0f0f0;
            font-size: 13px;
        }
        .col-no      { width: 32px;  text-align: center; }
        .col-tanggal { width: 90px;  text-align: center; }
        .col-nama    { width: 160px; }
        .col-poin    { width: 55px;  text-align: center; }
        .col-guru    { width: 150px; text-align: center; }

        .empty-note {
            text-align: center;
            font-style: italic;
            padding: 25px;
        }

        /* ===== FOOTER ===== */
        .footer-total {
            margin-top: 14px;
            text-align: right;
            font-size: 14px;
            font-weight: bold;
        }

        .ttd-wrap {
            width: 100%;
            margin-top: 45px;
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
                <img src="{{ public_path('images/logo-sekolah.png') }}" alt="Logo">
            </td>
            <td class="kop-text">
                <h1>Sekolah Maitreyawira Deli Serdang</h1>
                <p>Mewujudkan Generasi Berbudi Pekerti, Mandiri dan Berprestasi</p>
                <p>Deli Serdang, Sumatera Utara</p>
            </td>
            <td class="kop-spacer"></td>
        </tr>
    </table>
    <div class="garis-tebal"></div>

    {{-- ===== JUDUL ===== --}}
    <div class="judul">
        <h3>Catatan Kasus Peserta Didik</h3>
        <p>Kelas {{ strtoupper($kelas->nam) }}</p>
        <p>Tahun Ajaran {{ $kelas->tahunajaran->nam ?? '____/____' }}</p>
    </div>

    {{-- ===== TABEL ===== --}}
    <table class="kasus">
        <thead>
            <tr>
                <th class="col-no">No</th>
                <th class="col-tanggal">Hari / Tgl</th>
                <th class="col-nama">Nama Siswa</th>
                <th>Uraian Kasus</th>
                <th class="col-poin">Poin</th>
                <th class="col-guru">Guru</th>
            </tr>
        </thead>
        <tbody>
            @forelse($catatan as $i => $item)
                <tr>
                    <td class="col-no">{{ $i + 1 }}</td>
                    <td class="col-tanggal">{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                    <td class="col-nama">{{ $item->nama_siswa }}</td>
                    <td>{{ $item->deskripsi_kasus }}</td>
                    <td class="col-poin">{{ $item->jumlah_poin }}</td>
                    <td class="col-guru">{{ $item->guru->nam ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="empty-note">Belum ada catatan kasus di kelas ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>


</body>
</html>