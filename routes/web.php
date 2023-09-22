<?php


use App\Models\admin;
use App\Models\artist;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\authController;
use App\Http\Controllers\songController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\penggunaController;
use App\Http\Controllers\ArtistVerifiedController;
use App\Http\Controllers\LikeController;
use App\Models\aturanPembayaran;
use App\Models\notif;

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


Route::middleware(['logout.check', 'guest'])->controller(authController::class)->group(function () {
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
});
Route::get('/logout-user', [authController::class, 'logout'])->name('logout');

Route::prefix('admin')->middleware(['admin', 'auth'])->controller(AdminController::class)->group(function () {
    // Route::post('/validationSignInAdmin', 'storeSignIn')->name('storeSignIn.admin');

    Route::get('/dashboard', 'index')->name('admin.dashboard');
    Route::get('/persetujuan', 'persetujuan');
    Route::get('/kategori', 'kategori');
    Route::get('/iklan', 'iklan');
    Route::get('/riwayat', 'riwayat');
    Route::get('/verifikasi', 'verifikasi');
    Route::get('/pencairan', 'pencairan');
    Route::get('/peraturan-pencairan', 'peraturan');
    Route::get('/show', 'show');
    Route::get('/items/{code}', 'items');
    Route::get('/hapus-billboard/{code}', 'hapusBillboard')->name('hapus.billoard');
    Route::get('/hapus-music/{code}', 'hapusMusic')->name('hapus.music');
    Route::get('/hapus-genre/{code}', 'hapusGenre')->name('hapus.genre');
    Route::get('/hapus-verified/{code}', 'hapusVerified')->name('hapus.verified');
    Route::get('/setuju-music/{code}', 'setujuMusic')->name('setuju.upload.music');
    Route::get('/admin/pencairan', 'AdminController@pencairan')->name('admin.pencairan');
    Route::get('/satuju-pencairan/{code}', 'pencairanApprove')->name('setuju.pencairan');
    Route::get('/pencairan-reject/{code}', 'pencairanReject')->name('pencairan.reject');
    Route::get('/delete-notif/{code}', 'deleteNotif');
    Route::get('/list-pembayaran', 'listTipePembayaran');
    Route::get('/delete-pencairan/{code}', 'deletePencairan');

    Route::post('/setuju-verified/{code}', 'setujuVerified')->name('tambah.verified');
    Route::post('/uploadBillboard', 'buatBillboard')->name('uploadBillboard');
    Route::post('/edit-billboard/{code}', 'updatebillboard')->name('updateBillboard');
    Route::post('/genre', 'buatGenre')->name('buat.genre');
    Route::post('/edit-genre/{code}', 'editGenre')->name('edit.genre');
});

Route::post('/validationSIgnInAdmin', [AdminController::class, 'storeSignIn'])->name('storeSignIn.admin');

Route::prefix('artis')->middleware(['auth', 'artist'])->controller(ArtistController::class)->group(function () {
    Route::get('/kolaborasi', 'viewKolaborasi')->name('kolaborasi');
    Route::get('/lirik-chat/{code}', 'viewLirikAndChat')->name('lirikAndChat');
    Route::get('/show/{code}', 'showData')->name('project.show');

    Route::get('/dashboard', 'index')->name('artist.dashboard');
    Route::get('/pencarian', 'pencarian');
    Route::get('/playlist', 'playlist');
    Route::get('/penghasilan', 'penghasilan');
    Route::get('/riwayatPenghasilan', 'riwayatPenghasilan');
    Route::get('/riwayat', 'riwayat');
    Route::get('/profile/{code}', 'profile');
    Route::get('/profile-ubah/{code}', 'profile_ubah')->name('ubah.profile.artis');
    Route::get('/detail-playlist/{code}', 'detailPlaylist')->name('detailPlaylistArtis');
    Route::get('/detail-album/{code}', 'detailAlbum')->name('detailAlbumArtis');
    Route::get('/unggahAudio', 'viewUnggahAudio');
    Route::get('/billboard/{code}', 'billboard')->name('detail.billboard');
    Route::get('/album', 'album');
    Route::get('/album-billboard/{code}', 'albumBillboard')->name('albumBillboard');
    Route::get('/kategori/{code}', 'kategori');
    Route::get('/buat-playlist', 'buatPlaylist');
    Route::get('/contoh-playlist', 'contohPlaylist');
    Route::get('/disukai-playlist', 'disukaiPlaylist');
    Route::get('/search', 'search')->name('search.artis');
    Route::get('/verified', 'verified');
    Route::get('/hapus-playlist/{code}', 'hapusPlaylist')->name('hapus.playlist.artis');
    Route::get('/hapus-album/{code}', 'hapusAlbum')->name('hapus.albums.artis');
    Route::get('/search_song', 'search_song')->name('search.song.artis');
    Route::get('/search/{code}', 'search_result');
    Route::get('/hapusSongPlaylist/{code}', 'hapusSongPlaylist')->name('hapusSongPlaylist.artis');
    Route::get('/peraturan', function () {
        $notifs = notif::where('user_id', auth()->user()->id)->get();
        return view('artis.peraturan', ['title' => 'MusiCave', 'notifs' => $notifs]);
    })->name('peraturan.artis');
    Route::get('/delete-notif/{code}', 'deleteNotif');

    Route::post('/search', 'pencarian_input')->name('pencarian.artis');
    Route::post('/tambah_playlist/{code}', 'tambah_playlist')->name('tambah.playlist.artis');
    Route::POST('/buat-album/{code}', 'buatAlbum')->name('tambah.album.artis');
    Route::POST('/verified/{code}', 'verifiedAccount')->name('verified');
    Route::post('/create-lirik', 'Project')->name('create.project.artis');
    Route::post('/message', 'message')->name('message.project');
    Route::post('/reject-project', 'rejectProject')->name('reject.project.artis');
    Route::post('/buat-playlist', 'storePlaylist')->name('buat.playlist.artis');
    Route::post('/ubah-playlist/{code}', 'ubahPlaylist')->name('ubah.playlist.artis');
    Route::post('/ubah-album/{code}', 'ubahAlbum')->name('ubah.album.artis');
    Route::post('/update/profile/{code}', 'updateProfile')->name('update.profile.artis');
    Route::post('/unggahAudio', 'unggahAudio')->name('unggah.artis');
    // Route::post('/filter', 'filter')->name('filter');
});

