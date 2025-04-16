<?php

use App\Http\Controllers\PresensiSiswaController;
use App\Http\Controllers\PresensiGuruController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PresensiMapController;
use Illuminate\Support\Facades\Route;
use Mews\Captcha\Facades\Captcha;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/captcha', function () {
    return Captcha::create();
});

Route::get('/', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('login.post');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');


Route::middleware('auth')->group(function () {
    Route::get('/scan-qr-siswa', [PresensiSiswaController::class, 'scanQrSiswa'])->name('scan.qr.siswa');
    Route::post('/presensi-siswa', [PresensiSiswaController::class, 'presensiSiswa'])->name('presensi.siswa');
    Route::get('/presensi-list-siswa', [PresensiSiswaController::class, 'presensiListSiswa'])->name('presensi.list.siswa');
});

Route::middleware('auth')->group(function () {
    Route::get('/scan-qr-guru', [PresensiGuruController::class, 'scanQrGuru'])->name('scan.qr.guru');
    Route::post('/presensi-guru', [PresensiGuruController::class, 'presensiGuru'])->name('presensi.guru');
    Route::get('/presensi-list-guru', [PresensiGuruController::class, 'presensiListGuru'])->name('presensi.list.guru');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/presensi-map', [PresensiMapController::class, 'create'])->name('presensi.create');
    Route::post('/presensi-map', [PresensiMapController::class, 'store'])->name('presensi.store');
});

// Route::get('/refresh-captcha', function() {
//     return response()->json(['captcha' => Captcha::img()]);
// });

