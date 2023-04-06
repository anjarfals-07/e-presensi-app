<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>A4</title>

    <!-- Normalize or reset CSS with your favorite library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">

    <!-- Load paper.css for happy printing -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">

    <!-- Set page size here: A5, A4 or A3 -->
    <!-- Set also "landscape" if you need -->
    <style>
        @page {
            margin: 0
        }

        body {
            margin: 0
        }

        .sheet {
            margin: 0;
            overflow: hidden;
            position: relative;
            box-sizing: border-box;
            page-break-after: always;
        }

        /** Paper sizes **/
        body.A3 .sheet {
            width: 297mm;
            height: 419mm
        }

        body.A3.landscape .sheet {
            width: 420mm;
            height: 296mm
        }

        body.A4 .sheet {
            width: 210mm;
            height: 296mm
        }

        body.A4.landscape .sheet {
            width: 297mm;
            height: 209mm
        }

        body.A5 .sheet {
            width: 148mm;
            height: 209mm
        }

        body.A5.landscape .sheet {
            width: 210mm;
            height: 147mm
        }

        body.letter .sheet {
            width: 216mm;
            height: 279mm
        }

        body.letter.landscape .sheet {
            width: 280mm;
            height: 215mm
        }

        body.legal .sheet {
            width: 216mm;
            height: 356mm
        }

        body.legal.landscape .sheet {
            width: 357mm;
            height: 215mm
        }

        /** Padding area **/
        .sheet.padding-10mm {
            padding: 10mm
        }

        .sheet.padding-15mm {
            padding: 15mm
        }

        .sheet.padding-20mm {
            padding: 20mm
        }

        .sheet.padding-25mm {
            padding: 25mm
        }

        /** For screen preview **/
        @media screen {
            body {
                background: #e0e0e0
            }

            .sheet {
                background: white;
                box-shadow: 0 .5mm 2mm rgba(0, 0, 0, .3);
                margin: 5mm auto;
            }
        }

        /** Fix for Chrome issue #273306 **/
        @media print {
            body.A3.landscape {
                width: 420mm
            }

            body.A3,
            body.A4.landscape {
                width: 297mm
            }

            body.A4,
            body.A5.landscape {
                width: 210mm
            }

            body.A5 {
                width: 148mm
            }

            body.letter,
            body.legal {
                width: 216mm
            }

            body.letter.landscape {
                width: 280mm
            }

            body.legal.landscape {
                width: 357mm
            }
        }

        table {
            page-break-before: always;
        }

        @media print {
            .element-that-contains-table {
                overflow: visible !important;
            }
        }

        thead {
            display: table-header-group;
        }

        tfoot {
            display: table-row-group;
        }

        tr {
            page-break-inside: avoid;
        }

        #title {
            font-family: 'Times New Roman', Times, serif;
            font-size: 20px;
            font-weight: bold
        }

        .tablekaryawan {
            margin-top: 30px;
        }

        .tablekaryawan td {
            padding: 5px;
        }

        .table-presensi {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        .table-presensi tr th {
            background-color: #9d9e9e;
            border: 1px solid #000;
            padding: 8px;
            color: #000;
            font-size: 10px
        }

        .table-presensi tr td {
            border: 1px solid #000;
            color: #000;
            font-size: 10px
        }

        .foto {
            width: 40px;
            height: 40px;
        }
    </style>
</head>

<!-- Set "A5", "A4" or "A3" for class name -->
<!-- Set also "landscape" if you need -->

<body class="A3 landscape">
    <?php
    function selisih($jam_masuk, $jam_keluar)
    {
        [$h, $m, $s] = explode(':', $jam_masuk);
        $dtAwal = mktime($h, $m, $s, '1', '1', '1');
        [$h, $m, $s] = explode(':', $jam_keluar);
        $dtAkhir = mktime($h, $m, $s, '1', '1', '1');
        $dtSelisih = $dtAkhir - $dtAwal;
        $totalmenit = $dtSelisih / 60;
        $jam = explode('.', $totalmenit / 60);
        $sisamenit = $totalmenit / 60 - $jam[0];
        $sisamenit2 = $sisamenit * 60;
        $jml_jam = $jam[0];
        return $jml_jam . ':' . round($sisamenit2);
    }
    ?>
    <!-- Each sheet element should have the class "sheet" -->
    <!-- "padding-**mm" is optional: you can set 10, 15, 20 or 25 -->
    <section class="sheet padding-10mm">

        <!-- Write HTML just like a web page -->

        <table style="width: 100%">
            <tr>
                <td style="text-align: center;">
                    <img src="{{ asset('assets/img/logo-laporan.png') }}" width="80px" height="80px" alt="">
                </td>
                <td style="text-align: center">
                    <span id="title">REKAP PRESENSI KARYAWAN<br>
                        PERIODE {{ strtoupper($namaBulan[$bulan]) }} {{ $tahun }}<br>
                        PT. PIZZAHUT
                    </span><br>
                    <span>Jl. Kemang Utara IX No. 100, Kelurahan Duren Tiga, Kecamatan Pancoran, DKI Jakarta</span>
                </td>
            </tr>
        </table>
        <hr>
        <table class="table-presensi">

            <tr>
                <th rowspan="2">Nik</th>
                <th rowspan="2">Nama Lengkap</th>
                <th colspan="31">Tanggal</th>
                <th rowspan="2">Total Kehadiran</th>
                <th rowspan="2">Total Keterlambatan</th>
            </tr>
            <tr>
                <?php for ($i=1; $i <= 31; $i++) { ?>
                <th>{{ $i }}</th>
                <?php } ?>

            </tr>
            @foreach ($rekap as $item)
                <tr>
                    <td>{{ $item->nik }}</td>
                    <td>{{ $item->nama_lengkap }}</td>
                    <?php
                    $totalhadir = 0;
                    $totaltelat = 0;
                    for ($i=1; $i <= 31; $i++) {
                        $tgl = "tgl_" .$i;
                        if(empty($item->$tgl)){
                            $hadir = ['',''];
                        $totalhadir +=0;

                        }else{
                        $hadir = explode("-",$item->$tgl);
                        $totalhadir +=1;
                        if($hadir[0] > $jam_kantor->jam_masuk){
                            $totaltelat += 1;
                        }

                        }
                        ?>
                    <td>
                        <span
                            style="color: {{ $hadir[0] > $jam_kantor->jam_masuk ? 'red' : '' }}">{{ $hadir[0] }}</span>
                        <span
                            style="color: {{ $hadir[1] < $jam_kantor->jam_keluar ? 'red' : '' }}">{{ $hadir[1] }}</span>
                        <br>
                    </td>
                    <?php } ?>
                    <td>{{ $totalhadir }}</td>
                    <td>{{ $totaltelat }}</td>

                </tr>
            @endforeach

        </table>

        <table width="100%" style="margin-top: 100px">
            <tr>
                <td></td>
                <td colspan="2" style="text-align: center">Jakarta,
                    {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }} <br> </td>
            </tr>
            <tr>
                <td style="text-align:
                    center; vertical-align: bottom;" height="150px">
                    <u>
                        <hr style="width: 200px">
                    </u>
                    <i>HRD</i><br>
                </td>
                <td style="text-align: center;  vertical-align: bottom">
                    <u>
                        <hr style="width: 200px">
                    </u>
                    <i>Direktur</i>
                </td>
            </tr>
        </table>
    </section>

</body>

</html>
