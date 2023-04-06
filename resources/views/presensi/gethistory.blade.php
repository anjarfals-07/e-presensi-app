@if ($history->isEmpty())
    <div class="alert alert-outline-warning">
        <p>No Data</p>
    </div>
@endif
@foreach ($history as $item)
    <ul class="listview image-listview">
        <li>
            <div class="item">
                @php
                    $path = Storage::url('uploads/absensi/' . $item->foto_in);
                @endphp
                <img src="{{ url($path) }}" alt="image" class="image">
                <div class="in">
                    <div><b>{{ \Carbon\Carbon::parse($item->tgl_presensi)->translatedFormat('l, d F Y') }}</b><br>
                        {{-- <b>{{ date('d-m-Y', strtotime($item->tgl_presensi)) }}</b><br> --}}
                        {{-- <small class="text-muted">{{ $item->jabatan }}</small> --}}
                    </div>
                    <span
                        class="badge {{ $item->jam_in < $jam_kantor->jam_masuk ? 'bg-primary' : 'bg-warning' }}">{{ $item->jam_in }}</span>
                    <span class="badge bg-success">{{ $item->jam_out }}</span>
                </div>
            </div>
        </li>
    </ul>
@endforeach
@push('myscript')
    <script>
        window.setTimeout(function() {
            $(".alert").fadeTo(500, 0).slideUp(500, function() {
                $(this).remove();
            });
        }, 3000);
    </script>
@endpush
