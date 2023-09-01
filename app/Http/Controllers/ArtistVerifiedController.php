<?php

namespace App\Http\Controllers;

use App\Models\artist;
use App\Models\genre;
use App\Models\playlist;
use App\Models\song;
use App\Models\User;
use getID3;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Throwable;

class ArtistVerifiedController extends Controller
{
    protected function index(): Response
    {
        $title = "MusiCave";
        $songs = song::all();
        $genres = genre::all();
        $artist = artist::with('user')->get();
        return response()->view('artisVerified.dashboard', compact('title', 'genres', 'artist', 'songs'));
    }

    protected function pencarian(): Response
    {
        $title = "MusiCave";
        return response()->view('artisVerified.pencarian', compact('title'));
    }

    protected function playlist(): Response
    {
        $title = "MusiCave";
        $playlists = playlist::all();
        return response()->view('artisVerified.playlist', compact('title', 'playlists'));
    }

    protected function riwayat(): Response
    {
        $title = "MusiCave";
        return response()->view('artisVerified.riwayat', compact('title'));
    }

    protected function profile(): Response
    {
        $title = "MusiCave";
        return response()->view('artisVerified.profile.profile', compact('title'));
    }

    protected function profile_ubah(string $code): Response
    {
        $title = "MusiCave";
        $user = User::where('code', $code)->get();
        return response()->view('artisVerified.profile.profile_ubah', compact('title', 'user'));
    }

    protected function billboard(): Response
    {
        $title = "MusiCave";
        return response()->view('artisVerified.billboard.billboard', compact('title'));
    }

    protected function album(): Response
    {
        $title = "MusiCave";
        return response()->view('artisVerified.billboard.album', compact('title'));
    }

    protected function kategori(string $code): Response
    {
        $title = "MusiCave";
        $genre = genre::where('code', $code)->first();
        return response()->view('artisVerified.kategori.kategori', compact('title', 'genre'));
    }

    protected function buatPlaylist(): Response
    {
        $title = "MusiCave";
        $songs = song::all();
        return response()->view('artisVerified.playlist.buat', compact('title', 'songs'));
    }

    protected function contohPlaylist(): Response
    {
        $title = "MusiCave";
        return response()->view('artisVerified.playlist.contoh', compact('title'));
    }

    protected function disukaiPlaylist(): Response
    {
        $title = "MusiCave";
        return response()->view('artisVerified.playlist.disukai', compact('title'));
    }

    protected function viewUnggahAudio(Request $request): Response
    {
        $title = "Unggah Audio";
        $datas = song::with('artist')->get();
        $genres = genre::all();
        return response()->view('artisVerified.unggahAudio', compact('title', 'datas', 'genres'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $results = User::where('name', 'LIKE', '%' . $query . '%')->get();
        return response()->json(['results' => $results]);
    }

    protected function storePlaylist(Request $request): Response
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
            return response()->view('artisVerified.playlist', compact('title'));
        }
        return response()->view('artisVerified.playlist', compact('title', 'playlists'));
    }

