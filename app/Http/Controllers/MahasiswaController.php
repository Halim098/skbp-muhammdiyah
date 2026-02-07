<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MahasiswaController extends Controller
{
    private function capitalizeWords($text)
    {
        return mb_convert_case(trim($text), MB_CASE_TITLE, "UTF-8");
    }

    public function fakultas_Prodi()
    {
        $mahasiswa = session('mahasiswa');

        $fakultas = DB::table('fakultas')
            ->orderBy('nama')
            ->get();

        $prodi = DB::table('prodi')
            ->orderBy('nama')
            ->get();

        return view('data-mahasiswa', compact('mahasiswa', 'fakultas', 'prodi'), ['title' => 'Data Mahasiswa']);
    }


    public function update(Request $request)
    {
        $old = session('mahasiswa');

        DB::table('mahasiswa')
            ->where('nim', $old->nim)
            ->update([
                'nama' => $request->filled('nama')
                    ? $this->capitalizeWords($request->nama)
                    : $old->nama,

                'fakultas' => $request->filled('fakultas')
                    ? $this->capitalizeWords($request->fakultas)
                    : $old->fakultas,

                'jurusan' => $request->filled('jurusan')
                    ? $this->capitalizeWords($request->jurusan)
                    : $old->jurusan,

                'alamat' => $request->filled('alamat')
                    ? $this->capitalizeWords($request->alamat)
                    : $old->alamat,

                'no_hp' => $request->filled('no_hp')
                    ? trim($request->no_hp)
                    : $old->no_hp,

                'tempat_tanggal_lahir' => $request->filled('tempat_tanggal_lahir')
                    ? $this->capitalizeWords($request->tempat_tanggal_lahir)
                    : $old->tempat_tanggal_lahir,

                'email' => $request->filled('email')
                    ? strtolower(trim($request->email))
                    : $old->email,

                'jenis' => $request->filled('jenis')
                    ? $this->capitalizeWords($request->jenis)
                    : $old->jenis,

                'agama' => $request->filled('agama')
                    ? $this->capitalizeWords($request->agama)
                    : $old->agama,

                // 🔥 KHUSUS JUDUL KARYA → SEMUA HURUF BESAR
                'judul_karya' => $request->filled('judul_karya')
                    ? mb_strtoupper(trim($request->judul_karya), 'UTF-8')
                    : $old->judul_karya,
            ]);

        // ambil data terbaru
        $data = DB::table('mahasiswa')
            ->where('nim', $old->nim)
            ->first();

        session(['mahasiswa' => $data]);

        return back()->with('success', 'Data berhasil diperbarui');
    }
}
