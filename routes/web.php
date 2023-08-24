<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\ArtistVerifiedController;
use App\Http\Controllers\authController;
use App\Models\admin;
use App\Models\artist;
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

Route::prefix('admin')->middleware('admin')->controller(AdminController::class)->group(function () {
    // Route::post('/validationSignInAdmin', 'storeSignIn')->name('storeSignIn.admin');
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    });
    Route::post('/project', 'createProject')->name('createProject.admin');
});

Route::post('/validationSIgnInAdmin', [AdminController::class, 'storeSignIn'])->name('storeSignIn.admin');

Route::prefix('artis')->middleware(['auth', 'artist'])->controller(ArtistController::class)->group(function () {
    Route::get('/dashboard', 'viewDashboard');
    Route::get('/kolaborasi', 'viewKolaborasi')->name('kolaborasi');
    Route::get('/lirik-chat/{code}', 'viewLirikAndChat')->name('lirikAndChat');
    Route::get('/show/{code}', 'showData')->name('project.show');
    Route::get('/logout', 'logout')->name('logout.artis');

    // create lirik in colaboryti
    Route::post('/create-lirik', 'Project')->name('create.project');
    Route::post('/message', 'message')->name('message.project');
    Route::post('/reject-project', 'rejectProject')->name('reject.project');
});

Route::prefix('artis-verified')->middleware(['auth', 'artistVerified'])->controller(ArtistVerifiedController::class)->group(function () {
    Route::get('/dashboard', 'viewDashboard');
});

// unggah audio
// Route::get('/unggahAudio', 'viewUnggahAudio');
// Route::post('/unggahAudio', 'unggahAudio')->name('unggah');
// gawe ngetest tampilan web


Route::prefix('pengguna')->middleware(['auth', 'pengguna'])->group(function () {
    Route::get('/dashboard', function () {
        return view('users.dashboard');
    });
});
