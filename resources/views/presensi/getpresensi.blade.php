    @php
        // Function Untuk Menghitung Selisih Jam
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
    @endphp
    @foreach ($presensi as $item)
        @php
            $foto_in = Storage::url('uploads/absensi/' . $item->foto_in);
            $foto_out = Storage::url('uploads/absensi/' . $item->foto_out);
        @endphp
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->nik }}</td>
            <td>{{ $item->nama_lengkap }}</td>
            <td>{{ $item->nama_dept }}</td>
            <td>{{ $item->jabatan }}</td>
            <td>{!! $item->jam_in != null ? $item->jam_in : '<span class="badge bg-warning">Belum Check In</span>' !!}</td>
            <td>
                @if ($item->jam_in != null)
                    <img src="{{ url($foto_in) }}" class="avatar" alt="">
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-camera-minus"
                        width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path
                            d="M12 20h-7a2 2 0 0 1 -2 -2v-9a2 2 0 0 1 2 -2h1a2 2 0 0 0 2 -2a1 1 0 0 1 1 -1h6a1 1 0 0 1 1 1a2 2 0 0 0 2 2h1a2 2 0 0 1 2 2v6">
                        </path>
                        <path d="M16 19h6"></path>
                        <path d="M9 13a3 3 0 1 0 6 0a3 3 0 0 0 -6 0"></path>
                    </svg>
                @endif
            </td>
            <td>{!! $item->jam_out != null ? $item->jam_out : '<span class="badge bg-danger">Belum Check Out</span>' !!}</td>
            <td>
                @if ($item->jam_out != null)
                    <img src="{{ url($foto_out) }}" class="avatar" alt="">
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-camera-minus"
                        width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path
                            d="M12 20h-7a2 2 0 0 1 -2 -2v-9a2 2 0 0 1 2 -2h1a2 2 0 0 0 2 -2a1 1 0 0 1 1 -1h6a1 1 0 0 1 1 1a2 2 0 0 0 2 2h1a2 2 0 0 1 2 2v6">
                        </path>
                        <path d="M16 19h6"></path>
                        <path d="M9 13a3 3 0 1 0 6 0a3 3 0 0 0 -6 0"></path>
                    </svg>
                @endif
            </td>
            <td>
                @if ($item->jam_in >= $jam_kantor->jam_masuk)
                    @php
                        $jam_telat = selisih($jam_kantor->jam_masuk, $item->jam_in);
                    @endphp
                    <span class="badge bg-danger">Terlambat {{ $jam_telat }}</span>
                @else
                    <span class="badge bg-primary">Tidak Terlambat</span>
                @endif
            </td>
            <td>
                <a href="#" class="btn btn-primary tampilkanpeta" id="{{ $item->id }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-map-2" width="24"
                        height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M12 18.5l-3 -1.5l-6 3v-13l6 -3l6 3l6 -3v7.5"></path>
                        <path d="M9 4v13"></path>
                        <path d="M15 7v5.5"></path>
                        <path
                            d="M21.121 20.121a3 3 0 1 0 -4.242 0c.418 .419 1.125 1.045 2.121 1.879c1.051 -.89 1.759 -1.516 2.121 -1.879z">
                        </path>
                        <path d="M19 18v.01"></path>
                    </svg>
                </a>
            </td>

        </tr>
    @endforeach

    <script>
        $(function() {
            $(".tampilkanpeta").click(function(e) {
                var id = $(this).attr("id");
                $.ajax({
                    type: 'POST',
                    url: '/getmaps',
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: id
                    },
                    cache: false,
                    success: function(respond) {
                        $("#loadmaps").html(respond);
                    }
                });
                $("#modal-maps").modal("show");
            });
        });
    </script>
