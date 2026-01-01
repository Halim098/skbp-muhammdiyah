<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthMahasiswaController extends Controller
{
    public function login(Request $request)
    {
        $nim = trim($request->nim);

        // validasi format
        if (!preg_match('/^\d{2}\.\d{2}\.\d{1,20}$/', $nim)) {
            return back()->with('error', 'Format NIM tidak valid');
        }

        // cek nim
        $data = DB::table('mahasiswa')->where('nim', $nim)->first();

        if (!$data) {
            DB::table('mahasiswa')->insert([
                'nim'      => $nim,
                'nama'     => '-',
                'fakultas' => '-',
                'jurusan'  => '-',
                'alamat'    => '-',
                'no_hp'     => '-',
                'tempat_tanggal_lahir' => '-',
                'email'     => '-',
                'jenis'     => '-',
                'agama'    => '-',
                'status'   => 'tidak valid',
            ]);

            $data = DB::table('mahasiswa')->where('nim', $nim)->first();
        }

        // simpan session (tanpa session_start)
        session(['mahasiswa' => $data]);

        return redirect('/dashboard');
    }
}
