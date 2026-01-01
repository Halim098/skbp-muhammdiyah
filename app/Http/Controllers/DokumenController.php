<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DokumenController extends Controller
{
    public function index()
    {
        $mahasiswa = session('mahasiswa');

        // cek kelengkapan data
        $isLengkap = collect([
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

        $dokumen = DB::table('dokumen')
            ->where('nim', $mahasiswa->nim)
            ->get()
            ->keyBy('jenis');

        return view('dokumen', compact('dokumen', 'isLengkap'));
    }


    public function upload(Request $request)
    {
        $nim = session('mahasiswa')->nim;

        $map = [
            'pendahuluan' => 'Pendahuluan',
            'bab1' => 'ISI-BAB1',
            'bab2' => 'ISI-BAB2',
            'bab3' => 'ISI-BAB3',
            'bab4' => 'ISI-BAB4',
            'bab5' => 'ISI-BAB5',
            'lampiran' => 'Lampiran',
            'abstraksi' => 'Abstraksi',
            'jurnal' => 'Jurnal',
            'surat' => 'Surat-Pernyataan',
            'skripsi_full' => 'Skripsi-Lengkap',
        ];

        foreach ($map as $input => $label) {
            if ($request->hasFile($input)) {

                $file = $request->file($input);
                $ext = $file->getClientOriginalExtension();

                $filename = "{$nim}-{$label}.{$ext}";
                $path = "dokumen/{$nim}";

                // === CEK DATA LAMA ===
                $old = DB::table('dokumen')
                    ->where('nim', $nim)
                    ->where('jenis', $input)
                    ->first();

                // hapus file lama jika ada
                if ($old && Storage::disk('public')->exists($old->path)) {
                    Storage::disk('public')->delete($old->path);
                }

                // simpan file baru
                $file->storeAs($path, $filename, 'public');

                // simpan / update database
                DB::table('dokumen')->updateOrInsert(
                    [
                        'nim' => $nim,
                        'jenis' => $input
                    ],
                    [
                        'path' => "{$path}/{$filename}",
                        'status' => 'pending',
                        'add_time' => now()
                    ]
                );
            }
        }

        return back()->with('success', 'Dokumen berhasil diupload / diperbarui');
    }
}
