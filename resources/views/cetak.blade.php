<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>SKBP</title>

    <style>
        body {
            font-family: "Times New Roman", serif;
            font-size: 12pt;
            line-height: 1.6;
        }

        .kop {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .kop td {
            vertical-align: middle;
            padding: 0px;
        }

        .kop-logo {
            width: 20%;
            text-align: center;
        }

        .kop-logo img {
            width: 90px;
        }

        .kop-judul {
            width: 85%;
            text-align: justify;
            font-weight: bold;
            padding: 0;
        }

        .kop-judul h2 {
            margin: 0;
            padding: 0;
            font-size: 20px;
        }

        .kop-judul h3 {
            margin: 0;
            padding: 0;
            font-size: 21px;
        }

        .kop-info-left {
            width: 60%;
            font-size: 11px;
            text-align: justify;
        }

        .kop-info-right {
            width: 40%;
            font-size: 11px;
            text-align: left;
        }

        /* tabel info */
        .kop-info-left table,
        .kop-info-right table {
            width: 100%;
            border-collapse: collapse;
            line-height: 1.3;
            font-size: 11px;
        }

        .kop-info-left td,
        .kop-info-right td {
            padding: 1px 2px;
            vertical-align: top;
        }

        /* KUNCI PERBAIKAN DI SINI */
        .kop-info-left td.label {
            width: 50px;
            /* sebelumnya terlalu besar */
            white-space: nowrap;
        }

        .kop-info-right td.label {
            width: 70px;
            white-space: nowrap;
        }

        .kop-info-left td.colon,
        .kop-info-right td.colon {
            width: 6px;
            text-align: center;
        }


        /* link */
        .link {
            color: blue;
            text-decoration: none;
        }

        .kop-line {
            border-bottom: 3px solid black;
            margin-bottom: 20px;
        }


        .judul {
            text-align: center;
            font-weight: bold;
            text-decoration: underline;
            margin-top: 20px;
        }

        .nomor {
            text-align: center;
            margin-bottom: 0px;
        }

        .isi p {
            text-align: justify;
        }

        .data {
            margin-left: 40px;
        }

        .data td {
            padding: 4px 8px;
        }

        .ttd {
            width: 100%;
            margin-top: 40px;
        }

        .qr {
            position: absolute;
            bottom: 100px;
            left: 50px;
        }
    </style>
</head>

<body>

    <table class="kop">
        <tr>
            <!-- LOGO -->
            <td class="kop-logo" rowspan="2">
                <img src="{{ public_path('favicon.png') }}">
            </td>

            <!-- JUDUL -->
            <td class="kop-judul" colspan="2">
                <h2>UNIVERSITAS MUHAMMADIYAH PALANGKARAYA</h2>
                <h3>BIRO PERPUSTAKAAN DAN PENGELOLAAN JURNAL</h3>
            </td>
        </tr>

        <tr>
            <!-- INFO KIRI -->
            <td class="kop-info-left">
                <table>
                    <tr>
                        <td class="label">Kampus Utama</td>
                        <td class="colon">:</td>
                        <td>Jln. RTA Milono Km. 1,5 Palangka Raya, Kal-Teng</td>
                    </tr>
                    <tr>
                        <td class="label">Nomor Kontak</td>
                        <td class="colon">:</td>
                        <td>+62 821-9080-2415</td>
                    </tr>
                    <tr>
                        <td class="label">Email</td>
                        <td class="colon">:</td>
                        <td>
                            <span class="link">library@umpr.ac.id</span> /
                            <span class="link">library.umpalangkaraya@gmail.com</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">Website</td>
                        <td class="colon">:</td>
                        <td><span class="link">https://library.umpr.ac.id</span></td>
                    </tr>
                </table>
            </td>

            <!-- INFO KANAN -->
            <td class="kop-info-right">
                <table>
                    <tr>
                        <td class="label">NPP</td>
                        <td class="colon">:</td>
                        <td>6271012D0000001</td>
                    </tr>
                    <tr>
                        <td class="label">OPAC</td>
                        <td class="colon">:</td>
                        <td><span class="link">https://lib.umpr.ac.id</span></td>
                    </tr>
                    <tr>
                        <td class="label">Repository</td>
                        <td class="colon">:</td>
                        <td><span class="link">https://repository.umpr.ac.id</span></td>
                    </tr>
                    <tr>
                        <td class="label">Instagram</td>
                        <td class="colon">:</td>
                        <td>@perpustakaan_umpr</td>
                    </tr>
                </table>
            </td>
        </tr>

    </table>


    <div class="kop-line"></div>

    <div class="judul">SURAT KETERANGAN BEBAS PINJAM</div>
    <div class="nomor">
        <b>Nomor: {{ $urut }}/PTM.63.R.13/X/{{ $tahun }}</b>
    </div>

    <div class="isi">
        <p>
            <b>Kepala Biro Perpustakaan dan Pengelolaan Jurnal Universitas Muhammadiyah Palangkaraya,</b>
            dengan ini menerangkan bahwa:
        </p>

        <table class="data">
            <tr>
                <td width="120">Nama</td>
                <td>:</td>
                <td>{{ $skbp->nama }}</td>
            </tr>
            <tr>
                <td>NIM</td>
                <td>:</td>
                <td>{{ $skbp->nim }}</td>
            </tr>
            <tr>
                <td>Fakultas</td>
                <td>:</td>
                <td>{{ $skbp->fakultas }}</td>
            </tr>
            <tr>
                <td>Program Studi</td>
                <td>:</td>
                <td>{{ $skbp->jurusan }}</td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>:</td>
                <td>{{ $skbp->alamat }}</td>
            </tr>
        </table>

        <p>
            Dari hasil pengecekan, bahwa nama tersebut di atas telah memenuhi persyaratan dan
            dinyatakan <b>bersih dari pinjam buku dan bahan pustaka lainnya</b> pada
            UPT Perpustakaan Universitas Muhammadiyah Palangkaraya.
        </p>

        <p>
            Demikian surat keterangan bebas pinjam ini diberikan untuk keperluan
            <b>Yudisium/Pengambilan Ijazah</b>, agar dapat dipergunakan sebagaimana mestinya.
        </p>
    </div>

    <table class="ttd">
        <tr>
            <td width="60%"></td>
            <td>
                Palangka Raya, {{ \Carbon\Carbon::parse($skbp->valid_skbp_time)->format('d F Y') }}<br>
                <b>Kepala Biro</b><br>
                <b>Perpustakaan dan Pengelolaan Jurnal</b>
                <br><br><img src="data:image/png;base64,{{ $barcode }}" width="90"><br><br>
                <b>Ir. Achmad Imam Santoso, ST., M.Ling</b><br>
                <b>NIK. 19.0502.027</b>
            </td>
        </tr>
    </table>


</body>

</html>