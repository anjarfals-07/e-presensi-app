<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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


    // Ubah User
    public function passworduser()
    {
        $pass_user = DB::table('users')->where('id', 1)->first();
        return view('konfigurasi.passworduser', compact('pass_user'));
    }

    // public function updatepassworduser(Request $request)
    // {
    //     $name = $request->name;
    //     $email = $request->email;
    //     $password = $request->password;


    //     $update = DB::table('users')->where('id', 1)->update([
    //         'name' => $name,
    //         'email' => $email,
    //         'password'  => $password
    //     ]);

    //     if ($update) {
    //         return Redirect::back()->with(['success' => 'Data Password Admin Berhasil Di Update']);
    //     } else {
    //         return Redirect::back()->with(['warning' => 'Data Password Admin Gagal Di Update']);
    //     }
    // }

    public function updatepassworduser(Request $request)
    {
        $id = Auth::guard('user')->user()->id;
        $name = $request->name;
        $email = $request->email;
        $password = Hash::make($request->password);
        $pass_user = DB::table('users')->where('id', $id)->first();

        $data = [
            'name'  => $name,
            'email'  => $email,
            'password'  => $password
        ];


        $update =   DB::table('users')->where('id', $id)->update($data);
        if ($update) {
            return Redirect::back()->with(['success' => 'Data Berhasil Di Update']);
        } else {
            return Redirect::back()->with(['error' => 'Data Gagal Di Update']);
        }
    }
}