Route::prefix('artis-verified')->middleware(['auth', 'artistVerified'])->controller(ArtistVerifiedController::class)->group(function () {
    Route::get('/kolaborasi', 'viewKolaborasi')->name('artist-verified.kolaborasi');
    Route::get('/lirik-chat/{code}', 'viewLirikAndChat')->name('lirikAndChat.artisVerified');
    Route::get('/show/{code}', 'showData')->name('project.show.artisVerified');
    Route::get('/artis-kolaborasi', 'artisSelect');

    Route::get('/dashboard', 'index')->name('artist-verified.dashboard');
    Route::get('/detail-playlist/{code}', 'detailPlaylist')->name('detailPlaylistArtisVerified');
    Route::get('/detail-album/{code}', 'detailAlbum')->name('detailAlbumArtisVerified');
    Route::get('/unggahAudio', 'viewUnggahAudio');
    Route::get('/kategori/{code}', 'kategori');
    Route::get('/playlist', 'playlist');
    Route::get('/penghasilan', 'penghasilan');
    Route::get('/riwayatPenghasilan', 'riwayatPenghasilan');
    Route::get('/riwayat', 'riwayat');
    Route::get('/profile/{code}', 'profile');
    Route::get('/profile-ubah/{code}', 'profile_ubah')->name('ubah.profile.artisVerified');
    Route::get('/billboard/{code}', 'billboard')->name('detail.billboard.artisVerified');
    Route::get('/album', 'album');
    Route::get('/album-billboard/{code}', 'albumBillboard')->name('albumBillboard.artisVerified');
    Route::get('/kategori/{code}', 'kategori');
    Route::get('/search', 'search')->name('search.artisVerified');
    Route::get('/buat-playlist', 'buatPlaylist');
    Route::get('/contoh-playlist', 'contohPlaylist');
    Route::get('/disukai-playlist', 'disukaiPlaylist');
    Route::get('/hapus-playlist/{code}', 'hapusPlaylist')->name('hapus.playlist.artisVerified');
    Route::get('/hapus-album/{code}', 'hapusAlbum')->name('hapus.albums.artisVerified');
    Route::get('/hapusSongPlaylist/{code}', 'hapusSongPlaylist')->name('hapusSongPlaylist.artisVerified');
    Route::get('/search_song', 'search_song')->name('search.song.artisVerified');
    Route::get('/search/{code}', 'search_result');
    Route::get('/peraturan', function () {
        $notifs = notif::where('user_id', auth()->user()->id)->get();
        return view('artisVerified.peraturan', ['title' => 'MusiCave', 'notifs' => $notifs]);
    })->name('peraturan.artisVerified');
    Route::get('/delete-notif/{code}', 'deleteNotif');
    Route::get('/pencairan/{code}', 'pencairan');
    Route::get('/filter', 'filterDate')->name('filter.date');
    Route::get('/filter-pencairan', 'filterDatePencairan')->name('filter.date.pencairan');

    Route::post('/pencairan/{code}', 'pencairanDana')->name('pencairan.artiVerified');
    Route::post('/undangColab/{code}', 'undangColab')->name('undangColab');
    Route::post('/bayar/{code}', 'bayar')->name('bayar');
    Route::post('/search', 'pencarian_input')->name('pencarian.artisVerified');
    Route::post('/tambah_playlist/{code}', 'tambah_playlist')->name('tambah.playlist.artisVerified');
    Route::post('/project', 'createProject')->name('createProject.artisVerified');
    Route::post('/unggahAudio', 'unggahAudio')->name('unggah.artisVerified');
    Route::post('/buat-album/{code}', 'buatAlbum')->name('tambah.album.artisVerified');
    Route::post('/buat-playlist', 'storePlaylist')->name('buat.playlist.artisVerified');
    Route::post('/ubah-playlist/{code}', 'ubahPlaylist')->name('ubah.playlist.artisVerified');
    Route::post('/update/profile/{code}', 'updateProfile')->name('update.profile.artisVerified');
    Route::post('/create-project/{code}', 'Project')->name('create.project.artisVerified');
    Route::post('/message/{code}', 'message')->name('message.project.artisVerified');
    Route::post('/reject-project', 'rejectProject')->name('reject.project.artisVerified');
    Route::post('/ubah-album/{code}', 'ubahAlbum')->name('ubah.album.artisVerified');
    Route::post('/update/profile/{code}', 'updateProfile')->name('update.profile.artisVerified');
    // Route::post('/unggahAudio', 'unggahAudio')->name('unggah.artisVerified');
});

