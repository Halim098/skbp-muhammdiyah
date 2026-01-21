<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthMahasiswaController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\DokumenController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminDokumenController;
use App\Http\Controllers\AdminHardcopyController;
use App\Http\Controllers\AdminValidSKBPController;
use App\Http\Controllers\CetakSKBPController;
use Illuminate\Support\Facades\Hash;

/*
|--------------------------------------------------------------------------
| LOGIN
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/captcha', [AuthMahasiswaController::class, 'captchaImage']);
Route::get('/refresh-captcha', [AuthMahasiswaController::class, 'refreshCaptcha']);
Route::post('/login', [AuthMahasiswaController::class, 'login']);
/*
|--------------------------------------------------------------------------
| Mahasiswa Area
|--------------------------------------------------------------------------
*/

Route::middleware('cekLogin')->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard', ['title' => 'Dashboard SKBP']);
    });
    Route::get('/dashboard', [DashboardController::class, 'index']);

    Route::get('/data-mahasiswa', function () {
        return view('data-mahasiswa', ['title' => 'Data Mahasiswa']);
    });
    Route::get('/data-mahasiswa', [MahasiswaController::class, 'fakultas_Prodi']);
    Route::post('/mahasiswa/update', [MahasiswaController::class, 'update']);

    Route::get('/dokumen', function () {
        return view('dokumen', ['title' => 'Upload Dokumen']);
    });

    Route::get('/dokumen', [DokumenController::class, 'index']);

    Route::post('/dokumen/upload/skripsi', [DokumenController::class, 'uploadSkripsi'])
        ->name('dokumen.upload.skripsi');

    Route::post('/dokumen/upload/buku', [DokumenController::class, 'uploadBuku'])
        ->name('dokumen.upload.buku');

    Route::post('/dokumen/upload/artikel', [DokumenController::class, 'uploadArtikel'])
        ->name('dokumen.upload.artikel');

    Route::post('/hardcopy/store', [DashboardController::class, 'hardcopy'])
        ->name('hardcopy.store');
});


/*
|--------------------------------------------------------------------------
| LOGOUT
|--------------------------------------------------------------------------
*/

Route::post('/logout', function () {
    session()->forget('mahasiswa');
    return redirect('/login');
});


/*
|--------------------------------------------------------------------------
| Admin Area
|--------------------------------------------------------------------------
*/

/* LOGIN ADMIN */
Route::get('/admin/login', [AdminAuthController::class, 'showLogin']);
Route::post('/admin/login', [AdminAuthController::class, 'login']);
Route::post('/admin/logout', [AdminAuthController::class, 'logout']);

/* AREA ADMIN (TERKUNCI) */
Route::middleware('cekAdmin')->group(function () {
    Route::prefix('admin')->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard', ['title' => 'Dashboard Admin']);
        });

        Route::get('/dokumen', [AdminDokumenController::class, 'index'])
            ->name('admin.dokumen');

        Route::get('/dokumen/zip/{nim}', [AdminDokumenController::class, 'downloadZip'])
            ->name('admin.dokumen.zip');

        Route::get('/dokumen/{id}/preview', [AdminDokumenController::class, 'preview'])
            ->name('admin.dokumen.preview');

        Route::post('/dokumen/verifikasi-bulk', [AdminDokumenController::class, 'verifikasi'])
            ->name('admin.dokumen.verifikasi.bulk');

        Route::get('/hardcopy', [AdminHardcopyController::class, 'index'])
            ->name('admin.hardcopy.index');

        Route::put('/hardcopy/{id}/validasi', [AdminHardcopyController::class, 'validasi'])
            ->name('admin.hardcopy.validasi');

        Route::get('/skbp', [AdminValidSKBPController::class, 'index'])
            ->name('admin.skbp.index');

        Route::delete('/mahasiswa/{nim}', [AdminDokumenController::class, 'destroy'])
            ->name('admin.mahasiswa.destroy');
    });
});
// cetak skbp
Route::get('/skbp/cetak/{nim}', [CetakSKBPController::class, 'print'])
    ->name('admin.skbp.cetak');

Route::get('/{nim}', [CetakSKBPController::class, 'show']);

// hashing password admin
// Route::get('/hash-admin', function () {
//     $password = '!@SKBP25';
//     $hashed = Hash::make($password);
//     return $hashed;
// });
