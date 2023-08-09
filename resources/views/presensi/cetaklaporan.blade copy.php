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
            size: A4
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
            page-break-after: always !important;

            page-break-inside: avoid;
            page-break-before: always;
        }

        .table-presensi tr th {
            background-color: #9d9e9e;
            border: 1px solid #000;
            padding: 8px;
            color: #000;
            font-size: 12px;
        }

        .table-presensi tr td {
            border: 1px solid #000;
            color: #000;
            font-size: 12px
        }

        .foto {
            width: 40px;
            height: 40px;
        }
    </style>
</head>

<!-- Set "A5", "A4" or "A3" for class name -->
<!-- Set also "landscape" if you need -->

<body class="A4">
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
                    <span id="title">LAPORAN PRESENSI KARYAWAN<br>
                        PERIODE {{ strtoupper($namaBulan[$bulan]) }} {{ $tahun }}<br>
                        PT. PIZZAHUT
                    </span><br>
                    <span>Jl. Kemang Utara IX No. 100, Kelurahan Duren Tiga, Kecamatan Pancoran, DKI Jakarta</span>
                </td>
            </tr>
        </table>
        <hr>
        <table class="tablekaryawan">
            <tr>
                <td rowspan="6">
                    @php
                    $path = Storage::url('uploads/karyawan/' . $karyawan->foto);
                    @endphp
                    <img src="{{ url($path) }}" alt="" width="120px" height="150px">
                </td>
            </tr>
            <tr>
                <td>NIK</td>
                <td>:</td>
                <td>{{ $karyawan->nik }}</td>
            </tr>
            <tr>
                <td>Nama Lengkap</td>
                <td>:</td>
                <td>{{ $karyawan->nama_lengkap }}</td>
            </tr>
            <tr>
                <td>Jabatan</td>
                <td>:</td>
                <td>{{ $karyawan->jabatan }}</td>
            </tr>
            <tr>
                <td>Departemen</td>
                <td>:</td>
                <td>{{ $karyawan->nama_dept }}</td>
            </tr>
            <tr>
                <td>No.HP / Telepon</td>
                <td>:</td>
                <td>{{ $karyawan->no_hp }}</td>
            </tr>
        </table>
        <table class="table-presensi">
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Check In</th>
                <th>Foto</th>
                <th>Check Out</th>
                <th>Foto</th>
                <th>Keterangan</th>
                <th>Total Jam Kerja</th>
            </tr>
            @foreach ($presensi as $item)
            @php
            $path_in = Storage::url('uploads/absensi/' . $item->foto_in);
            $path_out = Storage::url('uploads/absensi/' . $item->foto_out);
            $jam_telat = selisih($jam_kantor->jam_masuk, $item->jam_in);
            @endphp
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ date('d-m-Y', strtotime($item->tgl_presensi)) }}</td>
                <td>{{ $item->jam_in }}</td>
                <td style="text-align: center"><img src="{{ url($path_in) }}" alt="" class="foto">
                </td>
                <td>{{ $item->jam_out != null ? $item->jam_out : 'Belum Absen' }}</td>
                <td style="text-align: center">
                    @if ($item != null)
                    <img src="{{ url($path_out) }}" alt="" class="foto">
                    @else
                    <img src="{{ asset('assets/img/no-photo.jpg') }}" alt="" class="foto">
                    @endif
                </td>
                <td>
                    @if ($item->jam_in > $jam_kantor->jam_masuk)
                    Terlambat {{ $jam_telat }}
                    @else
                    Tidak Terlambat
                    @endif
                </td>
                <td>
                    @if ($item->jam_out != null)
                    @php
                    $jml_jamkerja = selisih($item->jam_in, $item->jam_out);

                    @endphp
                    @else
                    @php
                    $jml_jamkerja = 0;

                    @endphp
                    @endif
                    {{ $jml_jamkerja }} Jam
                </td>
            </tr>
            @endforeach
        </table>

        <table width="100%" style="margin-top: 100px">
            <tr>
                <td></td>
                <td colspan="2" style="text-align: center;">Jakarta,
                    {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }} <br>
                </td>
            </tr>
            <tr>
                <td style="text-align: center; vertical-align: bottom;" height="150px">
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
    </section>

</body>

</html>