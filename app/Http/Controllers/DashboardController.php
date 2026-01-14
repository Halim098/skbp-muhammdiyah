<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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
            $mahasiswa->judul_karya,
        ])->every(fn($v) => !empty($v) && $v !== '-');

        // dokumen mahasiswa
        $dokumen = DB::table('dokumen')
            ->where('nim', $mahasiswa->nim)
            ->get()
            ->keyBy('jenis');

        $hardcopy = DB::table('hardcopy')
            ->where('nim', $mahasiswa->nim)
            ->first();


        $cek = DB::table('mahasiswa')
            ->join('hardcopy', 'mahasiswa.nim', '=', 'hardcopy.nim')
            ->where('mahasiswa.nim', $mahasiswa->nim)
            ->select(
                'hardcopy.valid as status_hardcopy',
                'mahasiswa.status_dokumen'
            )
            ->first();

        $skbpReady = 0;
        if (
            $cek &&
            $cek->status_hardcopy === 'valid' &&
            $cek->status_dokumen === 'valid'
        ) {

            $skbpReady = 1;
        }

        return view('dashboard', compact('mahasiswa', 'dataLengkap', 'dokumen', 'hardcopy', 'skbpReady'), ['title' => 'Dashboard SKBP']);
    }

    public function hardcopy(Request $request)
    {
        $request->validate([
            'nim' => 'required',
            'pilihan' => 'required',
        ]);

        // cek apakah sudah pernah memilih
        $exists = DB::table('hardcopy')
            ->where('nim', $request->nim)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Pilihan hard copy sudah disimpan sebelumnya.');
        }

        DB::table('hardcopy')->insert([
            'nim' => $request->nim,
            'pilihan' => $request->pilihan,
            'valid' => 'tidak valid',
            'add_time' => Carbon::now('Asia/Jakarta'),
        ]);

        return redirect()->to(url()->previous() . '#tahap-3')
            ->with('success', 'Pilihan penyerahan hard copy berhasil disimpan.');
    }
}