Route::prefix('pengguna')->middleware(['auth', 'pengguna'])->controller(penggunaController::class)->group(function () {
    Route::get('/dashboard', 'index')->name('user.dashboard');
    Route::get('/pencarian', 'pencarian');
    Route::get('/playlist', 'playlist');
    Route::get('/riwayat', 'riwayat');
    Route::get('/profile/{code}', 'profile');
    Route::get('/artis-search', 'searchArtis');
    Route::get('/song-search', 'searchSong');
    Route::get('/profile-ubah/{code}', 'profile_ubah')->name('ubah.profile');
    Route::get('/billboard/{code}', 'billboard')->name('detail.billboard.pengguna');
    Route::get('/album', 'album');
    Route::get('/album-billboard/{code}', 'albumBillboard')->name('albumBillboard.pengguna');
    Route::get('/kategori/{code}', 'kategori');
    Route::get('/buat-playlist', 'buatPlaylist');
    Route::get('/detail-playlist/{code}', 'detailPlaylist')->name('detailPlaylist');
    Route::get('/detail-album/{code}', 'detailAlbum')->name('detailAlbumPengguna');
    Route::get('/disukai-playlist', 'disukaiPlaylist');
    Route::get('/search', 'search')->name('search');
    Route::get('/toggle-like', 'like')->name('toggle-like');
    Route::get('/hapus-playlist/{code}', 'hapusPlaylist')->name('hapus.playlist.user');
    Route::get('/search_song', 'search_song')->name('search.song.pengguna');
    Route::get('/search/{code}', 'search_result');
    Route::get('/hapusSongPlaylist/{code}', 'hapusSongPlaylist')->name('hapusSongPlaylist');
    Route::get('/peraturan', function () {
        $notifs = notif::where('user_id', auth()->user()->id)->get();
        return view('users.peraturan', ['title' => 'MusiCave', 'notifs' => $notifs]);
    })->name('peraturan.pengguna');
    Route::get('/delete-notif/{code}', 'deleteNotif');

    Route::post('/search', 'pencarian_input')->name('pencarian');
    Route::post('/tambah_playlist/{code}', 'tambah_playlist')->name('tambah.playlist');
    Route::post('/update/profile/{code}', 'updateProfile')->name('update.profile');
    Route::post('/buat-playlist', 'storePlaylist')->name('buat.playlist');
    Route::post('/ubah-playlist/{code}', 'ubahPlaylist')->name('ubah.playlist');
    Route::post('/filter', 'filter')->name('filter');
});

Route::controller(SongController::class)->group(function () {
    Route::post('/song/{song}/like', 'toggleLike');
    Route::get('/song/check', 'cekLike');
    Route::get('/ambil-lagu', 'ambillagu');
    Route::post('/update-play-count/{song_id}', 'playCount');
});

Route::post('/peraturan-pembayaran', [AdminController::class, 'peraturanPembayaran'])->name('peraturan');
Route::post('/update-peraturan-pembayaran/{code}', [AdminController::class, 'updatePeraturanPembayaran'])->name('update.pendapatan');

Route::controller(LikeController::class)->group(function () {
    Route::post('/artist/{artist}/like', 'likeArtist');
    Route::get('/artist/check', 'likeCheck');
    Route::get('/artist/count', 'likeCount');
});

Route::post('/simpan-riwayat', [RiwayatController::class, 'simpanRiwayat']);
Route::post('/hitung/penghasilan', [RiwayatController::class, 'penghasilanArtist']);
Route::get('/nominal', function () {
    $pendapatan = aturanPembayaran::where('opsi_id', 3)->first();
    $uang = isset($pendapatan->pendapatanArtis) != null ? $pendapatan->pendapatanArtis : 20000;
    return response()->json(['nominal' => $uang]);
});

Route::get('/kebijakan-privasi', function () {
    return view('auth.kebijakanprivasi');
});
Route::post('/simpan-penghasilan', [penggunaController::class, 'simpanPenghasilan']);
