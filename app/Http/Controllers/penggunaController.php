<?php

namespace App\Http\Controllers;

use App\Models\album;
use App\Models\artist;
use App\Models\billboard;
use App\Models\genre;
use App\Models\Like;
use App\Models\notif;
use App\Models\playlist;
use App\Models\Riwayat;
use App\Models\song;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Mockery\Undefined;
use RealRashid\SweetAlert\Facades\Alert;
use Throwable;

class penggunaController extends Controller
{
    protected function index(Request $request): Response
    {
        try {
            $song = song::where('didengar', '>', '1000')->orderByDesc('didengar')->get();
            $songs = song::where('is_approved', true)->get();
            $genres = genre::all();
            $playlists = playlist::all();
            $artist = artist::with('user')->get();
            $billboards = billboard::all();
        } catch (\Throwable $th) {
            return abort(404);
        }
        return response()->view('users.index', compact('songs', 'song', 'artist', 'genres', 'playlists', 'billboards'));
    }

    protected function pencarian(): Response
    {

        try {
            $songs = song::where('is_approved', true)->get();
            $artist = artist::with('user')->get();
        } catch (\Throwable $th) {
            return abort(404);
        }
        return response()->view('users.pencarian', compact('artist', 'songs'));
    }

    protected function playlist(): Response
    {

        try {
            $albums = album::with('artis')->get();
            $playlists = playlist::all();
        } catch (\Throwable $th) {
            return abort(404);
        }
        return response()->view('users.playlist', compact('playlists', 'albums'));
    }

    protected function riwayat(): Response
    {

        try {
            $riwayat = Riwayat::all();
            $uniqueRows = $riwayat->unique(function ($item) {
                return $item->user_id . $item->song_id . $item->play_date;
            });
        } catch (\Throwable $th) {
            return abort(404);
        }

        return response()->view('users.riwayat', compact('uniqueRows'));
    }

    protected function profile(string $code)
    {
        $user = User::where('id', $code)->first();
        return response()->json(['user' => $user]);
    }

    protected function profile_ubah(Request $request, string $code): Response
    {

        try {
            $user = User::where('code', $code)->get();
            $notifs = notif::with('user.artist.song')->where('user_id', auth()->user()->id)->get();
        } catch (\Throwable $th) {
            return abort(404);
        }
        return response()->view('users.profile.profile_ubah', compact('user'));
    }

    protected function album(): Response
    {
        try {
            $album_id = song::where('is_approved', true)->where('album_id');
            $notifs = notif::with('user.artist.song')->where('user_id', auth()->user()->id)->get();
        } catch (\Throwable $th) {
            return abort(404);
        }
        return response()->view('users.billboard.album', compact('album_id'));
    }

    protected function kategori(string $code): Response
    {


        try {
            $genre = genre::where('code', $code)->first();
            if (!$genre) {
                abort(404);
            }
            $genre_id = $genre->id;
            $playlists = playlist::all();
            $songs = song::where('is_approved', true)->where('genre_id', $genre->id)->get();
            $notifs = notif::with('user.artist.song')->where('user_id', auth()->user()->id)->get();
        } catch (\Throwable $th) {
            abort(404);
        }
        return response()->view('users.kategori.kategori', compact('genre', 'songs', 'playlists', 'genre_id'));
    }

    protected function buatPlaylist(): Response
    {

        try {
            $songs = song::where('is_approved', true)->get();
        } catch (\Throwable $th) {
            return abort(404);
        }
        return response()->view('users.playlist.buat', compact('songs'));
    }

    protected function tambah_playlist(string $code, Request $request)
    {
        $song = song::where('is_approved', true)->where('code', $code)->first();
        try {
            $song->playlist_id = $request->input('playlist_id');
            $song->update();
        } catch (\Throwable $th) {
            return abort(404);
        }
        return redirect()->back();
    }

    protected function storePlaylist(Request $request)
    {
        try {
            if (!$request->file()) {
                $values =
                    [
                        'code' => Str::uuid(),
                        'name' => $request->input('name') == null ? "Playlist Lagu" : $request->input('name'),
                        'deskripsi' => $request->input('deskripsi') == null ? "none" : $request->input('deskripsi'),
                        'images' => 'images/defaultPlaylist.png',
                        'user_id' => Auth::user()->id
                    ];
            } else if ($existImage = $request->file('images')->store('images', 'public')) {
                $values =
                    [
                        'code' => Str::uuid(),
                        'name' => $request->input('name') == null ? "Playlist Lagu" : $request->input('name'),
                        'deskripsi' => $request->input('deskripsi') == null ? "none" : $request->input('deskripsi'),
                        'images' => $existImage,
                        'user_id' => Auth::user()->id
                    ];
            }
            playlist::create($values);
        } catch (\Throwable $th) {
            return abort(404);
        }
        return redirect()->back();
    }

