@extends('layout.presensi')
@section('content')
    <style>
        .signout {
            position: absolute;
            color: white;
            font-size: 35px;
            right: 8px;
        }

        .logout::hover {
            color: white;
        }
    </style>
    <div class="section" id="user-section">
        <a href="/proseslogout" class="signout">
            <ion-icon name="log-out-outline"></ion-icon>
        </a>
        <div id="user-detail">
            <div class="avatar">
                @if (!empty(Auth::guard('karyawan')->user()->foto))
                    @php
                        $path = Storage::url('uploads/karyawan/' . Auth::guard('karyawan')->user()->foto);
                    @endphp
                    <img src="{{ url($path) }}" alt="avatar" class="imaged w64" style="height: 70px;">
                @else
                    <img src="assets/img/sample/avatar/avatar1.jpg\" alt="avatar" class="imaged w64 rounded">
                @endif
            </div>
            <div id="user-info">
                <h2 id="user-name">{{ Auth::guard('karyawan')->user()->nama_lengkap }}</h2>
                <span id="user-role">{{ Auth::guard('karyawan')->user()->jabatan }}</span>
            </div>
        </div>
    </div>

    <div class="section" id="menu-section">
        <div class="card">
            <div class="card-body text-center">
                <div class="list-menu">
                    <div class="item-menu text-center">
                        <div class="menu-icon">
                            <a href="/editprofile" class="green" style="font-size: 40px;">
                                <ion-icon name="person-sharp"></ion-icon>
                            </a>
                        </div>
                        <div class="menu-name">
                            <span class="text-center">Profil</span>
                        </div>
                    </div>
                    <div class="item-menu text-center">
                        <div class="menu-icon">
                            <a href="/presensi/izin" class="danger" style="font-size: 40px;">
                                <ion-icon name="calendar-number"></ion-icon>
                            </a>
                        </div>
                        <div class="menu-name">
                            <span class="text-center">Cuti</span>
                        </div>
                    </div>
                    <div class="item-menu text-center">
                        <div class="menu-icon">
                            <a href="/presensi/history" class="warning" style="font-size: 40px;">
                                <ion-icon name="document-text"></ion-icon>
                            </a>
                        </div>
                        <div class="menu-name">
                            <span class="text-center">Histori</span>
                        </div>
                    </div>
                    <div class="item-menu text-center">
                        <div class="menu-icon">
                            <a href="" class="orange" style="font-size: 40px;">
                                <ion-icon name="location"></ion-icon>
                            </a>
                        </div>
                        <div class="menu-name">
                            Lokasi
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="section mt-2" id="presence-section">
        <div class="todaypresence">
            <div class="row">
                <div class="col-6">
                    <div class="card gradasigreen">
                        <div class="card-body">
                            <div class="presencecontent">
                                <div class="iconpresence">
                                    @if ($presensiNow != null)
                                        @php
                                            $path = Storage::url('uploads/absensi/' . $presensiNow->foto_in);
                                        @endphp
                                        <img src="{{ url($path) }}" alt="" class="imaged w64">
                                    @else
                                        <ion-icon name="camera" class="imaged w48"></ion-icon>
                                    @endif
                                </div>
                                <div class="presencedetail">
                                    <h4 class="presencetitle">In</h4>
                                    <span
                                        class="">{{ $presensiNow != null ? $presensiNow->jam_in : 'Belum Absen' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card gradasired">
                        <div class="card-body">
                            <div class="presencecontent">
                                <div class="iconpresence">
                                    @if ($presensiNow != null && $presensiNow->jam_out != null)
                                        @php
                                            $path = Storage::url('uploads/absensi/' . $presensiNow->foto_out);
                                        @endphp
                                        <img src="{{ url($path) }}" alt="" class="imaged w64">
                                    @else
                                        <ion-icon name="camera" class="imaged w48"></ion-icon>
                                    @endif
                                </div>
                                <div class="presencedetail">
                                    <h4 class="presencetitle">Out</h4>
                                    <span>{{ $presensiNow != null && $presensiNow->jam_out != null ? $presensiNow->jam_out : 'Belum Absen' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="rekappresensi">
            <h3>Rekap Absensi Bulan
                {{-- {{ \Carbon\Carbon::parse($namaBulan[$bulan])->translatedFormat('F') }} --}}
                {{-- {{ \Carbon\Carbon::parse($namaBulan[$bulan])->translatedFormat('F') }} --}}
                {{ $namaBulan[$bulan] }}
                Tahun {{ $tahun }}</h3>
            <div class="row">
                <div class="col-3">
                    <div class="card">
                        <div class="card-body text-center" style="padding: 12px 12px !important">
                            <span
                                class="badge bg-danger"style="position: absolute; top:5px; right:8px; font-size: 0.6rem; z-index:999">
                                {{ $rekapPresensi->jmlhadir !== null ? $rekapPresensi->jmlhadir : 0 }}
                            </span>
                            <ion-icon name="accessibility-outline" style="font-size: 1.6rem;" class="text-primary mb-1">
                            </ion-icon>
                            <br>
                            <span style="font-size: 0.8rem; font-weight: 600">Hadir</span>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card">
                        <div class="card-body text-center" style="padding: 12px 12px !important">
                            <span
                                class="badge bg-danger"style="position: absolute; top:5px; right:8px; font-size: 0.6rem; z-index:999">
                                {{ $rekapizin->jmlizin !== null ? $rekapizin->jmlizin : 0 }}
                            </span>
                            <ion-icon name="newspaper-outline" style="font-size: 1.6rem;" class="text-success mb-1">
                            </ion-icon>
                            <br>
                            <span style="font-size: 0.8rem; font-weight: 600">Izin</span>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card">
                        <div class="card-body text-center" style="padding: 12px 12px !important">
                            <span
                                class="badge bg-danger"style="position: absolute; top:5px; right:8px; font-size: 0.6rem; z-index:999">
                                {{ $rekapizin->jmlsakit !== null ? $rekapizin->jmlsakit : 0 }}
                            </span>
                            <ion-icon name="medkit-outline" style="font-size: 1.6rem;" class="text-warning mb-1">
                            </ion-icon>
                            <br>
                            <span style="font-size: 0.8rem; font-weight: 600">Sakit</span>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card">
                        <div class="card-body text-center" style="padding: 12px 12px !important">
                            <span
                                class="badge bg-danger"style="position: absolute; top:5px; right:8px; font-size: 0.6rem; z-index:999">
                                {{ $rekapPresensi->jmltelat !== null ? $rekapPresensi->jmltelat : 0 }}
                            </span>
                            <ion-icon name="megaphone-outline" style="font-size: 1.6rem;" class="text-danger mb-1">
                            </ion-icon>
                            <br>
                            <span style="font-size: 0.8rem; font-weight: 600">Telat</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="presencetab mt-2">
            <div class="tab-pane fade show active" id="pilled" role="tabpanel">
                <ul class="nav nav-tabs style1" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#home" role="tab">
                            Bulan Ini
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#profile" role="tab">
                            Leaderboard
                        </a>
                    </li>
                </ul>
            </div>
            <div class="tab-content mt-2" style="margin-bottom:100px;">
                <div class="tab-pane fade show active" id="home" role="tabpanel">
                    <ul class="listview image-listview">
                        @foreach ($historyPresensi as $item)
                            @php
                                $path = Storage::url('uploads/absensi/' . $item->foto_in);
                            @endphp
                            <li>
                                <div class="item">
                                    <div class="icon-box bg-primary">
                                        <ion-icon name="finger-print-outline"></ion-icon>
                                    </div>
                                    <div class="in">

                                        {{-- <div class="col-md-8">{{ date('d-m-Y', strtotime($item->tgl_presensi)) }}</div> --}}
                                        <div class="col-md-8">
                                            {{ \Carbon\Carbon::parse($item->tgl_presensi)->translatedFormat('l, d F Y') }}
                                        </div>
                                        <div class="col-md-4">
                                            <span class="badge badge-primary">{{ $item->jam_in }}</span>
                                            <span
                                                class="badge badge-danger">{{ $presensiNow != null && $item->jam_out != null ? $item->jam_out : 'Belum Check Out' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach


                    </ul>
                </div>
                <div class="tab-pane fade" id="profile" role="tabpanel">
                    <ul class="listview image-listview">
                        @foreach ($leaderBoard as $item)
                            <li>
                                <div class="item">
                                    <img src="assets/img/sample/avatar/avatar1.jpg" alt="image" class="image">
                                    <div class="in">
                                        <div>
                                            <b>{{ $item->nama_lengkap }}</b><br>
                                            <small class="text-muted">{{ $item->jabatan }}</small>
                                        </div>
                                        <span
                                            class="badge {{ $item->jam_in < $jam_kantor->jam_masuk ? 'bg-primary' : 'bg-danger' }}">{{ $item->jam_in }}</span>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>

            </div>
        </div>
    </div>
@endsection
