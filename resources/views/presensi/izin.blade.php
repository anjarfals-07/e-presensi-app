@extends('layout.presensi')
@section('header')
    <!-- App Header -->

    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Data Izin / Sakit</div>
        <div class="right"></div>
    </div>
    <!-- * App Header -->
@endsection
@section('content')
    <div class="row" style="margin-top: 70px">
        <div class="col">
            @php
                $messageSuccess = Session::get('success');
                $messageError = Session::get('error');
            @endphp
            @if (Session::get('success'))
                <div class="alert alert-success">
                    {{ $messageSuccess }}
                </div>
            @endif
            @if (Session::get('error'))
                <div class="alert alert-danger">
                    {{ $messageError }}
                </div>
            @endif
        </div>
    </div>
    <div class="row">
        @if ($dataizin->isEmpty())
            <div class="alert alert-outline-warning">
                <p>No Data</p>
            </div>
        @endif
        <div class="col">
            @foreach ($dataizin as $item)
                <ul class="listview image-listview">
                    <li>
                        <div class="item">
                            <div class="in">
                                <div>

                                    <b>{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('l, d F Y') }}
                                        -
                                        {{ $item->status == 's' ? 'Sakit' : 'Izin' }}<br></b>
                                    <small class="text-muted"><b>{{ $item->keterangan }}</b></small>
                                </div>
                                @if ($item->status_approved == 0)
                                    <span class="badge bg-warning">Pending</span>
                                @elseif ($item->status_approved == 1)
                                    <span class="badge bg-success">Approved</span>
                                @elseif($item->status_approved == 2)
                                    <span class="badge bg-danger">Not Approved</span>
                                @endif
                            </div>
                        </div>
                    </li>
                </ul>
            @endforeach
        </div>
    </div>
    <div class="fab-button bottom-right" style="margin-bottom: 70px">
        <a href="/presensi/pengajuanizin" class="fab">
            <ion-icon name="add-outline"></ion-icon>
        </a>
    </div>
@endsection