    protected function ubahPlaylist(Request $request, string $code)
    {
        $playlists = playlist::where('code', $code)->first();
        try {
            if (!$request->file()) {
                $values =
                    [
                        'code' => $code,
                        'name' => $request->input('name') == null ? $playlists->name : $request->input('name'),
                        'deskripsi' => $request->input('deskripsi') == null ? $playlists->deskripsi : $request->input('deskripsi'),
                        'images' => $playlists->images,
                        'user_id' => $playlists->user_id
                    ];
            } else if ($existImage = $request->file('images')->store('images', 'public')) {
                if (Storage::disk('public')->exists($playlists->images)) {
                    Storage::disk('public')->delete($playlists->images);
                }
                $values =
                    [
                        'code' => $code,
                        'name' => $request->input('name') == null ? $playlists->name : $request->input('name'),
                        'deskripsi' => $request->input('deskripsi') == null ? $playlists->deskripsi : $request->input('deskripsi'),
                        'images' => $existImage,
                        'user_id' => $playlists->user_id
                    ];
            }
            playlist::where('code', $code)->update($values);
            $playlists = playlist::all();
        } catch (\Throwable $th) {
            return abort(404);
        }
        return redirect()->back();
    }

    protected function hapusSongPlaylist(string $code)
    {
        $song = song::where('code', $code)->first();
        try {
            $song->playlist_id = null;
            $song->save();
        } catch (\Throwable $th) {
            return abort(404);
        }
        return redirect()->back();
    }

    protected function search_song(Request $request, string $code)
    {
        $query = $request->input('query');
        $playlist = playlist::where('code', $code)->first();
        $results = song::with('artist.user')->where('is_approved', true)->where('playlist_id', $playlist->id)->where('judul', 'like', '%' . $query . '%')->get();

        return response()->json(['results' => $results]);
    }

    protected function search_result(Request $request, string $code)
    {

        try {
            $playlists = playlist::all();
            $user = user::where('is_approved', true)->where('code', 'like', '%' .  $code . '%')->first();
            $song = song::where('is_approved', true)->where('code', 'like', '%' .  $code . '%')->first();
            $totalDidengar = DB::table('riwayat')->where('user_id', auth()->user()->id)->sum('song_id');
            $notifs = notif::with('user.artist.song')->where('user_id', auth()->user()->id)->get();

            if ($song) {
                $songs = song::where('is_approved', true)->get();
                $notifs = notif::with('user.artist.song')->where('user_id', auth()->user()->id)->get();
                return view('users.search.songSearch', compact('song', 'songs', 'playlists'));
            } else if ($user) {
                $artis = artist::where('user_id', $user->id)->first();
                $artis_id = $artis->id;
                $songs = song::where('is_approved', true)->where('artis_id', $artis->id)->get();
                $notifs = notif::with('user.artist.song')->where('user_id', auth()->user()->id)->get();
                return view('users.search.artisSearch', compact('user', 'artis_id', 'songs', 'playlists', 'totalDidengar'));
            } else {
                return response()->view('users.searchNotFound');
            }
        } catch (\Throwable $th) {
            return abort(404);
        }
    }

    protected function pencarian_input(Request $request)
    {
        try {
            $playlists = playlist::all();
            $song = song::where('is_approved', true)->where('judul', 'like', '%' .  $request->input('search') . '%')->first();
            $user = user::where('is_approved', true)->where('name', 'like', '%' .  $request->input('search') . '%')->first();
            $totalDidengar = DB::table('riwayat')->where('user_id', auth()->user()->id)->sum('song_id');
            $notifs = notif::with('user.artist.song')->where('user_id', auth()->user()->id)->get();
            $search = $request->search;
            if ($song) {
                $songs = song::where('is_approved', true)->get();
                return view('users.search.songSearch', compact('song', 'search', 'songs', 'playlists'));
            } else if ($user) {
                $artis = artist::where('user_id', $user->id)->first();
                $artis_id = $artis->id;
                $songs = song::where('is_approved', true)->where('artis_id', $artis->id)->get();
                return view('users.search.artisSearch', compact('user', 'search', 'artis_id', 'songs', 'playlists', 'totalDidengar'));
            } else {
                return response()->view('users.searchNotFound', compact('search'));
            }
        } catch (\Throwable $th) {
            return abort(404);
        }
    }

