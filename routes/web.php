<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthMahasiswaController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\DokumenController;
use App\Http\Controllers\DashboardController;

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

Route::post('/login', [AuthMahasiswaController::class, 'login']);

/*
|--------------------------------------------------------------------------
| DASHBOARD
|--------------------------------------------------------------------------
*/

Route::middleware('cekLogin')->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard', ['title' => 'Dashboard']);
    });
    Route::get('/dashboard', [DashboardController::class, 'index']);

    Route::get('/data-mahasiswa', function () {
        return view('data-mahasiswa', ['title' => 'Data Mahasiswa']);
    });
    Route::post('/mahasiswa/update', [MahasiswaController::class, 'update']);

    Route::get('/dokumen', function () {
        return view('dokumen', ['title' => 'Dokumen']);
    });

    Route::get('/dokumen', [DokumenController::class, 'index']);

    Route::post('/dokumen/upload', [DokumenController::class, 'upload'])
        ->name('dokumen.upload');
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
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    });
});
