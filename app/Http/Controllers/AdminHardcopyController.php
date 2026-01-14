<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminHardcopyController extends Controller
{
    // tampilkan hardcopy yang belum valid
    public function index(Request $request)
    {
        $query = DB::table('hardcopy')
            ->join('mahasiswa', 'hardcopy.nim', '=', 'mahasiswa.nim')
            ->select(
                'hardcopy.id',
                'hardcopy.nim',
                'hardcopy.pilihan',
                'hardcopy.valid',
                'hardcopy.add_time',
                'mahasiswa.nama',
                'mahasiswa.jurusan as prodi',
                'mahasiswa.fakultas'
            )
            ->where('hardcopy.valid', 'tidak valid');

        // 🔍 SEARCH
        if ($request->filled('q')) {
            $q = $request->q;

            $query->where(function ($s) use ($q) {
                $s->where('hardcopy.nim', 'like', "%$q%")
                    ->orWhere('mahasiswa.nama', 'like', "%$q%")
                    ->orWhere('mahasiswa.jurusan', 'like', "%$q%")
                    ->orWhere('mahasiswa.fakultas', 'like', "%$q%")
                    ->orWhere('hardcopy.pilihan', 'like', "%$q%");
            });
        }

        $hardcopy = $query
            ->orderBy('hardcopy.add_time', 'desc')
            ->paginate(10)
            ->withQueryString(); // 🔑 penting

        return view('admin.hardcopy', compact('hardcopy'));
    }

    // validasi hardcopy
    public function validasi($id)
    {

        $nim = DB::table('hardcopy')
            ->where('id', $id)
            ->value('nim');

        DB::table('hardcopy')
            ->where('id', $id)
            ->update([
                'valid' => 'valid',
                'valid_hardcopy_time' => Carbon::now('Asia/Jakarta'),
            ]);

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

        return back()->with('success', 'Hardcopy berhasil divalidasi');
    }
}
