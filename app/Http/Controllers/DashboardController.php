<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $tgl = date("Y-m-d");
        $bulan = date("m") * 1;
        $tahun = date("Y");
        $nik = Auth::guard('karyawan')->user()->nik;

        $presensiNow = DB::table('presensi')
            ->where('nik', $nik)
            ->where('tgl_presensi', $tgl)
            ->first();
        $historyPresensi = DB::table('presensi')
            ->where('nik', $nik)
            ->whereRaw('MONTH(tgl_presensi)="' . $bulan . '"')
            ->whereRaw('YEAR(tgl_presensi)="' . $tahun . '"')
            ->orderBy('tgl_presensi')
            ->get();

        $namaBulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        $jam_kantor = DB::table('konfigurasi_jam')->where('id', 1)->first();

        $rekapPresensi = DB::table('presensi')
            // ->selectRaw('COUNT(nik) as jmlhadir, SUM(IF(jam_in > "07:00",1,0)) as jmltelat')
            ->selectRaw('COUNT(nik) as jmlhadir, SUM(IF(jam_in > "' . $jam_kantor->jam_masuk . '",1,0)) as jmltelat')
            ->where('nik', $nik)
            ->whereRaw('MONTH(tgl_presensi)="' . $bulan . '"')
            ->whereRaw('YEAR(tgl_presensi)="' . $tahun . '"')
            ->first();

        $leaderBoard = DB::table('presensi')
            ->join('karyawan', 'presensi.nik', '=', 'karyawan.nik')
            ->where('tgl_presensi', $tgl)
            ->orderBy('jam_in')
            ->get();

        $rekapizin = DB::table('pengajuan_izin')
            ->selectRaw('SUM(IF(status="i",1,0)) as jmlizin,SUM(IF(status="s",1,0)) as jmlsakit')
            ->where('nik', $nik)
            ->whereRaw('MONTH(tanggal)="' . $bulan . '"')
            ->whereRaw('YEAR(tanggal)="' . $tahun . '"')
            ->where('status_approved', 1)
            ->first();


        return view('dashboard.dashboard', compact('presensiNow', 'historyPresensi', 'namaBulan', 'bulan', 'tahun', 'rekapPresensi', 'leaderBoard', 'rekapizin', 'jam_kantor'));
    }

    // Dashboard Admin
    public function dashboardadmin()
    {
        $jam_kantor = DB::table('konfigurasi_jam')->where('id', 1)->first();
        $jam_kantor = DB::table('konfigurasi_jam')->where('id', 1)->first();

        $tanggalSekarang = date('Y-m-d');
        $rekapPresensi = DB::table('presensi')
            ->selectRaw('COUNT(nik) as jmlhadir, SUM(IF(jam_in > "' . $jam_kantor->jam_masuk . '",1,0)) as jmltelat')
            ->where('tgl_presensi', $tanggalSekarang)
            ->first();

        $rekapizin = DB::table('pengajuan_izin')
            ->selectRaw('SUM(IF(status="i",1,0)) as jmlizin,SUM(IF(status="s",1,0)) as jmlsakit')
            ->where('tanggal', $tanggalSekarang)
            ->where('status_approved', 1)
            ->first();
        return view('dashboard.dashboardadmin', compact('rekapPresensi', 'rekapizin'));
    }
}
