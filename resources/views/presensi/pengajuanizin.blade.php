    @extends('layout.presensi')
    @section('header')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">
        <style>
            .datepicker-modal {
                max-height: 430px !important;
            }

            .datepicker-date-display {
                background-color: #1e74fd !important;
            }

            .datepicker-cancel,
            .datepicker-clear,
            .datepicker-today,
            .datepicker-done {
                color: #1e74fd !important;
            }

            .datepicker-table td.is-selected {
                background-color: #1e74fd !important;
                c: #fff !important;
            }

            .datepicker-table td.is-today {
                color: #1e74fd !important
            }

            .datepicker-table td.is-selected {
                background-color: #1e74fd !important;
                color: #fff !important;
            }
        </style>

        <!-- App Header -->

        <div class="appHeader bg-primary text-light">
            <div class="left">
                <a href="javascript:;" class="headerButton goBack">
                    <ion-icon name="chevron-back-outline"></ion-icon>
                </a>
            </div>
            <div class="pageTitle">Form Izin / Sakit</div>
            <div class="right"></div>
        </div>
        <!-- * App Header -->
    @endsection
    @section('content')
        <div class="row" style="margin-top: 70px;">
            <div class="col">
                <form method="POST" action="/presensi/storeizin" id="form-izin">
                    @csrf
                    <div class="form-group boxed">
                        <input type="text" class="form-control datepicker" id="tanggal" name="tanggal"
                            placeholder="Tanggal" autocomplete="off">
                    </div>
                    <div class="form-group boxed">
                        <select name="status" id="status" class="form-control">
                            <option value="">-- Please Select --</option>
                            <option value="i">Izin</option>
                            <option value="s">Sakit</option>
                        </select>
                    </div>
                    <div class="form-group boxed">
                        <textarea name="keterangan" id="keterangan" cols="30" rows="5" class="form-control" placeholder="Keterangan"></textarea>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary w-100">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    @endsection

    @push('myscript')
        <script>
            var currYear = (new Date()).getFullYear();

            $(document).ready(function() {
                $(".datepicker").datepicker({
                    format: "yyyy-mm-dd"
                });
                $("#tanggal").change(function(e) {
                    var tanggal = $(this).val();
                    $.ajax({
                        type: 'POST',
                        url: '/presensi/cekpengajuanizin',
                        data: {
                            _token: "{{ csrf_token() }}",
                            tanggal: tanggal
                        },
                        cache: false,
                        success: function(respond) {
                            if (respond == 1) {
                                Swal.fire({
                                    title: 'Oops!',
                                    text: 'Anda Sudah Pernah Melakukan Pengajuan Izin Pada Tanggal Tersebut, Silahkan Masukkan Tanggal Lain .. !',
                                    icon: 'warning',
                                    confirmButtonText: 'OK'
                                }).then((result) => {
                                    $("#tanggal").val("")
                                });
                            }
                        }
                    });
                });
                $("#form-izin").submit(function() {
                    var tgl_izin = $("#tanggal").val();
                    var status = $("#status").val();
                    var keterangan = $("#keterangan").val();
                    if (tanggal == "") {
                        Swal.fire({
                            title: 'Oops!',
                            text: 'Tanggal Harus Diisi',
                            icon: 'warning',
                            confirmButtonText: 'OK'
                        });
                        return false;
                    } else if (status == "") {
                        Swal.fire({
                            title: 'Oops!',
                            text: 'Status Belum Dipilih',
                            icon: 'warning',
                            confirmButtonText: 'OK'
                        });
                        return false;
                    } else if (keterangan == "") {
                        Swal.fire({
                            title: 'Oops!',
                            text: 'Keterangan Harus Diisi',
                            icon: 'warning',
                            confirmButtonText: 'OK'
                        });
                        return false;
                    }
                })
            });
        </script>
    @endpush