    protected function hapusPlaylist(string $code)
    {
        $playlist = Playlist::where('code', $code)->first();

        if (!$playlist) {
            return response()->redirectTo('artis-verified/playlist');
        }

        try {
            if (Storage::disk('public')->exists($playlist->images)) {
                Storage::disk('public')->delete($playlist->images);
            }
            $playlist->delete();
        } catch (\Throwable $th) {
            Log::error('Error deleting playlist: ' . $th->getMessage());
            return response()->redirectTo('artis-verified/playlist');
        }

        return response()->redirectTo('artis-verified/playlist');
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
            return response()->view('artisVerified.playlist', compact('title'));
        }
        return response()->view('artisVerified.playlist', compact('title', 'playlists'));
    }

    protected function detailPlaylist(string $code): Response
    {
        $playlistDetail = playlist::where('code', $code)->first();
        $songs = song::all();
        $title = "MusiCave";
        return response()->view('artisVerified.playlist.contoh', compact('title', 'playlistDetail', 'songs'));
    }

    protected function unggahAudio(Request $request)
    {
        $validate = Validator::make($request->only('image', 'judul', 'audio', 'genre'), [
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'judul' => 'required|string|max:255',
            'audio' => 'required|mimetypes:audio/mpeg,audio/wav|max:20480',
            'genre' => 'required|string|max:255',
        ], [
            'image' => [
                'image' => 'File :attribute harus berupa gambar.',
                'mimes' => 'File :attribute harus berupa file gambar dengan tipe: :values.',
                'max' => 'File :attribute tidak boleh lebih dari :max kilobita.',
            ],
            'judul' => [
                'required' => 'Kolom :attribute harus diisi.',
                'string' => 'Kolom :attribute harus berupa teks.',
                'max' => 'Kolom :attribute tidak boleh lebih dari :max karakter.',
            ],
            'audio' => [
                'required' => 'Kolom :attribute harus diisi.',
                'mimetypes' => 'File :attribute harus berupa file audio dengan tipe: :values.',
                'max' => 'File :attribute tidak boleh lebih dari :max kilobita.',
            ],
            'genre' => [
                'required' => 'Kolom :attribute harus diisi.',
                'string' => 'Kolom :attribute harus berupa teks.',
                'max' => 'Kolom :attribute tidak boleh lebih dari :max karakter.',
            ],
        ]);


        if ($validate->fails()) {
            return redirect()->back()
                ->withErrors($validate)
                ->withInput();
        }

        $code = Str::uuid();

        if ($request->file('image') && $request->file('audio')) {
            try {
                DB::beginTransaction();
                $code = Str::uuid();
                $image = $request->file('image')->store('images', 'public');
                $audio = $request->file('audio')->store('musics', 'public');
                $getID3 = new getID3();

                // Analyze the audio file
                $audioInfo = $getID3->analyze($request->file('audio')->path());
                $durationInSeconds = $audioInfo['playtime_seconds'];
                $durationMinutes = floor($durationInSeconds / 60);
                $durationSeconds = $durationInSeconds % 60;
                $formattedDuration = sprintf('%02d:%02d', $durationMinutes, $durationSeconds);

                song::create([
                    'code' => $code,
                    'judul' => $request->input('judul'),
                    'genre' => $request->input('genre'),
                    'audio' => $audio,
                    'image' => $image,
                    'waktu' => $formattedDuration,
                    'artist_id' => Auth::user()->id,
                    'is_approved' => false,
                ]);
                DB::commit();

                return redirect('/artis-verified/unggahAudio')->with('success', 'Song uploaded successfully.');
            } catch (\Throwable $e) {
                DB::rollBack();
                Log::error('Error uploading song: ' . $e->getMessage());
                return redirect('/artis-verified/unggahAudio')->with('error', 'Failed to upload song.');
            }
        }

        return response()->redirectTo('/artis-verified/unggahAudio')->with('success', 'User created successfully.');
    }

    protected function updateProfile(string $code, Request $request)
    {
        $validate = Validator::make(
            $request->all(),
            [
                'name' => 'required|string|max:255',
                'avatar' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                'email' => 'required|string|email|max:255',
                'deskripsi' =>  'max:255',
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


        $user = User::where('code', $code)->first();
        $existingPhotoPath = $user->avatar;

        if ($request->hasFile('avatar') && $request->file('avatar')) {
            if ($validate->fails()) {
                return redirect()->back()
                    ->withErrors($validate)
                    ->withInput();
            }

            $newImage = $request->file('avatar')->store('images', 'public');

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
            if (Storage::disk('public')->exists($existingPhotoPath)) {
                Storage::disk('public')->delete($existingPhotoPath);
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
            return response()->redirectTo('/artis-verified/profile')->with('failed', "failed");
        }
        return response()->redirectTo('/artis-verified/profile')->with('failed', "failed");
    }
}
