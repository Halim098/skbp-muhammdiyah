<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminValidSKBPController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('valid_skbp')
            ->join('mahasiswa', 'valid_skbp.nim', '=', 'mahasiswa.nim')
            ->join('hardcopy', 'valid_skbp.nim', '=', 'hardcopy.nim')
            ->select(
                'mahasiswa.nama',
                'mahasiswa.nim',
                'mahasiswa.fakultas',
                'mahasiswa.jurusan as prodi',
                'mahasiswa.alamat',
                'mahasiswa.judul_karya',
                'mahasiswa.status_dokumen',
                'hardcopy.valid as status_hardcopy'
            )
            ->where('valid_skbp.status_skbp', 'valid');

        // 🔍 SEARCH
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($s) use ($q) {
                $s->where('mahasiswa.nama', 'like', "%$q%")
                    ->orWhere('mahasiswa.nim', 'like', "%$q%")
                    ->orWhere('mahasiswa.fakultas', 'like', "%$q%")
                    ->orWhere('mahasiswa.jurusan', 'like', "%$q%")
                    ->orWhere('mahasiswa.judul_karya', 'like', "%$q%");
            });
        }

        $skbp = $query
            ->orderBy('mahasiswa.nama')
            ->paginate(10)
            ->withQueryString();

        return view('admin.skbp', compact('skbp'));
    }
}
