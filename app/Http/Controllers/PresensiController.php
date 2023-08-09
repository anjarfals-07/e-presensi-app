<?php

namespace App\Http\Controllers;

use App\Models\PengajuanIzin;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use PDF;

class PresensiController extends Controller
{
    public function create()
    {
        $tglSekarang = date("Y-m-d");
        $nik = Auth::guard('karyawan')->user()->nik;
        $cek = DB::table('presensi')->where('tgl_presensi', $tglSekarang)->where('nik', $nik)->count();
        $lok_kantor = DB::table('konfigurasi_lokasi')->where('id', 1)->first();
        return view('presensi.create', compact('cek', 'lok_kantor'));
    }

    public function store(Request $request)
    {
        // date_default_timezone_set('Asia/Jakarta');
        $nik = Auth::guard('karyawan')->user()->nik;
        $tgl_presensi = date("Y-m-d");
        $jam = date("H:i:s");

        $lok_kantor = DB::table('konfigurasi_lokasi')->where('id', 1)->first();
        $lok_explode = explode(",", $lok_kantor->lokasi_kantor);

        $latitudeKantor = $lok_explode[0];
        $longitudeKantor = $lok_explode[1];



        $lokasi = $request->lokasi;
        // Menjadikan lat dan long menjadi array
        $lokasiUser = explode(",", $lokasi);
        $latitudeUser = $lokasiUser[0];
        $longitudeUser = $lokasiUser[1];
        $jarak = $this->distance($latitudeKantor, $longitudeKantor, $latitudeUser, $longitudeUser);
        $radius = round($jarak["meters"]);
        // dd($radius);
        // Cek Sudah Absen Belum
        $cek = DB::table('presensi')->where('tgl_presensi', $tgl_presensi)->where('nik', $nik)->count();

        if ($cek > 0) {
            $ket = "out";
        } else {
            $ket = "in";
        }
        $image = $request->image;
        // Menyimpan Gambar Ke Folder
        $folderPath = "public/uploads/absensi/";
        $nameFile = $nik . "-" . $tgl_presensi . "-" . $ket;
        $image_parts = explode(";base64", $image);
        $image_base64 = base64_decode($image_parts[1]);
        $fileName = $nameFile . ".png";
        $file = $folderPath . $fileName;


        // Validasi Radius
        if ($radius > $lok_kantor->radius) {
            echo "error|Maaf Anda Berada Diluar Radius, Jarak Anda " . $radius . " Meter Dari Kantor|radius";
        } else {
            // Jika Sudah Absen Maka Di Update
            if ($cek > 0) {
                $dataOut = [
                    'jam_out'        => $jam,
                    'foto_out'       => $fileName,
                    'location_out'   => $lokasi
                ];
                $update = DB::table('presensi')->where('tgl_presensi', $tgl_presensi)->where('nik', $nik)->update($dataOut);
                // Jika Update Berhasil dilakukan eksekusi penyimpanan gambar
                if ($update) {
                    echo "success|Terimakasih, Hati-Hati Di Jalan |out";
                    Storage::put($file, $image_base64);
                    // Jika Error dilakukan pengembalian nilai 1
                } else {
                    echo "error|Maaf Gagal Absen, Hubungi Admin / Team Develop|out";
                }
            } else {
                // Jika Belum Dilakukan Insert
                $data = [
                    'nik'           => $nik,
                    'tgl_presensi'  => $tgl_presensi,
                    'jam_in'        => $jam,
                    'foto_in'       => $fileName,
                    'location_in'   => $lokasi
                ];
                $simpan = DB::table('presensi')->insert($data);
                if ($simpan) {
                    echo "success|Terimakasih, Selamat Bekerja |in";
                    Storage::put($file, $image_base64);
                } else {
                    echo "error|Maaf Gagal Absen, Hubungi Admin / Team Develop|in";
                }
            }
        }
    }

    //Menghitung Jarak
    function distance($lat1, $lon1, $lat2, $lon2)
    {
        $theta = $lon1 - $lon2;
        $miles = (sin(deg2rad($lat1)) * sin(deg2rad($lat2))) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
        $miles = acos($miles);
        $miles = rad2deg($miles);
        $miles = $miles * 60 * 1.1515;
        $feet = $miles * 5280;
        $yards = $feet / 3;
        $kilometers = $miles * 1.609344;
        $meters = $kilometers * 1000;
        return compact('meters');
    }

