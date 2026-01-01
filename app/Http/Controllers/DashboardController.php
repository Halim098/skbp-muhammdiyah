<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $mahasiswa = session('mahasiswa');

        // cek kelengkapan data mahasiswa
        $dataLengkap = collect([
            $mahasiswa->nama,
            $mahasiswa->fakultas,
            $mahasiswa->jurusan,
            $mahasiswa->email,
            $mahasiswa->no_hp,
            $mahasiswa->alamat,
            $mahasiswa->jenis,
            $mahasiswa->tempat_tanggal_lahir,
            $mahasiswa->agama,
        ])->every(fn($v) => !empty($v) && $v !== '-');

        // dokumen mahasiswa
        $dokumen = DB::table('dokumen')
            ->where('nim', $mahasiswa->nim)
            ->get()
            ->keyBy('jenis');

        return view('dashboard', compact('mahasiswa', 'dataLengkap', 'dokumen'));
    }
}
