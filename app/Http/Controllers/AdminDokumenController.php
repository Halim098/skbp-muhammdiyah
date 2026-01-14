<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use ZipArchive;
use Illuminate\Support\Facades\Storage;

class AdminDokumenController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('dokumen')
            ->join('mahasiswa', 'dokumen.nim', '=', 'mahasiswa.nim')
            ->whereIn('dokumen.nim', function ($sub) {
                $sub->select('nim')
                    ->from('dokumen')
                    ->where('status', 'pending');
            })
            ->select(
                'dokumen.*',
                'mahasiswa.nama',
                'mahasiswa.fakultas',
                'mahasiswa.jurusan',
                'mahasiswa.jenis as jenis_karya'
            )
            ->orderBy('dokumen.add_time', 'desc');


        // 🔍 SEARCH SERVER SIDE
        if ($request->filled('q')) {
            $q = $request->q;

            $query->where(function ($s) use ($q) {
                $s->where('dokumen.nim', 'like', "%$q%")
                    ->orWhere('mahasiswa.nama', 'like', "%$q%")
                    ->orWhere('mahasiswa.fakultas', 'like', "%$q%")
                    ->orWhere('mahasiswa.jurusan', 'like', "%$q%")
                    ->orWhere('mahasiswa.jenis', 'like', "%$q%");
            });
        }

        $data = $query
            ->orderBy('dokumen.add_time', 'desc')
            ->get()
            ->groupBy('nim');

        // manual pagination setelah groupBy
        $page    = request()->get('page', 1);
        $perPage = 10;
        $items   = $data->slice(($page - 1) * $perPage, $perPage);

        $dokumen = new \Illuminate\Pagination\LengthAwarePaginator(
            $items,
            $data->count(),
            $perPage,
            $page,
            [
                'path'  => request()->url(),
                'query' => request()->query(), // 🔑 penting
            ]
        );

        return view('admin.dokumen', compact('dokumen'));
    }

    public function verifikasi(Request $request)
    {
        $request->validate([
            'status' => 'array',
            'keterangan' => 'array',
            'nim' => 'required'
        ]);

        // ===============================
        // UPDATE STATUS & KETERANGAN
        // ===============================
        if ($request->status) {
            foreach ($request->status as $id => $status) {

                if (!in_array($status, ['diterima', 'ditolak'])) {
                    continue;
                }

                $update = [
                    'status' => $status
                ];

                // jika keterangan diisi, update
                if (
                    isset($request->keterangan[$id]) &&
                    trim($request->keterangan[$id]) !== ''
                ) {
                    $update['keterangan'] = $request->keterangan[$id];
                }

                DB::table('dokumen')
                    ->where('id', $id)
                    ->update($update);
            }
        }

        $nim = $request->nim;

        // ===============================
        // DAFTAR DOKUMEN WAJIB
        // ===============================
        $wajibskri = [
            'pendahuluan',
            'bab1',
            'bab2',
            'bab3',
            'bab4',
            'bab5',
            'lampiran',
            'abstraksi',
            'jurnal',
            'surat',
            'skripsi_full',
            'bukti_sumbangan',
        ];

        $wajibbuku = [
            'testbuku1',
            'testbuku2',
            'testbuku3',
            'testbuku4',
            'testbuku5',
        ];

        $wajibartikel = [
            'testartikel1',
            'testartikel2',
            'testartikel3',
            'testartikel4',
            'testartikel5',
        ];

        // ambil dokumen mahasiswa
        $dokumen = DB::table('dokumen')
            ->where('nim', $nim)
            ->get()
            ->keyBy('jenis');

        $semuaLengkap = true;

        $jenis_karya = DB::table('mahasiswa')
            ->where('nim', $nim)
            ->value('jenis');

        if ($jenis_karya === 'skripsi') {
            $wajib = $wajibskri;
        } elseif ($jenis_karya === 'buku') {
            $wajib = $wajibbuku;
        } else {
            $wajib = $wajibartikel;
        }

        foreach ($wajib as $jenis) {
            if (
                !isset($dokumen[$jenis]) ||
                $dokumen[$jenis]->status !== 'diterima'
            ) {
                $semuaLengkap = false;
                break;
            }
        }

        // UPDATE STATUS MAHASISWA (JIKA PERLU)
        if ($semuaLengkap) {

            $sudahValid = DB::table('mahasiswa')
                ->where('nim', $nim)
                ->where('status_dokumen', 'valid')
                ->exists();

            if (!$sudahValid) {
                DB::table('mahasiswa')
                    ->where('nim', $nim)
                    ->update([
                        'status_dokumen' => 'valid',
                        'valid_dokumen_time' => now()->timezone('Asia/Jakarta')
                    ]);
            }

            $cek = DB::table('mahasiswa')
                ->join('hardcopy', 'mahasiswa.nim', '=', 'hardcopy.nim')
                ->where('mahasiswa.nim', $nim)
                ->select(
                    'hardcopy.valid as status_hardcopy',
                    'mahasiswa.status_dokumen'
                )
                ->first();

            if (
                $cek &&
                $cek->status_hardcopy === 'valid' &&
                $cek->status_dokumen === 'valid'
            ) {

                $exists = DB::table('valid_skbp')
                    ->where('nim', $nim)
                    ->exists();

                if (!$exists) {
                    DB::table('valid_skbp')->insert([
                        'nim' => $nim,
                        'status_skbp' => 'valid',
                        'valid_skbp_time' => now('Asia/Jakarta'),
                    ]);
                }
            }
        }

        return back()->with(
            'success',
            $semuaLengkap
                ? 'Semua dokumen lengkap & diterima. Mahasiswa VALID.'
                : 'Verifikasi disimpan. Dokumen belum lengkap.'
        );
    }


    public function preview($id)
    {
        $dokumen = DB::table('dokumen')->where('id', $id)->first();
        abort_if(!$dokumen, 404);

        if (!Storage::disk('public')->exists($dokumen->path)) {
            abort(404, 'File tidak ditemukan');
        }

        return response()->file(
            Storage::disk('public')->path($dokumen->path),
            ['Content-Disposition' => 'inline']
        );
    }

    public function downloadZip($nim)
    {
        $files = DB::table('dokumen')
            ->where('nim', $nim)
            ->get();

        abort_if($files->isEmpty(), 404, 'Dokumen tidak ditemukan');

        $zipName = 'dokumen-' . $nim . '.zip';
        $zipPath = storage_path('app/temp/' . $zipName);

        // pastikan folder temp ada
        if (!file_exists(storage_path('app/temp'))) {
            mkdir(storage_path('app/temp'), 0755, true);
        }

        $zip = new ZipArchive;

        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            abort(500, 'Gagal membuat ZIP');
        }

        foreach ($files as $file) {
            // path relatif di disk public
            if (Storage::disk('public')->exists($file->path)) {
                $zip->addFile(
                    Storage::disk('public')->path($file->path),
                    basename($file->path)
                );
            }
        }

        $zip->close();

        return response()->download($zipPath)->deleteFileAfterSend(true);
    }
}