    public function editprofile()
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $karyawan = DB::table('karyawan')->where('nik', $nik)->first();
        return view('presensi.editprofile', compact('karyawan'));
    }

    public function updateprofile(Request $request)
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $nama_lengkap = $request->nama_lengkap;
        $no_hp = $request->no_hp;
        $password = Hash::make($request->password);
        $karyawan = DB::table('karyawan')->where('nik', $nik)->first();
        if ($request->hasFile('foto')) {
            $foto = $nik . "." . $request->file('foto')->getClientOriginalExtension();
        } else {
            $foto = $karyawan->foto;
        }

        if (empty($request->password)) {
            $data = [
                'name'  => $name,
                'email'  => $email
            ];
        } else {
            $data = [
                'nama_lengkap'  => $nama_lengkap,
                'no_hp'  => $no_hp,
                'password'  => $password,
                'foto'  => $foto
            ];
        }

        $update =   DB::table('karyawan')->where('nik', $nik)->update($data);
        if ($update) {
            if ($request->hasFile('foto')) {
                $folderPath = "public/uploads/karyawan/";
                $request->file('foto')->storeAs($folderPath, $foto);
            }
            return Redirect::back()->with(['success' => 'Data Berhasil Di Update']);
        } else {
            return Redirect::back()->with(['error' => 'Data Gagal Di Update']);
        }
    }

    public function history()
    {
        $namaBulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

        return view('presensi.history', compact('namaBulan'));
    }

    public function gethistory(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $nik = Auth::guard('karyawan')->user()->nik;
        $jam_kantor = DB::table('konfigurasi_jam')->where('id', 1)->first();

        $history = DB::table('presensi')
            ->whereRaw('MONTH(tgl_presensi)="' . $bulan . '"')
            ->whereRaw('YEAR(tgl_presensi)="' . $tahun . '"')
            ->where('nik', $nik)
            ->orderBy('tgl_presensi')
            ->get();

        return view('presensi.gethistory', compact('history', 'jam_kantor'));
    }

    public function izin()
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $dataizin = DB::table('pengajuan_izin')->where('nik', $nik)->get();
        return view('presensi.izin', compact('dataizin'));
    }

    public function pengajuanizin()
    {
        return view('presensi.pengajuanizin');
    }

    public function storeizin(Request $request)
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $tanggal_izin = $request->tanggal;
        $status = $request->status;
        $keterangan = $request->keterangan;

        $data = [
            'nik'   => $nik,
            'tanggal'   => $tanggal_izin,
            'status'   => $status,
            'keterangan'   => $keterangan
        ];

        $simpan = DB::table('pengajuan_izin')->insert($data);
        if ($simpan) {
            return redirect('/presensi/izin')->with(['success' => 'Data Berhasil Di Simpan']);
        } else {
            return redirect('/presensi/izin')->with(['error' => 'Data Gagal Di Simpan']);
        }
    }

    public function cekpengajuanizin(Request $request)
    {
        $tanggal = $request->tanggal;
        $nik = Auth::guard('karyawan')->user()->nik;
        $cek = DB::table('pengajuan_izin')->where('nik', $nik)->where('tanggal', $tanggal)->count();
        return $cek;
    }


    // Web Admin Monitoring
    public function monitoring()
    {
        return view('presensi.monitoring');
    }

    public function getpresensi(Request $request)
    {
        $tanggal = $request->tanggal;
        $presensi = DB::table('presensi')
            ->select('presensi.*', 'nama_lengkap', 'nama_dept', 'jabatan')
            ->join('karyawan', 'presensi.nik', '=', 'karyawan.nik')
            ->join('departemen', 'karyawan.kode_dept', '=', 'departemen.kode_dept')
            ->where('tgl_presensi', $tanggal)
            ->get();
        $jam_kantor = DB::table('konfigurasi_jam')->where('id', 1)->first();

        return view('presensi.getpresensi', compact('presensi', 'jam_kantor'));
    }

    // GetMaps
    public function getmaps(Request $request)
    {
        $id = $request->id;
        $presensi = DB::table('presensi')->where('id', $id)
            ->join('karyawan', 'presensi.nik', '=', 'karyawan.nik')
            ->first();
        return view('presensi.showmaps', compact('presensi'));
    }


    // Laporan
    public function laporan()
    {
        $namaBulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        $karyawan = DB::table('karyawan')->orderBy('nama_lengkap')->get();
        return view('presensi.laporan', compact('namaBulan', 'karyawan'));
    }

    public function cetaklaporan(Request $request)
    {
        $nik = $request->nik;
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $jam_kantor = DB::table('konfigurasi_jam')->where('id', 1)->first();

        $namaBulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        $karyawan = DB::table('karyawan')->where('nik', $nik)
            ->join('departemen', 'karyawan.kode_dept', '=', 'departemen.kode_dept')
            ->first();
        $presensi = DB::table('presensi')
            ->where('nik', $nik)
            ->whereRaw('MONTH(tgl_presensi)="' . $bulan . '"')
            ->whereRaw('YEAR(tgl_presensi)="' . $tahun . '"')
            ->orderBy('tgl_presensi')
            ->get();
        // Jika Tombol Export
        if (isset($_POST['exportexcel'])) {
            $time = date('d-M-Y H:i:s');
            //Fungsi Header dengan mengirimkan data raw data excel
            header("Content-type: application/vnd-ms-excel");
            //Mendefinisikan nama file export excel "tes.xls"
            header("Content-Disposition: attachment; filename=laporan presensi karyawan $time.xls");
            return view('presensi.cetaklaporanexcel', compact('bulan', 'tahun', 'namaBulan', 'karyawan', 'presensi', 'jam_kantor'));
        }

        // if (isset($_POST['cetak'])) {
        //     $pdf = PDF::loadView('presensi.cetaklaporan', compact('bulan', 'tahun', 'namaBulan', 'karyawan', 'presensi', 'jam_kantor'));
        //     // $pdf->setPaper('A4', 'portrait');
        //     return $pdf->download('lap_presensi.pdf');
        // }


        return view('presensi.cetaklaporan', compact('bulan', 'tahun', 'namaBulan', 'karyawan', 'presensi', 'jam_kantor'));
    }

    public function rekap()
    {
        $namaBulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        return view('presensi.rekap', compact('namaBulan'));
    }

    public function cetakrekap(Request $request)
    {
        $jam_kantor = DB::table('konfigurasi_jam')->where('id', 1)->first();
        $namaBulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $rekap = DB::table('presensi')
            ->selectRaw('presensi.nik, nama_lengkap,
              MAX(IF(DAY(tgl_presensi)=1, CONCAT(jam_in,"-", IFNULL(jam_out,"00:00:00")),"")) as tgl_1,
              MAX(IF(DAY(tgl_presensi)=2, CONCAT(jam_in,"-", IFNULL(jam_out,"00:00:00")),"")) as tgl_2,
              MAX(IF(DAY(tgl_presensi)=3, CONCAT(jam_in,"-", IFNULL(jam_out,"00:00:00")),"")) as tgl_3,
              MAX(IF(DAY(tgl_presensi)=4, CONCAT(jam_in,"-", IFNULL(jam_out,"00:00:00")),"")) as tgl_4,
              MAX(IF(DAY(tgl_presensi)=5, CONCAT(jam_in,"-", IFNULL(jam_out,"00:00:00")),"")) as tgl_5,
              MAX(IF(DAY(tgl_presensi)=6, CONCAT(jam_in,"-", IFNULL(jam_out,"00:00:00")),"")) as tgl_6,
              MAX(IF(DAY(tgl_presensi)=7, CONCAT(jam_in,"-", IFNULL(jam_out,"00:00:00")),"")) as tgl_7,
              MAX(IF(DAY(tgl_presensi)=8, CONCAT(jam_in,"-", IFNULL(jam_out,"00:00:00")),"")) as tgl_8,
              MAX(IF(DAY(tgl_presensi)=9, CONCAT(jam_in,"-", IFNULL(jam_out,"00:00:00")),"")) as tgl_9,
              MAX(IF(DAY(tgl_presensi)=10, CONCAT(jam_in,"-", IFNULL(jam_out,"00:00:00")),"")) as tgl_10,
              MAX(IF(DAY(tgl_presensi)=11, CONCAT(jam_in,"-", IFNULL(jam_out,"00:00:00")),"")) as tgl_11,
              MAX(IF(DAY(tgl_presensi)=12, CONCAT(jam_in,"-", IFNULL(jam_out,"00:00:00")),"")) as tgl_12,
              MAX(IF(DAY(tgl_presensi)=13, CONCAT(jam_in,"-", IFNULL(jam_out,"00:00:00")),"")) as tgl_13,
              MAX(IF(DAY(tgl_presensi)=14, CONCAT(jam_in,"-", IFNULL(jam_out,"00:00:00")),"")) as tgl_14,
              MAX(IF(DAY(tgl_presensi)=15, CONCAT(jam_in,"-", IFNULL(jam_out,"00:00:00")),"")) as tgl_15,
              MAX(IF(DAY(tgl_presensi)=16, CONCAT(jam_in,"-", IFNULL(jam_out,"00:00:00")),"")) as tgl_16,
              MAX(IF(DAY(tgl_presensi)=17, CONCAT(jam_in,"-", IFNULL(jam_out,"00:00:00")),"")) as tgl_17,
              MAX(IF(DAY(tgl_presensi)=18, CONCAT(jam_in,"-", IFNULL(jam_out,"00:00:00")),"")) as tgl_18,
              MAX(IF(DAY(tgl_presensi)=19, CONCAT(jam_in,"-", IFNULL(jam_out,"00:00:00")),"")) as tgl_19,
              MAX(IF(DAY(tgl_presensi)=20, CONCAT(jam_in,"-", IFNULL(jam_out,"00:00:00")),"")) as tgl_20,
              MAX(IF(DAY(tgl_presensi)=21, CONCAT(jam_in,"-", IFNULL(jam_out,"00:00:00")),"")) as tgl_21,
              MAX(IF(DAY(tgl_presensi)=22, CONCAT(jam_in,"-", IFNULL(jam_out,"00:00:00")),"")) as tgl_22,
              MAX(IF(DAY(tgl_presensi)=23, CONCAT(jam_in,"-", IFNULL(jam_out,"00:00:00")),"")) as tgl_23,
              MAX(IF(DAY(tgl_presensi)=24, CONCAT(jam_in,"-", IFNULL(jam_out,"00:00:00")),"")) as tgl_24,
              MAX(IF(DAY(tgl_presensi)=25, CONCAT(jam_in,"-", IFNULL(jam_out,"00:00:00")),"")) as tgl_25,
              MAX(IF(DAY(tgl_presensi)=26, CONCAT(jam_in,"-", IFNULL(jam_out,"00:00:00")),"")) as tgl_26,
              MAX(IF(DAY(tgl_presensi)=27, CONCAT(jam_in,"-", IFNULL(jam_out,"00:00:00")),"")) as tgl_27,
              MAX(IF(DAY(tgl_presensi)=28, CONCAT(jam_in,"-", IFNULL(jam_out,"00:00:00")),"")) as tgl_28,
              MAX(IF(DAY(tgl_presensi)=29, CONCAT(jam_in,"-", IFNULL(jam_out,"00:00:00")),"")) as tgl_29,
              MAX(IF(DAY(tgl_presensi)=30, CONCAT(jam_in,"-", IFNULL(jam_out,"00:00:00")),"")) as tgl_30,
              MAX(IF(DAY(tgl_presensi)=31, CONCAT(jam_in,"-", IFNULL(jam_out,"00:00:00")),"")) as tgl_31')
            ->join('karyawan', 'presensi.nik', '=', 'karyawan.nik')
            ->whereRaw('MONTH(tgl_presensi)="' . $bulan . '"')
            ->whereRaw('YEAR(tgl_presensi)="' . $tahun . '"')
            ->groupByRaw('presensi.nik, nama_lengkap')
            ->get();
        if (isset($_POST['exportexcel'])) {
            $time = date('d-M-Y H:i:s');
            //Fungsi Header dengan mengirimkan data raw data excel
            header("Content-type: application/vnd-ms-excel");
            //Mendefinisikan nama file export excel "tes.xls"
            header("Content-Disposition: attachment; filename=laporan presensi karyawan $time.xls");
        }

        // dd($rekap);
        return view('presensi.cetakrekap', compact('bulan', 'tahun', 'namaBulan', 'rekap', 'jam_kantor'));
    }

    public function dataizin(Request $request)
    {
        $query = PengajuanIzin::query();
        $query->select('id', 'tanggal', 'pengajuan_izin.nik', 'nama_lengkap', 'jabatan', 'status', 'status_approved', 'keterangan');
        $query->join('karyawan', 'pengajuan_izin.nik', '=', 'karyawan.nik');
        // Cek Request button Cari data
        if (!empty($request->tglmulai) && !empty($request->tglsampai)) {
            $query->whereBetween('tanggal', [$request->tglmulai, $request->tglsampai]);
        }
        if (!empty($request->nik)) {
            $query->where('pengajuan_izin.nik', $request->nik);
        }
        if (!empty($request->nama_lengkap)) {
            $query->where('nama_lengkap', 'like', '%' . $request->nama_lengkap . '%');
        }
        if ($request->status_approved === '0' || $request->status_approved === '1' || $request->status_approved === '2') {
            $query->where('status_approved', $request->status_approved);
        }
        $query->orderBy('tanggal', 'desc');
        $izinsakit = $query->paginate(10);
        $izinsakit->appends($request->all());
        return view('presensi.dataizin', compact('izinsakit'));
    }

    public function approveizin(Request $request)
    {
        $status = $request->status_approved;
        $id_izin_form = $request->id_izin_form;
        $update = DB::table('pengajuan_izin')->where('id', $id_izin_form)->update([
            'status_approved' => $status,
        ]);
        if ($update) {
            return redirect::back()->with(['success' => 'Status Berhasil Di Update']);
        } else {
            return redirect::back()->with(['error' => 'Status Gagal Di Simpan']);
        }
    }

    public function rejected($id)
    {
        $update = DB::table('pengajuan_izin')->where('id', $id)->update([
            'status_approved' => 0,
        ]);
        if ($update) {
            return redirect::back()->with(['success' => 'Status Berhasil Di Update']);
        } else {
            return redirect::back()->with(['error' => 'Status Gagal Di Simpan']);
        }
    }
}