    protected function billboard(string $code): Response
    {

        try {
            $billboard = billboard::where('code', $code)->first();
            $artis_id = $billboard->artis_id;
            $albums = album::where('artis_id', $billboard->artis_id)->get();
            $songs = song::where('is_approved', true)->where('artis_id', $billboard->artis_id)->get();
            $playlists = playlist::all();
        } catch (Throwable) {
            return abort(404);
        }
        return response()->view('users.billboard.billboard', compact('billboard', 'artis_id', 'albums', 'songs', 'playlists'));
    }

    protected function detailPlaylist(string $code): Response
    {
        try {
            $playlistDetail = playlist::with('user')->where('code', $code)->first();
            $playlist_id = $playlistDetail->id;
            $songs = song::where('is_approved', true)->where('playlist_id', $playlistDetail->id)->get();
            $playlists = playlist::all();
        } catch (\Throwable $th) {
            return abort(404);
        }
        return response()->view('users.playlist.contoh', compact('playlist_id', 'playlistDetail', 'songs', 'playlists'));
    }

    protected function albumBillboard(string $code): Response
    {
        try {

            $album = album::where('code', $code)->first();
            $album_id = $album->id;
            $songs = song::where('is_approved', true)->where('album_id', $album->id)->get();
            $playlists = playlist::all();
        } catch (\Throwable $th) {
            return abort(404);
        }
        return response()->view('users.billboard.album', compact('album_id', 'album', 'songs', 'playlists'));
    }

    function detailAlbum(string $code): Response
    {
        try {
            $albumDetail = album::where('code', $code)->first();
            $songs = song::where('is_approved', true)->where('album_id', $albumDetail->id)->get();
            $album_id = $albumDetail->id;
            $songs = song::where('is_approved', true)->get();
            $playlists = playlist::all();
        } catch (\Throwable $th) {
            return abort(404);
        }
        return response()->view('users.playlist.contohAlbum', compact('album_id', 'albumDetail', 'songs', 'playlists'));
    }

    protected function disukaiPlaylist(): Response
    {
        try {
            $songId = Like::where('user_id', Auth::user()->id)->pluck('song_id')->toArray();
            $song = song::where('is_approved', true)->whereIn('id', $songId)->get();
            $notifs = notif::with('user.artist.song')->where('user_id', auth()->user()->id)->get();
            $playlists = playlist::all();
            $songs = song::where('is_approved', true)->get();
        } catch (\Throwable $th) {
            return abort(404);
        }
        return response()->view('users.playlist.disukai', compact('song', 'playlists', 'songs'));
    }

