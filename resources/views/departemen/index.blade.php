@extends('layout.admin.tabler')
@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <h2 class="page-title">
                        Data Departemen
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card">
                            <div class="card card-body">
                                <div class="col-md-12">
                                    <!-- Jika Sucess  Simpan Data menerima pesan-->
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
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <a href="#" class="btn btn-primary" id="btnTambahDepartemen">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="icon icon-tabler icon-tabler-plus" width="24" height="24"
                                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M12 5l0 14"></path>
                                                <path d="M5 12l14 0"></path>
                                            </svg>
                                            Tambah Data</a>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <form action="/departemen" method="GET">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <input type="text" name="kode_dept" class="form-control"
                                                            id="kode_dept" placeholder="Kode Departemen"
                                                            value="{{ Request('kode_dept') }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <input type="text" name="nama_dept" class="form-control"
                                                            id="nama_dept" placeholder="Nama Departemen"
                                                            value="{{ Request('nama_dept') }}">
                                                    </div>
                                                </div>

                                                <div class="col-md-1">
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
                                                            Cari
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-12 table-responsive">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Kode Departemen</th>
                                                    <th>Nama Departemen</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($departemen as $item)
                                                    <tr>
                                                        <td>{{ $loop->iteration + $departemen->firstItem() - 1 }}</td>
                                                        <td>{{ $item->kode_dept }}</td>
                                                        <td>{{ $item->nama_dept }}</td>
                                                        <td>
                                                            <div class="btn-group">
                                                                <a href="#" class="edit text-warning btn-sm"
                                                                    kode_dept="{{ $item->kode_dept }}">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        class="icon icon-tabler icon-tabler-pencil"
                                                                        width="24" height="24" viewBox="0 0 24 24"
                                                                        stroke-width="2" stroke="currentColor"
                                                                        fill="none" stroke-linecap="round"
                                                                        stroke-linejoin="round">
                                                                        <path stroke="none" d="M0 0h24v24H0z"
                                                                            fill="none">
                                                                        </path>
                                                                        <path
                                                                            d="M4 20h4l10.5 -10.5a1.5 1.5 0 0 0 -4 -4l-10.5 10.5v4">
                                                                        </path>
                                                                        <path d="M13.5 6.5l4 4"></path>
                                                                    </svg>
                                                                </a>
                                                                <form action="/departemen/{{ $item->kode_dept }}/delete"
                                                                    method="POST" style="margin-left:5px">
                                                                    @csrf

                                                                    <a href="#" class="text-danger delete-confirm">
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                            class="icon icon-tabler icon-tabler-trash"
                                                                            width="24" height="24"
                                                                            viewBox="0 0 24 24" stroke-width="2"
                                                                            stroke="currentColor" fill="none"
                                                                            stroke-linecap="round"
                                                                            stroke-linejoin="round">
                                                                            <path stroke="none" d="M0 0h24v24H0z"
                                                                                fill="none"></path>
                                                                            <path d="M4 7l16 0"></path>
                                                                            <path d="M10 11l0 6"></path>
                                                                            <path d="M14 11l0 6"></path>
                                                                            <path
                                                                                d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12">
                                                                            </path>
                                                                            <path
                                                                                d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3">
                                                                            </path>
                                                                        </svg>
                                                                    </a>
                                                                </form>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        {{ $departemen->links('vendor.pagination.bootstrap-5') }}
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Modal Add -->
    <div class="modal modal-blur fade" id="modal-inputdepartemen" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Data Departemen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/departemen/store" method="POST" id="form-departemen">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="input-icon mb-3">
                                    <span class="input-icon-addon">
                                        <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-id"
                                            width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                            stroke="currentColor" fill="none" stroke-linecap="round"
                                            stroke-linejoin="round">
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
                                    <input type="text" name="kode_dept" value="" id="kode_dept"
                                        class="form-control" placeholder="Kode Departemen">
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="input-icon mb-3">
                                    <span class="input-icon-addon">
                                        <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user"
                                            width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                            stroke="currentColor" fill="none" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
                                            <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                                        </svg>
                                    </span>
                                    <input type="text" name="nama_dept" value="" id="nama_dept"
                                        class="form-control" placeholder="Nama Departemen">
                                </div>

                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <button type="button" class="btn me-auto btn-danger" data-bs-dismiss="modal">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-circle-x"
                                        width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"></path>
                                        <path d="M10 10l4 4m0 -4l-4 4"></path>
                                    </svg>
                                    Cancel</button>
                                <button type="submit" class="btn btn-primary" style="float: right;">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="icon icon-tabler icon-tabler-device-floppy" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2">
                                        </path>
                                        <path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                                        <path d="M14 4l0 4l-6 0l0 -4"></path>
                                    </svg>
                                    Save</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <!-- Modal Edit -->
    <div class="modal modal-blur fade" id="modal-edit" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Data Departemen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="loadeditform">

                </div>
            </div>
        </div>
    </div>
@endsection

@push('myscript')
    <script>
        $(function() {
            $("#btnTambahDepartemen").click(function() {
                $("#modal-inputdepartemen").modal("show");
            });
            $(".edit").click(function() {
                var kode_dept = $(this).attr('kode_dept');
                $.ajax({
                    // Mengirimkan data nik ke form edit
                    type: 'POST',
                    url: '/departemen/edit',
                    cache: false,
                    data: {
                        _token: "{{ csrf_token() }}",
                        kode_dept: kode_dept,
                    },
                    success: function(respond) {
                        $('#loadeditform').html(respond);
                    }
                });
                $("#modal-edit").modal("show");
            });

            $(".delete-confirm").click(function(e) {
                var form = $(this).closest('form');
                e.preventDefault();
                Swal.fire({
                    title: 'Apakah Anda Ingin Menghapus Data Ini ..?',
                    text: 'Jika Ya Maka Data Akan Terhapus',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Delete'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                        Swal.fire('Deleted!', 'Data Berhasil Di Hapus', 'success')
                    }
                });
            });

            $("#form-departemen").submit(function() {
                // Membuat variabel dari form
                var kode_dept = $("#form-karyawan").find("#kode_dept").val();;
                var nama_dept = $("#form-karyawan").find("#nama_dept").val();;

                //    Validation
                if (kode_dept == "") {
                    Swal.fire({
                        title: 'Kode Departemen Harus Diisi !',
                        text: status[1],
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        $("#kode_dept").focus();
                    });
                    return false;
                } else if (nama_dept == "") {
                    Swal.fire({
                        title: 'Nama Departemen Harus Diisi !',
                        text: status[1],
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        $("#nama_dept").focus();
                    });
                    return false;
                }
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
