@extends('layout.presensi')
@section('header')
    <!-- App Header -->

    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">E-Presensi</div>
        <div class="right"></div>
    </div>
    <!-- * App Header -->
    <style>
        .webcam-capture,
        .webcam-capture video {
            display: inline-block;
            width: 100% !important;
            margin: auto;
            height: auto !important;
            border-radius: 15px;
        }

        #map {
            height: 200px;
        }
    </style>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
@endsection
@section('content')
    <div class="row" style="margin-top: 70px">
        <div class="col">
            <input type="text" id="lokasi" hidden>
            <div class="webcam-capture">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            @if ($cek > 0)
                <button id="takeabsen" class="btn btn-danger btn-block">
                    <ion-icon name="camera-outline"></ion-icon>
                    Check Out
                </button>
            @else
                <button id="takeabsen" class="btn btn-primary btn-block">
                    <ion-icon name="camera-outline"></ion-icon>
                    Check In
                </button>
            @endif

        </div>
    </div>
    <div class="row mt-2">
        <div class="col">
            <div id="map"></div>
        </div>
    </div>
    <audio id="notif_in">
        <source src="{{ asset('assets/audio/notif_in.mp3') }}" type="audio/mpeg">
    </audio>
    <audio id="notif_out">
        <source src="{{ asset('assets/audio/notif_out.mp3') }}" type="audio/mpeg">
    </audio>
    <audio id="radius">
        <source src="{{ asset('assets/audio/radius.mp3') }}" type="audio/mpeg">
    </audio>
@endsection

@push('myscript')
    <script>
        // Audio
        var notif_in = document.getElementById('notif_in');
        var notif_out = document.getElementById('notif_out');
        var radius = document.getElementById('radius');
        // Webcam
        Webcam.set({
            height: 480,
            width: 640,
            image_format: 'jpeg',
            jpeg_quality: 80
        });

        Webcam.attach('.webcam-capture');

        var lokasi = document.getElementById('lokasi');
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(successCallback, errorCallback);
        }

        function successCallback(position) {
            lokasi.value = position.coords.latitude + "," + position.coords.longitude;
            var map = L.map('map').setView([position.coords.latitude, position.coords.longitude], 17);
            var lokasi_kantor = "{{ $lok_kantor->lokasi_kantor }}";
            var lok_split = lokasi_kantor.split(",");
            var latitude_kantor = lok_split[0];
            var longitude_kantor = lok_split[1];
            var radius_kantor = "{{ $lok_kantor->radius }}";
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 20,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);
            var marker = L.marker([position.coords.latitude, position.coords.longitude]).addTo(map);
            // var circle = L.circle([-6.220828, 106.814878], {
            var circle = L.circle([latitude_kantor, longitude_kantor], {
                // -6.254017, 106.825138

                color: '#00b3ff',
                fillColor: '#00b3ff',
                fillOpacity: 0.5,
                radius: radius_kantor
            }).addTo(map);
        }

        function errorCallback(position) {
            // lokasi.value = position.coords.latitude;
        }

        $("#takeabsen").click(function(e) {
            Webcam.snap(function(uri) {
                image = uri;
            });
            var lokasi = $("#lokasi").val();
            $.ajax({
                type: 'POST',
                url: '/presensi/store',
                data: {
                    _token: "{{ csrf_token() }}",
                    image: image,
                    lokasi: lokasi
                },
                cache: false,
                success: function(respond) {
                    var status = respond.split("|");
                    if (status[0] == 'success') {
                        // Notifikasi Audio
                        if (status[2] == 'in') {
                            notif_in.play();
                        } else {
                            notif_out.play();
                        }

                        Swal.fire({
                            title: 'Berhasil!',
                            text: status[1],
                            icon: 'success',
                            confirmButtonText: 'OK'
                        })
                        setTimeout("location.href='/dashboard'", 3000)
                    } else {
                        if (status[2] == 'radius') {
                            radius.play();
                        }
                        Swal.fire({
                            title: 'Error!',
                            text: status[1],
                            icon: 'error',
                            confirmButtonText: 'OK'
                        })
                    }
                }
            });
        });
    </script>
@endpush
