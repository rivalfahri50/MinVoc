<?php

use App\Http\Controllers\authController;
use Illuminate\Support\Facades\Route;

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

Route::controller(authController::class)->group(function () {
    Route::get('/', 'viewWelcome');
    Route::get('/masuk', 'viewMasuk')->name('pengguna');
    Route::get('/masuk-Admin', 'viewMasukAdmin')->name('admin');
    Route::get('/buat-akun', 'viewBuatAkun');
    Route::get('/lupa-password', 'viewLupaPassword')->name('lupaSandi');
    Route::get('/ubah-password', 'viewUbahPassword');
})->middleware('guest');
