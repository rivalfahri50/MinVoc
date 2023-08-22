<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ArtistVerifiedController;
use App\Http\Controllers\authController;
use App\Models\admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

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
    Route::get('/', 'viewWelcome')->name('masuk');
    Route::get('/masuk', 'viewMasuk')->name('pengguna');
    Route::get('/masuk-Admin', 'viewMasukAdmin')->name('admin');
    Route::get('/buat-akun', 'viewBuatAkun');
    Route::get('/lupa-password', 'viewLupaPassword')->name('lupaSandi');

    // operations datas
    Route::post('/validationSignIn', 'storeSignIn')->name('storeSignIn');
    Route::post('/validationSignUp', 'storeSignUp')->name('storeSignUp');

    // ubah password
    Route::get('/reset-password/{token}', 'resetPasswordToken')->name('password.reset');
    Route::post('/reset-password', 'resetPassword')->name('password.email');
    Route::post('/ubah-password', 'ubahPassword')->name('password.update');
})->middleware('guest');



Route::controller(AdminController::class)->group(function () {
    // validation admin signIn
    Route::post('/validationSignInAdmin', 'storeSignIn')->name('storeSignIn.admin');

    Route::prefix('admin')->middleware(['auth:admin', 'admin'])->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        });
    });
})->middleware('guest');

Route::prefix('artis')->middleware(['auth', 'artist'])->group(function () {
    Route::get('/dashboard', function () {
        return view('artis.dashboard');
    });
});


Route::prefix('artis-verified')->middleware(['auth', 'artistVerified'])->controller(ArtistVerifiedController::class)->group(function () {
    Route::get('/dashboard', 'viewDashboard');
});
    // unggah audio
    // Route::get('/unggahAudio', 'viewUnggahAudio');
    // Route::post('/unggahAudio', 'unggahAudio')->name('unggah');
// gawe ngetest tampilan web
Route::get('/dashboard', function () {
             return view('artis.dashboard');
         });
Route::get('/kolaborasi', function () {
             return view('artis.kolaborasi');
         })->name('kolaborasi');
Route::get('/kolaborasi2', function () {
             return view('artis.kolaborasi2');
         })->name('kolaborasi2');
// yoooooo

Route::prefix('artis-verified')->middleware(['auth', 'artistVerified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('artisVerified.dashboard');
    });

});

Route::prefix('pengguna')->middleware(['auth', 'pengguna'])->group(function () {
    Route::get('/dashboard', function () {
        return view('users.dashboard');
    });
});
