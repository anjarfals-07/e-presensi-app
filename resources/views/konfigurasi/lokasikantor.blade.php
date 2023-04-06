@extends('layout.admin.tabler')
@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <h2 class="page-title">
                    Konfigurasi Lokasi Kantor
                </h2>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            @if (Session::get('success'))
                                <div class="alert alert-success" role="alert">
                                    {{ Session::get('success') }}
                                </div>
                            @endif
                            <!-- Jika Gagal Simpan Data menerima pesan-->

                            @if (Session::get('error'))
                                <div class="alert alert-error" role="alert">
                                    {{ Session::get('error') }}
                                </div>
                            @endif
                            <form action="/konfigurasi/updatelokasikantor" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="input-icon mb-3">
                                            <span class="input-icon-addon">
                                                <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="icon icon-tabler icon-tabler-map-2" width="24" height="24"
                                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M12 18.5l-3 -1.5l-6 3v-13l6 -3l6 3l6 -3v7.5"></path>
                                                    <path d="M9 4v13"></path>
                                                    <path d="M15 7v5.5"></path>
                                                    <path
                                                        d="M21.121 20.121a3 3 0 1 0 -4.242 0c.418 .419 1.125 1.045 2.121 1.879c1.051 -.89 1.759 -1.516 2.121 -1.879z">
                                                    </path>
                                                    <path d="M19 18v.01"></path>
                                                </svg>
                                            </span>
                                            <input type="text" name="lokasi_kantor" value="{{ $lokasi->lokasi_kantor }}"
                                                id="lokasi_kantor" class="form-control" placeholder="Lokasi Kantor">
                                        </div>

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="input-icon mb-3">
                                            <span class="input-icon-addon">
                                                <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="icon icon-tabler icon-tabler-radar" width="24" height="24"
                                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M21 12h-8a1 1 0 1 0 -1 1v8a9 9 0 0 0 9 -9"></path>
                                                    <path d="M16 9a5 5 0 1 0 -7 7"></path>
                                                    <path d="M20.486 9a9 9 0 1 0 -11.482 11.495"></path>
                                                </svg>
                                            </span>
                                            <input type="text" name="radius" value="{{ $lokasi->radius }}"
                                                id="radius" class="form-control" placeholder="Radius">
                                        </div>

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <button class="btn btn-primary w-100">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="icon icon-tabler icon-tabler-refresh" width="24" height="24"
                                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -4v4h4"></path>
                                                <path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 4v-4h-4"></path>
                                            </svg>
                                            Update
                                        </button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <style>
                                #map {
                                    height: 400px;
                                }
                            </style>
                            <div id="map"></div>
                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <div class="input-icon mb-3">
                                        <span class="input-icon-addon">
                                            <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="icon icon-tabler icon-tabler-map-2" width="24" height="24"
                                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M12 18.5l-3 -1.5l-6 3v-13l6 -3l6 3l6 -3v7.5"></path>
                                                <path d="M9 4v13"></path>
                                                <path d="M15 7v5.5"></path>
                                                <path
                                                    d="M21.121 20.121a3 3 0 1 0 -4.242 0c.418 .419 1.125 1.045 2.121 1.879c1.051 -.89 1.759 -1.516 2.121 -1.879z">
                                                </path>
                                                <path d="M19 18v.01"></path>
                                            </svg>
                                        </span>
                                        <input type="text" id="lat" name="lat" class="form-control"
                                            placeholder="Lokasi Kantor">
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('myscript')
    <script>
        var lokasi = "{{ $lokasi->lokasi_kantor }}";
        var lokasi_user = lokasi.split(",");
        var latitude = lokasi_user[0];
        var longitude = lokasi_user[1];
        var map = L.map('map').setView([latitude, longitude], 17);
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);
        var marker = L.marker([latitude, longitude]).addTo(map);
        var circle = L.circle([-6.254017, 106.825138], {
            // -6.254017, 106.825138
            color: '#00b3ff',
            fillColor: '#00b3ff',
            fillOpacity: 0.5,
            radius: 50
        }).addTo(map);
        // var popup = L.popup()
        //     .setLatLng([latitude, longitude])
        //     .setContent("")
        //     .openOn(map);
        var popup = L.popup();

        function onMapClick(e) {
            popup
                .setLatLng(e.latlng)
                .setContent("You clicked the map at " + e.latlng.toString())
                .openOn(map);
            string_value = e.latlng.toString().replace("LatLng(", "").replace(")", "");
            var split_string = string_value.split(", ");

            // Step 3: Convert string values to float
            var latitudesplit = parseFloat(split_string[0]);
            var longitudesplit = parseFloat(split_string[1]);

            document.getElementById('lat').value = latitudesplit + "," + longitudesplit
                .toString();
        }

        map.on('click', onMapClick);
    </script>
    <script>
        window.setTimeout(function() {
            $(".alert").fadeTo(500, 0).slideUp(500, function() {
                $(this).remove();
            });
        }, 3000);
    </script>
@endpush
