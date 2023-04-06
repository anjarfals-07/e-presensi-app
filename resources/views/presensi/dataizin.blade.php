@extends('layout.admin.tabler')
@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <h2 class="page-title">
                        Data Izin / Sakit
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="card card-body">
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
                    <div class="row">
                        <div class="col-md-12">
                            <form action="/presensi/dataizin" method="GET">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-icon mb-3">
                                            <span class="input-icon-addon">
                                                <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="icon icon-tabler icon-tabler-calendar-event" width="24"
                                                    height="24" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path
                                                        d="M4 5m0 2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2z">
                                                    </path>
                                                    <path d="M16 3l0 4"></path>
                                                    <path d="M8 3l0 4"></path>
                                                    <path d="M4 11l16 0"></path>
                                                    <path d="M8 15h2v2h-2z"></path>
                                                </svg>
                                            </span>
                                            <input type="text" name="tglmulai" value="{{ Request('tglmulai') }}"
                                                id="tglmulai" class="form-control" placeholder="Mulai" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-icon mb-3">
                                            <span class="input-icon-addon">
                                                <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="icon icon-tabler icon-tabler-calendar-event" width="24"
                                                    height="24" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path
                                                        d="M4 5m0 2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2z">
                                                    </path>
                                                    <path d="M16 3l0 4"></path>
                                                    <path d="M8 3l0 4"></path>
                                                    <path d="M4 11l16 0"></path>
                                                    <path d="M8 15h2v2h-2z"></path>
                                                </svg>
                                            </span>
                                            <input type="text" name="tglsampai" value="{{ Request('tglsampai') }}"
                                                id="tglsampai" class="form-control" placeholder="Sampai Dengan"
                                                autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="input-icon mb-3">
                                            <span class="input-icon-addon">
                                                <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="icon icon-tabler icon-tabler-id" width="24" height="24"
                                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path
                                                        d="M3 4m0 3a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v10a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3z">
                                                    </path>
                                                    <path d="M9 10m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                                                    <path d="M15 8l2 0"></path>
                                                    <path d="M15 12l2 0"></path>
                                                    <path d="M7 16l10 0"></path>
                                                </svg>
                                            </span>
                                            <input type="text" name="nik" value="{{ Request('nik') }}" id="nik"
                                                class="form-control" placeholder="Nik" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="input-icon mb-3">
                                            <span class="input-icon-addon">
                                                <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="icon icon-tabler icon-tabler-user" width="24"
                                                    height="24" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
                                                    <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                                                </svg>
                                            </span>
                                            <input type="text" name="nama_lengkap"
                                                value="{{ Request('nama_lengkap') }}" id="nama_lengkap"
                                                class="form-control" placeholder="Nama Karyawan" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <select name="status_approved" id="status_approved" class="form-select">
                                                <option value="">-- Pilih Status --</option>
                                                <option value="0"
                                                    {{ Request('status_approved') === '0' ? 'selected' : '' }}>Pending
                                                </option>
                                                <option value="1"
                                                    {{ Request('status_approved') == 1 ? 'selected' : '' }}>Approved
                                                </option>
                                                <option
                                                    value="2"{{ Request('status_approved') == 2 ? 'selected' : '' }}>
                                                    Not Approved</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="icon icon-tabler icon-tabler-search" width="24"
                                                    height="24" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none">
                                                    </path>
                                                    <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                                                    <path d="M21 21l-6 -6"></path>
                                                </svg>
                                                Cari Data
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Nik</th>
                                        <th>Nama Karyawan</th>
                                        <th>Jabatan</th>
                                        <th>Status</th>
                                        <th>Keterangan</th>
                                        <th>Status Approved</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($izinsakit as $item)
                                        <tr>
                                            <td>{{ $loop->iteration + $izinsakit->firstItem() - 1 }}</td>
                                            <td>{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('l, d F Y') }}
                                            </td>
                                            <td>{{ $item->nik }}</td>
                                            <td>{{ $item->nama_lengkap }}</td>
                                            <td>{{ $item->jabatan }}</td>
                                            <td>{{ $item->status == 'i' ? 'Izin' : 'Sakit' }}</td>
                                            <td>{{ $item->keterangan }}</td>
                                            <td>
                                                @if ($item->status_approved == 1)
                                                    <span class="badge bg-success">Approved</span>
                                                @elseif ($item->status_approved == 2)
                                                    <span class="badge bg-danger">Not Approved</span>
                                                @else
                                                    <span class="badge bg-warning">Pending</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($item->status_approved == 0)
                                                    <a href="" class="btn btn-sm btn-primary" id="approve"
                                                        id_izin="{{ $item->id }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            class="icon icon-tabler icon-tabler-checklist" width="24"
                                                            height="24" viewBox="0 0 24 24" stroke-width="2"
                                                            stroke="currentColor" fill="none" stroke-linecap="round"
                                                            stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                            <path
                                                                d="M9.615 20h-2.615a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v8">
                                                            </path>
                                                            <path d="M14 19l2 2l4 -4"></path>
                                                            <path d="M9 8h4"></path>
                                                            <path d="M9 12h2"></path>
                                                        </svg>
                                                        Change Status
                                                    </a>
                                                @else
                                                    <a href="/presensi/{{ $item->id }}/rejected"
                                                        class="btn btn-sm btn-danger">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            class="icon icon-tabler icon-tabler-ban" width="24"
                                                            height="24" viewBox="0 0 24 24" stroke-width="2"
                                                            stroke="currentColor" fill="none" stroke-linecap="round"
                                                            stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                            <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"></path>
                                                            <path d="M5.7 5.7l12.6 12.6"></path>
                                                        </svg>
                                                        Reject
                                                    </a>
                                                @endif


                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $izinsakit->links('vendor.pagination.bootstrap-5') }}

                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal -->
        <div class="modal modal-blur fade" id="modal-izinsakit" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Izin/Sakit</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="/presensi/approveizin" method="POST">
                            @csrf
                            <input type="text" id="id_izin_form" name="id_izin_form" hidden>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <select name="status_approved" id="status_approved" class="form-select">
                                            <option value="1">Approved</option>
                                            <option value="2">Not Approved</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <button class="btn btn-primary w-100" type="submit">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="icon icon-tabler icon-tabler-send" width="24" height="24"
                                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M10 14l11 -11"></path>
                                                <path
                                                    d="M21 3l-6.5 18a.55 .55 0 0 1 -1 0l-3.5 -7l-7 -3.5a.55 .55 0 0 1 0 -1l18 -6.5">
                                                </path>
                                            </svg>
                                            Submit
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @push('myscript')
        <script>
            $(function() {
                $("#approve").click(function(e) {
                    e.preventDefault();
                    var id_izin = $(this).attr("id_izin");
                    // id value attribut disimpan pada form pada id izin form
                    $("#id_izin_form").val(id_izin);
                    $("#modal-izinsakit").modal("show")
                });
                $("#tglmulai, #tglsampai").datepicker({
                    autoclose: true,
                    todayHighlight: true,
                    format: 'yyyy-mm-dd'
                });
            });
        </script>
        <script>
            window.setTimeout(function() {
                $(".alert").fadeTo(500, 0).slideUp(500, function() {
                    $(this).remove();
                });
            }, 3000);
        </script>
    @endpush
