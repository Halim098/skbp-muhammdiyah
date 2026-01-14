<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Milon\Barcode\DNS2D;
use Carbon\Carbon;


// butuh qr composer require simplesoftwareio/simple-qrcode
// butuh dompdf composer require barryvdh/laravel-dompdf

class CetakSKBPController extends Controller
{
    // 🔽 CETAK SKBP (sementara placeholder)
    public function print($nim)
    {
        $skbp = DB::table('valid_skbp')
            ->join('mahasiswa', 'valid_skbp.nim', '=', 'mahasiswa.nim')
            ->join('hardcopy', 'mahasiswa.nim', '=', 'hardcopy.nim')
            ->where('valid_skbp.nim', $nim)
            ->select(
                'valid_skbp.*',
                'mahasiswa.nama',
                'mahasiswa.nim',
                'mahasiswa.fakultas',
                'mahasiswa.jurusan',
                'mahasiswa.alamat',
                'mahasiswa.judul_karya',
                'mahasiswa.status_dokumen',
                'hardcopy.valid as status_hardcopy'
            )
            ->first();

        if (!$skbp || $skbp->status_dokumen !== 'valid' || $skbp->status_hardcopy !== 'valid') {
            abort(404);
        }

        // VARIABEL 1 → nomor urut
        $urut = DB::table('valid_skbp')
            ->where('valid_skbp_time', '<=', $skbp->valid_skbp_time)
            ->count();

        // VARIABEL 2 → tahun
        $tahun = Carbon::parse($skbp->valid_skbp_time)->year;

        // URL QR
        $barcodeUrl = url('/' . $skbp->nim);

        // ✅ BUAT OBJECT (INI KUNCI NYA)
        $dns2d = new DNS2D();
        $dns2d->setStorPath(storage_path('framework/cache'));

        $barcode = $dns2d->getBarcodePNG($barcodeUrl, 'QRCODE', 4, 4);

        $pdf = Pdf::loadView('cetak', compact(
            'skbp',
            'urut',
            'tahun',
            'barcode'
        ))->setPaper('A4');

        return $pdf->stream('SKBP-' . $skbp->nim . '.pdf');
    }


    public function show($nim)
    {
        $mahasiswa = DB::table('mahasiswa')->where('nim', $nim)->first();

        $hardcopy = DB::table('hardcopy')->where('nim', $nim)->first();

        $skbp = DB::table('valid_skbp')->where('nim', $nim)->first();

        $data = (object) [
            'nama' => $mahasiswa->nama ?? null,
            'nim' => $mahasiswa->nim ?? null,
            'judul_karya' => $mahasiswa->judul_karya ?? null,
            'status_dokumen' => $mahasiswa->status_dokumen ?? 'tidak valid',
            'hardcopy' => $hardcopy->valid ?? 'tidak valid',
            'status_skbp' => $skbp->status_skbp ?? 'tidak valid',
        ];

        return view('verify', compact('data'));
    }
}
