<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Buku Kasus - {{ $siswa->namlen ?? $siswa->nampan }}</title>
    <style>
        @page { margin: 25px 30px; }
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12px;
            color: #000;
        }
        .kop-table { width: 100%; border-collapse: collapse; margin-bottom: 4px; }
        .kop-table td { border: none; vertical-align: middle; }
        .kop-logo { width: 90px; text-align: center; }
.kop-logo {
    width: 100px;       /* lebar kolom, disamain sama lebar gambar */
    text-align: left;   /* dari center -> left, biar nempel ke tulisan */
}
.kop-logo img {
    width: 100px;       /* dari 130px -> diperbesar beneran */
    height: auto;
    display: block;
}
.kop-spacer {
    width: 100px;        /* WAJIB disamain sama .kop-logo, biar teks tetap center halaman */
}        .kop-text { text-align: center; }
        .kop-text h1 { font-size: 18px; font-weight: bold; margin: 0; }
        .kop-text h2 { font-size: 16px; font-weight: bold; margin: 2px 0 0 0; }
        .kop-text p { font-size: 12px; margin: 2px 0; }
        .garis-tebal { border-bottom: 3px double #000; margin-bottom: 14px; }

        .judul { text-align: center; margin-bottom: 6px; }
        .judul h3 { font-size: 15px; font-weight: bold; text-transform: uppercase; margin: 0 0 6px 0; }

        .info-siswa {
            width: 100%;
            margin-bottom: 14px;
            font-size: 12px;
        }
        .info-siswa td { padding: 2px 4px; }
        .info-siswa .label { width: 110px; }

        table.kasus { width: 100%; border-collapse: collapse; }
        table.kasus th, table.kasus td {
            border: 1px solid #000;
            padding: 8px 6px;
            font-size: 12px;
            vertical-align: top;
        }
        table.kasus th { text-align: center; font-weight: bold; }
        .col-no { width: 30px; text-align: center; }
        .col-tanggal { width: 85px; text-align: center; }
        .col-poin { width: 55px; text-align: center; }
        .col-guru { width: 150px; text-align: center; }
        .empty-note { text-align: center; font-style: italic; padding: 25px; }

        .footer-total {
            margin-top: 12px;
            text-align: right;
            font-size: 13px;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <table class="kop-table">
        <tr>
            <td class="kop-logo">
                <img src="{{ public_path('images/logo-sekolah.png') }}" alt="Logo">
            </td>
            <td class="kop-text">
                <h1>SEKOLAH MAITREYA WIRA</h1>
                <p>Mewujudkan Generasi Berbudi Pekerti, Mandiri dan Berprestasi</p>
                <p>Deli Serdang, Sumatera Utara</p>
            </td>
            <td class="kop-spacer"></td>
        </tr>
    </table>
    <div class="garis-tebal"></div>

    <div class="judul">
        <h3>Buku Catatan Kasus Peserta Didik</h3>
    </div>

    <table class="info-siswa">
        <tr>
            <td class="label">Nama Siswa</td><td>: {{ $siswa->namlen ?? $siswa->nampan }}</td>
            <td class="label">Kelas</td><td>: {{ $kelas->nam }}</td>
        </tr>
        <tr>
            <td class="label">Tahun Ajaran</td><td>: {{ $kelas->tahunajaran->nam ?? '-' }}</td>
            <td class="label">Total Poin</td><td>: {{ $totalPoin }}</td>
        </tr>
    </table>

    <table class="kasus">
        <thead>
            <tr>
                <th class="col-no">No</th>
                <th class="col-tanggal">Hari / Tgl</th>
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
                    <td>{{ $item->deskripsi_kasus }}</td>
                    <td class="col-poin">{{ $item->jumlah_poin }}</td>
                    <td class="col-guru">{{ $item->guru->nam ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="empty-note">Belum ada catatan kasus untuk siswa ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer-total">
        Total Poin: {{ $totalPoin }}
    </div>

</body>
</html>