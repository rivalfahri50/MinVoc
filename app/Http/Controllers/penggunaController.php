<?php

namespace App\Http\Controllers;

use App\Models\album;
use App\Models\artist;
use App\Models\billboard;
use App\Models\genre;
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
use Throwable;

class penggunaController extends Controller
{
    protected function index(): Response
    {
        $title = "MusiCave";
        $songs = song::all();
        $genres = genre::all();
        $playlists = playlist::all();
        $artist = artist::with('user')->get();
        $billboards = billboard::all();
        return response()->view('users.index', compact('title', 'songs', 'artist', 'genres', 'playlists', 'billboards'));
    }

    protected function pencarian(): Response
    {
        $title = "MusiCave";
        $songs = song::all();
        $artist = artist::with('user')->get();
        return response()->view('users.pencarian', compact('title', 'artist', 'songs'));
    }

    protected function playlist(): Response
    {
        $title = "MusiCave";
        $albums = album::all();
        $playlists = playlist::all();
        return response()->view('users.playlist', compact('title', 'playlists', 'albums'));
    }

    protected function riwayat(): Response
    {
        $title = "MusiCave";

        $riwayat = Riwayat::all();

        $uniqueRows = $riwayat->unique(function ($item) {
            return $item->user_id . $item->song_id . $item->play_date;
        });

        return response()->view('users.riwayat', compact('title', 'uniqueRows'));
    }

    protected function profile(): Response
    {
        $title = "MusiCave";
        return response()->view('users.profile.profile', compact('title'));
    }

    protected function profile_ubah(Request $request, string $code): Response
    {
        $title = "MusiCave";
        $user = User::where('code', $code)->get();
        return response()->view('users.profile.profile_ubah', compact('title', 'user'));
    }

    protected function album(): Response
    {
        $title = "MusiCave";
        return response()->view('users.billboard.album', compact('title'));
    }

    protected function kategori(string $code): Response
    {
        $title = "MusiCave";
        $genre = genre::where('code', $code)->first();
        $playlists = playlist::all();
        $songs = song::where('genre_id', $genre->id)->get();
        return response()->view('users.kategori.kategori', compact('title', 'genre', 'songs', 'playlists'));
    }

    protected function buatPlaylist(): Response
    {
        $title = "MusiCave";
        $songs = song::all();
        return response()->view('users.playlist.buat', compact('title', 'songs'));
    }

    protected function tambah_playlist(string $code, Request $request)
    {
        $song = song::where('code', $code)->first();
        try {
            $song->playlist_id = $request->input('playlist_id');
            $song->update();
        } catch (\Throwable $th) {
            return back();
        }
        return back();
    }

