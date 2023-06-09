<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class DepartemenController extends Controller
{
    public function index(Request $request)
    {
        $nama_dept = $request->nama_dept;
        $query = Departemen::query();
        $query->select('*');
        if (!empty($nama_dept)) {
            $query->where('nama_dept', 'like', '%' . $request->nama_dept . '%');
        }
        if (!empty($request->kode_dept)) {
            $query->where('kode_dept', 'like', '%' . $request->kode_dept . '%');
        }
        $departemen = $query->paginate(10);
        // $departemen = $query->get();


        return view('departemen.index', compact('departemen'));
    }

    public function store(Request $request)
    {
        $kode_dept = $request->kode_dept;
        $nama_dept = $request->nama_dept;

        $data = [
            'kode_dept' => $kode_dept,
            'nama_dept' => $nama_dept,
        ];
        $cek = DB::table('departemen')->where('kode_dept', $kode_dept)->count();
        if ($cek > 0) {
            return Redirect::back()->with(['warning' => 'Data dengan Kode Departemen .' . $kode_dept . ' Sudah Ada']);
        }
        $simpan = DB::table('departemen')->insert($data);
        if ($simpan) {
            return Redirect::back()->with(['success' => 'Data Departemen Berhasil Di Simpan']);
        } else {
            return Redirect::back()->with(['warning' => 'Data Departemen Gagal Di Simpan']);
        }
    }

    public function edit(Request $request)
    {
        $kode_dept = $request->kode_dept;
        $departemen = DB::table('departemen')->where('kode_dept', $kode_dept)->first();
        return view('departemen.edit', compact('departemen'));
    }
    public function update($kode_dept, Request $request)
    {
        $nama_dept = $request->nama_dept;

        $data = [
            'nama_dept' => $nama_dept,
        ];
        $update = DB::table('departemen')->where('kode_dept', $kode_dept)->update($data);
        if ($update) {
            return Redirect::back()->with(['success' => 'Data Departemen Berhasil Di Update']);
        } else {
            return Redirect::back()->with(['warning' => 'Data Departemen Gagal Di Update']);
        }
    }

    public function delete($kode_dept)
    {
        $delete = DB::table('departemen')->where('kode_dept', $kode_dept)->delete();
        if ($delete) {
            return Redirect::back()->with(['success' => 'Data Departemen Berhasil Di Delete']);
        } else {
            return Redirect::back()->with(['warning' => 'Data Departemen Gagal Di Delete']);
        }
    }
}
