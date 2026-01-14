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
            $mahasiswa->judul_karya,
        ])->every(fn($v) => !empty($v) && $v !== '-');

        $dokumen = DB::table('dokumen')
            ->where('nim', $mahasiswa->nim)
            ->get()
            ->keyBy('jenis');

        return view('dokumen', compact('dokumen', 'isLengkap'), ['title' => 'Upload Dokumen']);
    }

    private function getBasePath($mahasiswa)
    {
        // set tanggal folder sekali saja
        if (!$mahasiswa->folder_date) {
            $tanggal = now('Asia/Jakarta')->toDateString();

            DB::table('mahasiswa')
                ->where('nim', $mahasiswa->nim)
                ->update([
                    'folder_date' => $tanggal
                ]);
        } else {
            $tanggal = $mahasiswa->folder_date;
        }

        // rapikan nama folder (hindari spasi aneh & simbol)
        $fakultas = str_replace(['/', '\\'], '-', $mahasiswa->fakultas);
        $prodi    = str_replace(['/', '\\'], '-', $mahasiswa->jurusan);
        $namaNim  = str_replace(['/', '\\'], '-', "{$mahasiswa->nama}_{$mahasiswa->nim}");

        return "dokumen/{$fakultas}/{$prodi}/{$tanggal}/{$namaNim}";
    }


    public function uploadSkripsi(Request $request)
    {
        $mahasiswa = session('mahasiswa');
        $nim = $mahasiswa->nim;

        $pathBase = $this->getBasePath($mahasiswa);

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
            'bukti_sumbangan' => 'Bukti-Sumbangan',
        ];

        foreach ($map as $input => $label) {
            if ($request->hasFile($input)) {

                $file = $request->file($input);
                $ext  = $file->getClientOriginalExtension();
                $filename = "{$nim}-{$label}.{$ext}";

                // ambil data lama
                $old = DB::table('dokumen')
                    ->where('nim', $nim)
                    ->where('jenis', $input)
                    ->first();

                // HAPUS FILE LAMA (update)
                if ($old && Storage::disk('public')->exists($old->path)) {
                    Storage::disk('public')->delete($old->path);
                }

                // SIMPAN KE FOLDER YANG SAMA
                $file->storeAs($pathBase, $filename, 'public');

                DB::table('dokumen')->updateOrInsert(
                    ['nim' => $nim, 'jenis' => $input],
                    [
                        'path' => "{$pathBase}/{$filename}",
                        'status' => 'pending',
                        'add_time' => now('Asia/Jakarta'),
                    ]
                );
            }
        }

        return back()->with('success', 'Dokumen berhasil diupload');
    }


    public function uploadBuku(Request $request)
    {
        $mahasiswa = session('mahasiswa');
        $nim = $mahasiswa->nim;

        // BASE PATH SAMA DENGAN SKRIPSI
        $pathBase = $this->getBasePath($mahasiswa);

        for ($i = 1; $i <= 5; $i++) {
            $key = "testbuku{$i}";

            if ($request->hasFile($key)) {

                $file = $request->file($key);
                $ext  = $file->getClientOriginalExtension();
                $filename = "{$nim}-testbuku{$i}.{$ext}";

                $old = DB::table('dokumen')
                    ->where('nim', $nim)
                    ->where('jenis', $key)
                    ->first();

                // HAPUS FILE LAMA (UPDATE)
                if ($old && Storage::disk('public')->exists($old->path)) {
                    Storage::disk('public')->delete($old->path);
                }

                // SIMPAN DI FOLDER YANG SAMA
                $file->storeAs($pathBase, $filename, 'public');

                DB::table('dokumen')->updateOrInsert(
                    ['nim' => $nim, 'jenis' => $key],
                    [
                        'path' => "{$pathBase}/{$filename}",
                        'status' => 'pending',
                        'add_time' => now('Asia/Jakarta'),
                    ]
                );
            }
        }

        return back()->with('success', 'Dokumen buku berhasil diupload');
    }

    public function uploadArtikel(Request $request)
    {
        $mahasiswa = session('mahasiswa');
        $nim = $mahasiswa->nim;

        // BASE PATH SAMA DENGAN SKRIPSI
        $pathBase = $this->getBasePath($mahasiswa);

        for ($i = 1; $i <= 5; $i++) {
            $key = "testartikel{$i}";

            if ($request->hasFile($key)) {

                $file = $request->file($key);
                $ext  = $file->getClientOriginalExtension();
                $filename = "{$nim}-testartikel{$i}.{$ext}";

                $old = DB::table('dokumen')
                    ->where('nim', $nim)
                    ->where('jenis', $key)
                    ->first();

                // HAPUS FILE LAMA (UPDATE)
                if ($old && Storage::disk('public')->exists($old->path)) {
                    Storage::disk('public')->delete($old->path);
                }

                // SIMPAN DI FOLDER YANG SAMA
                $file->storeAs($pathBase, $filename, 'public');

                DB::table('dokumen')->updateOrInsert(
                    ['nim' => $nim, 'jenis' => $key],
                    [
                        'path' => "{$pathBase}/{$filename}",
                        'status' => 'pending',
                        'add_time' => now('Asia/Jakarta'),
                    ]
                );
            }
        }

        return back()->with('success', 'Dokumen artikel berhasil diupload');
    }
}
