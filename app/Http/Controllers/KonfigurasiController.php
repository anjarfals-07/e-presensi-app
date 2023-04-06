<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class KonfigurasiController extends Controller
{
    public function lokasikantor()
    {
        $lokasi = DB::table('konfigurasi_lokasi')->where('id', 1)->first();
        return view('konfigurasi.lokasikantor', compact('lokasi'));
    }

    public function updatelokasikantor(Request $request)
    {
        $lokasi_kantor = $request->lokasi_kantor;
        $radius = $request->radius;


        $update = DB::table('konfigurasi_lokasi')->where('id', 1)->update([
            'lokasi_kantor' => $lokasi_kantor,
            'radius' => $radius
        ]);

        if ($update) {
            return Redirect::back()->with(['success' => 'Data Lokasi Kantor Berhasil Di Update']);
        } else {
            return Redirect::back()->with(['warning' => 'Data Lokasi Kantor Gagal Di Update']);
        }
    }

    public function jamkantor()
    {
        $jam_kantor = DB::table('konfigurasi_jam')->where('id', 1)->first();
        return view('konfigurasi.jamkantor', compact('jam_kantor'));
    }

    public function updatejamkantor(Request $request)
    {
        $jam_masuk = $request->jam_masuk;
        $jam_keluar = $request->jam_keluar;


        $update = DB::table('konfigurasi_jam')->where('id', 1)->update([
            'jam_masuk' => $jam_masuk,
            'jam_keluar' => $jam_keluar
        ]);

        if ($update) {
            return Redirect::back()->with(['success' => 'Data Jam Kantor Berhasil Di Update']);
        } else {
            return Redirect::back()->with(['warning' => 'Data Jam Kantor Gagal Di Update']);
        }
    }
}
