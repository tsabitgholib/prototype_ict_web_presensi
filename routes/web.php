<?php

use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\AuthController;
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
    Route::get('/scan-qr', [AbsensiController::class, 'scanQR'])->name('scan.qr');
    Route::post('/absen', [AbsensiController::class, 'absen'])->name('absen');
    Route::get('/absensi', [AbsensiController::class, 'list'])->name('absensi.list');
});

Route::get('/refresh-captcha', function() {
    return response()->json(['captcha' => Captcha::img()]);
});

