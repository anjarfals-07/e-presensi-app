<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class KaryawanController extends Controller
{
    public function index(Request $request)
    {

        $query = Karyawan::query();
        $query->select('karyawan.*', 'nama_dept');

        $query->join('departemen', 'karyawan.kode_dept', '=', 'departemen.kode_dept');
        $query->orderBy('nama_lengkap');
        if (!empty($request->nama_karyawan)) {
            $query->where('nama_lengkap', 'like', '%' . $request->nama_karyawan . '%');
        }
        if (!empty($request->kode_dept)) {
            $query->where('karyawan.kode_dept', $request->kode_dept);
        }
        $karyawan = $query->paginate(10);


        $departemen = DB::table('departemen')->get();
        return view('karyawan.index', compact('karyawan', 'departemen'));
    }

    public function store(Request $request)
    {
        $nik = $request->nik;
        $nama_lengkap = $request->nama_lengkap;
        $jabatan = $request->jabatan;
        $no_hp = $request->no_hp;
        $kode_dept = $request->kode_dept;
        // Default password
        $password = Hash::make('12345');
        // Cek Karyawan sudah ada foto atau belum
        // Jika Belum
        if ($request->hasFile('foto')) {
            // Generate File Foto dengan nik
            $foto = $nik . "." . $request->file('foto')->getClientOriginalExtension();
        } else {
            // Jika tidak upload file maka di db akan null
            $foto = null;
        }
        // Pengecekan error saat simpan data
        try {
            $data = [
                'nik'   => $nik,
                'nama_lengkap'   => $nama_lengkap,
                'jabatan'   => $jabatan,
                'no_hp'   => $no_hp,
                'kode_dept'   => $kode_dept,
                'foto'   => $foto,
                'password'   => $password,
            ];
            $simpan = DB::table('karyawan')->insert($data);
            // Jika berhasil simpan
            if ($simpan) {
                // Simpan Foto Karyawan di directory yang ditentukan
                if ($request->hasFile('foto')) {
                    // Path photo
                    $folderPath = "public/uploads/karyawan/";
                    // Simpan foto kedalam path foto dan extension file photo.a
                    $request->file('foto')->storeAs($folderPath, $foto);
                }
                // Jika Berhasil
                return Redirect::back()->with(['success' => 'Data Karyawan Berhasil Di Simpan']);
            }
        } catch (\Exception $e) {
            // Jika Error
            return Redirect::back()->with(['warning' => 'Data Karyawan Gagal Di Simpan']);
        }
    }

    public function edit(Request $request)
    {
        $nik = $request->nik;
        $departemen = DB::table('departemen')->get();
        $karyawan = DB::table('karyawan')->where('nik', $nik)->first();
        return view('karyawan.edit', compact('departemen', 'karyawan'));
    }

    public function update($nik, Request $request)
    {
        $nik = $request->nik;
        $nama_lengkap = $request->nama_lengkap;
        $jabatan = $request->jabatan;
        $no_hp = $request->no_hp;
        $kode_dept = $request->kode_dept;
        // Default password
        $password = Hash::make('12345');
        $old_photo = $request->old_photo;
        // Cek Karyawan sudah ada foto atau belum
        // Jika Belum
        if ($request->hasFile('foto')) {
            // Generate File Foto dengan nik
            $foto = $nik . "." . $request->file('foto')->getClientOriginalExtension();
        } else {
            // foto lama
            $foto = $old_photo;
        }
        // Pengecekan error saat simpan data
        try {
            $data = [
                'nama_lengkap'   => $nama_lengkap,
                'jabatan'   => $jabatan,
                'no_hp'   => $no_hp,
                'kode_dept'   => $kode_dept,
                'foto'   => $foto,
                'password'   => $password,
            ];
            $update = DB::table('karyawan')->where('nik', $nik)->update($data);
            // Jika berhasil simpan
            if ($update) {
                // Simpan Foto Karyawan di directory yang ditentukan
                if ($request->hasFile('foto')) {
                    // Path photo
                    $folderPath = "public/uploads/karyawan/";
                    $folderPathOld = "public/uploads/karyawan/" . $old_photo;
                    // Hapus File Lama
                    Storage::delete($folderPathOld);
                    // Simpan foto kedalam path foto dan extension file photo.a
                    $request->file('foto')->storeAs($folderPath, $foto);
                }
                // Jika Berhasil
                return Redirect::back()->with(['success' => 'Data Karyawan Berhasil Di Update']);
            }
        } catch (\Exception $e) {
            // Jika Error
            return Redirect::back()->with(['warning' => 'Data Karyawan Gagal Di Update']);
        }
    }

    public function delete($nik)
    {
        $karyawan = Karyawan::find($nik);
        $photo = $karyawan->foto;
        $folderPathOld = "public/uploads/karyawan/" . $photo;
        $delete = DB::table('karyawan')->where('nik', $nik)->delete();
        if ($delete) {
            if (Storage::exists($folderPathOld)) {
                $folderPathOld = "public/uploads/karyawan/" . $photo;
                Storage::delete($folderPathOld);
            }
            return Redirect::back()->with(['success' => 'Data Karyawan Berhasil Di Delete']);
        } else {
            return Redirect::back()->with(['warning' => 'Data Karyawan Gagal Di Delete']);
        }
    }
}
