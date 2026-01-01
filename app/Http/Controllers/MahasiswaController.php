<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MahasiswaController extends Controller
{
    public function update(Request $request)
    {
        $old = session('mahasiswa'); // data lama dari session

        DB::table('mahasiswa')
            ->where('nim', $old->nim)
            ->update([
                'nama' => $request->filled('nama') ? $request->nama : $old->nama,
                'fakultas' => $request->filled('fakultas') ? $request->fakultas : $old->fakultas,
                'jurusan' => $request->filled('jurusan') ? $request->jurusan : $old->jurusan,
                'alamat' => $request->filled('alamat') ? $request->alamat : $old->alamat,
                'no_hp' => $request->filled('no_hp') ? $request->no_hp : $old->no_hp,
                'tempat_tanggal_lahir' => $request->filled('tempat_tanggal_lahir')
                    ? $request->tempat_tanggal_lahir
                    : $old->tempat_tanggal_lahir,
                'email' => $request->filled('email') ? $request->email : $old->email,
                'jenis' => $request->filled('jenis') ? $request->jenis : $old->jenis,
                'agama' => $request->filled('agama') ? $request->agama : $old->agama,
            ]);

        // ambil data terbaru dari database
        $data = DB::table('mahasiswa')
            ->where('nim', $old->nim)
            ->first();

        // update session
        session(['mahasiswa' => $data]);

        return back()->with('success', 'Data berhasil diperbarui');
    }
}