    protected function updateProfile(string $code, Request $request)
    {
        $user = User::where('code', $code)->first();
        $validate = Validator::make(
            $request->all(),
            [
                'name' => 'required|string|max:255',
                'avatar' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                'email' => [
                    'required',
                    'string',
                    'email',
                    'max:255',
                    Rule::unique('users')->ignore($user->id),
                ],
                'deskripsi' => 'max:500',
            ],
            [
                'name' => [
                    'required' => 'Nama harus diisi.',
                    'string' => 'Nama harus berupa teks.',
                    'max' => 'Nama tidak boleh lebih dari :max karakter.',
                ],
                'avatar' => [
                    'image' => 'Avatar harus berupa gambar.',
                    'mimes' => 'Avatar harus dalam format: :values.',
                    'max' => 'Avatar tidak boleh lebih dari :max KB.',
                ],
                'email' => [
                    'required' => 'Email harus diisi.',
                    'string' => 'Email harus berupa teks.',
                    'email' => 'Format email tidak valid.',
                    'max' => 'Email tidak boleh lebih dari :max karakter.',
                    'unique' => 'Email sudah terdaftar.',
                ],
                'deskripsi' => [
                    'max' => 'Deskripsi tidak boleh lebih dari :max karakter.',
                ],
            ]
        );

        if ($validate->fails()) {
            return redirect()->back()
                ->withErrors($validate)
                ->withInput();
        }

        try {
            $existingPhotoPath = $user->avatar;

            if ($request->hasFile('avatar') && $request->file('avatar')) {
                if ($validate->fails()) {
                    return redirect()->back()
                        ->withErrors($validate)
                        ->withInput();
                }

                if (Storage::disk('public')->exists($existingPhotoPath) == "images/default.png") {
                    $newImage = $request->file('avatar')->store('images', 'public');
                } else if (Storage::disk('public')->exists($existingPhotoPath)) {
                    Storage::disk('public')->delete($existingPhotoPath);
                    $newImage = $request->file('avatar')->store('images', 'public');
                }

                if ($request->input('deskripsi') === "none" || $request->input('deskripsi') === null) {
                    $value = [
                        'code' => $code,
                        'name' => $request->input('name'),
                        'email' => $request->input('email'),
                        'deskripsi' => "none",
                        'avatar' => $newImage,
                        'password' => $user->password,
                        'role_id' => $user->role_id,
                    ];
                } else {
                    $value = [
                        'code' => $code,
                        'name' => $request->input('name'),
                        'email' => $request->input('email'),
                        'deskripsi' => $request->input('deskripsi'),
                        'avatar' => $newImage,
                        'password' => $user->password,
                        'role_id' => $user->role_id,
                    ];
                }
            } else {
                if ($request->input('deskripsi') === "none" || $request->input('deskripsi') === null) {
                    $value = [
                        'code' => $code,
                        'name' => $request->input('name'),
                        'email' => $request->input('email'),
                        'deskripsi' => "none",
                        'password' => $user->password,
                        'role_id' => $user->role_id,
                    ];
                } else {
                    $value = [
                        'code' => $code,
                        'name' => $request->input('name'),
                        'email' => $request->input('email'),
                        'deskripsi' => $request->input('deskripsi'),
                        'password' => $user->password,
                        'role_id' => $user->role_id,
                    ];
                }
            }
            User::where('code', $code)->update($value);
        } catch (Throwable $e) {
            Alert::error('message', 'Profile gagal di perbarui');
            return redirect()->back();
        }
        Alert::success('message', 'Profile berhasil di perbarui');
        return redirect()->back();
    }

    protected function detailArtis(Request $request, string $code)
    {
        $title = 'MusiCave';
        try {
            $artis = artist::where('code', $code)->first();
            $user = User::where('id', $artis->user_id)->first();
            $songs = song::where('is_approved', true)->where('artis_id', $artis->id)->get();
            $notifs = notif::with('user.artist.song')->where('user_id', auth()->user()->id)->get();
            $totalDidengar = DB::table('riwayat')->where('user_id', auth()->user()->id)->sum('song_id');
            $artis_id = $artis->id;
            $playlists = playlist::all();
        } catch (\Throwable $th) {
            abort(404);
        }
        return view('users.search.artisSearch', compact('user', 'songs', 'playlists', 'totalDidengar', 'artis_id'));
    }

    protected function deleteNotif(Request $request, string $code)
    {
        try {
            $notif = notif::where('id', $code)->first();
            $notif->delete();
        } catch (\Throwable $th) {
            abort(404);
        }
        return redirect()->back();
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $songs = Song::where('is_approved', true)->where('judul', 'LIKE', '%' . $query . '%')->get();

        $users = User::where('name', 'LIKE', '%' . $query . '%')
            ->where('role_id', '!=', 3)
            ->where('role_id', '!=', 4)
            ->get();

        try {
            $results = [
                'songs' => $songs,
                'artists' => $users,
            ];
        } catch (\Throwable $th) {
            return abort(404);
        }
        return response()->json(['results' => $results]);
    }

    protected function hapusPlaylist(string $code)
    {
        $playlist = Playlist::where('code', $code)->first();
        $songs = song::where('is_approved', true)->where('playlist_id', $playlist->id)->get();
        if (!$playlist) {
            return response()->redirectTo('pengguna/playlist');
        }

        try {
            foreach ($songs as $key) {
                $key->playlist_id = null;
                $key->update();
            }
            if (Storage::disk('public')->exists($playlist->images) === 'images/defaultPlaylist.png') {
                Storage::disk('public')->delete($playlist->images);
                $playlist->delete();
            } else {
                $playlist->delete();
            }
        } catch (\Throwable $th) {
            return abort(404);
        }

        return response()->redirectTo('pengguna/playlist');
    }

    protected function like(Request $request)
    {
        return response()->json(['liked' => true]);
    }

    protected function filter(Request $request)
    {
        $tanggal = $request->input('tanggal');
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');

        try {
            $filteredData = song::where('is_approved', true)->where('tanggal', $tanggal)
                ->where('bulan', $bulan)
                ->where('tahun', $tahun)
                ->get();
        } catch (\Throwable $th) {
            return abort(404);
        }
        return response()->json(['data' => $filteredData]);
    }
}