    protected function storePlaylist(Request $request)
    {
        $title = "MusiCave";
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
            $playlists = playlist::all();
        } catch (\Throwable $th) {
            return response()->view('users.playlist', compact('title'));
        }
        return response()->view('users.playlist', compact('title', 'playlists'));
    }

    protected function ubahPlaylist(Request $request, string $code)
    {
        $title = "MusiCave";
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
            return response()->view('users.playlist', compact('title'));
        }
        return response()->view('users.playlist', compact('title', 'playlists'));
    }

    protected function hapusSongPlaylist(string $code)
    {
        $song = song::where('code', $code)->first();
        try {
            $song->playlist_id = null;
            $song->save();
        } catch (\Throwable $th) {
            return redirect()->back();
        }
        return redirect()->back();
    }

    protected function search_song(Request $request)
    {
        $query = $request->input('query');
        $results = song::with('artist.user')->where('judul', 'like', '%' . $query . '%')->get();

        return response()->json(['results' => $results]);
    }

    protected function search_result(Request $request, string $code)
    {
        $title = "MusiCave";
        $song = song::where('code', $code)->first();
        $user = user::where('code', $code)->first();
        $playlists = playlist::all();

        if ($song) {
            $songs = song::all();
            return view('users.search.songSearch', compact('song', 'title', 'songs', 'playlists'));
        } else if ($user) {
            $artis = artist::where('user_id', $user->id)->first();
            $songs = song::where('artis_id', $artis->id)->get();
            return view('users.search.artisSearch', compact('user', 'title', 'songs', 'playlists'));
        }
    }

    protected function pencarian_input(Request $request)
    {
        $title = "MusiCave";
        $playlists = playlist::all();
        $song = song::where('judul', 'like', '%' .  $request->input('search') . '%')->first();
        $user = user::where('name', 'like', '%' .  $request->input('search') . '%')->first();

        if ($song) {
            $songs = song::all();
            return view('users.search.songSearch', compact('song', 'title', 'songs', 'playlists'));
        } else if ($user) {
            $artis = artist::where('user_id', $user->id)->first();
            $songs = song::where('artis_id', $artis->id)->get();
            return view('users.search.artisSearch', compact('user', 'title', 'songs', 'playlists'));
        } else {
            return "not found";
        }
    }

    protected function billboard(string $code): Response
    {
        $title = "MusiCave";
        $billboard = billboard::where('code', $code)->first();
        $albums = album::where('artis_id', $billboard->artis_id)->get();
        $songs = song::where('artis_id', $billboard->artis_id)->get();
        $playlists = playlist::all();
        return response()->view('users.billboard.billboard', compact('title', 'billboard', 'albums', 'songs', 'playlists'));
    }

    protected function detailPlaylist(string $code): Response
    {
        $title = "MusiCave";
        $playlistDetail = playlist::where('code', $code)->first();
        $songs = song::where('playlist_id', $playlistDetail->id)->get();
        $playlists = playlist::all();
        return response()->view('users.playlist.contoh', compact('title', 'playlistDetail', 'songs', 'playlists'));
    }

    protected function albumBillboard(string $code): Response
    {
        $title = "MusiCave";
        $album = album::where('code', $code)->first();
        $songs = song::where('album_id', $album->id)->get();
        $playlists = playlist::all();
        return response()->view('artis.billboard.album', compact('title', 'album', 'songs', 'playlists'));
    }

    function detailAlbum(string $code): Response
    {
        $title = "MusiCave";
        $albumDetail = album::where('code', $code)->first();
        $songs = song::all();
        $playlists = playlist::all();
        return response()->view('users.playlist.contohAlbum', compact('title', 'albumDetail', 'songs', 'playlists'));
    }

    protected function disukaiPlaylist(): Response
    {
        $title = "MusiCave";
        return response()->view('users.playlist.disukai', compact('title'));
    }

    protected function updateProfile(string $code, Request $request)
    {
        $user = User::where('code', $code)->first();
        $validate = Validator::make(
            $request->all(),
            [
                'name' => 'required|string|max:255',
                'avatar' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                // 'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
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
        try {
            User::where('code', $code)->update($value);
        } catch (Throwable $e) {
            return redirect()->back();
        }
        return redirect()->back();
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $songs = Song::where('judul', 'LIKE', '%' . $query . '%')->get();

        $artists = User::where('name', 'LIKE', '%' . $query . '%')->get();

        $results = [
            'songs' => $songs,
            'artists' => $artists,
        ];
        return response()->json(['results' => $results]);
    }

    protected function hapusPlaylist(string $code)
    {
        $playlist = Playlist::where('code', $code)->first();
        $songs = song::where('playlist_id', $playlist->id)->get();
        if (!$playlist) {
            return response()->redirectTo('pengguna/playlist');
        }

        try {
            if (Storage::disk('public')->exists($playlist->images) === 'images/defaultPlaylist.png') {
                Storage::disk('public')->delete($playlist->images);
                $playlist->delete();
            } else {
                $playlist->delete();
            }
        } catch (\Throwable $th) {
            Log::error('Error deleting playlist: ' . $th->getMessage());
            return response()->redirectTo('pengguna/playlist');
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

        // Lakukan filter data berdasarkan tanggal, bulan, dan tahun
        $filteredData = song::where('tanggal', $tanggal)
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->get();

        return response()->json(['data' => $filteredData]);
    }

    protected function logout(Request $request)
    {
        Auth::logout();
        return response()->redirectTo("/masuk");
    }
}
