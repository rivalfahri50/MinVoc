<?php

namespace App\Http\Controllers;

use App\Models\admin;
use App\Models\album;
use App\Models\artist;
use App\Models\billboard;
use App\Models\genre;
use App\Models\messages;
use App\Models\playlist;
use App\Models\projects;
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
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use getID3;
use RealRashid\SweetAlert\Facades\Alert;
use Throwable;

class ArtistVerifiedController extends Controller
{
    protected function index(): Response
    {
        $title = "MusiCave";
        $songs = song::all();
        $genres = genre::all();
        $playlists = playlist::all();
        $artist = artist::with('user')->get();
        $playlists = playlist::all();
        $billboards = billboard::all();
        return response()->view('artisVerified.dashboard', compact('title', 'songs', 'genres', 'artist', 'billboards', 'playlists'));
    }

    protected function playlist(): Response
    {
        $title = "MusiCave";
        $playlists = playlist::all();
        $albums = album::all();
        return response()->view('artisVerified.playlist', compact('title', 'playlists', 'albums'));
    }

    protected function penghasilan(): Response
    {
        $title = "MusiCave";
        $totalPengguna = User::count();
        $totalLagu = song::count();
        $totalArtist = artist::count();
        $songs = song::all();
        $penghasilan = artist::where('user_id', auth()->user()->id)->first();
        return response()->view('artisVerified.penghasilan', compact('title', 'totalPengguna', 'totalLagu', 'totalArtist', 'songs', 'penghasilan'));
    }

    protected function riwayat(): Response
    {
        $title = "MusiCave";
        $riwayat = Riwayat::all();

        $uniqueRows = $riwayat->unique(function ($item) {
            return $item->user_id . $item->song_id . $item->play_date;
        });
        return response()->view('artisVerified.riwayat', compact('title','uniqueRows'));
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

    protected function undangColab(Request $request, string $code)
    {
        try {
            projects::where('code', $code)
                ->update([
                    'request_project_artis_id' => $request->input('kolaborator')
                ]);
        } catch (\Throwable $th) {
            return redirect()->back();
        }
        return redirect()->back();
    }

    protected function buatAlbum(Request $request, string $code)
    {
        $user = User::where('code', $code)->first();
        $artist = Artist::where('user_id', $user->id)->first();

        $validate = Validator::make(
            $request->all(),
            [
                'name' => 'required|string|max:255',
                'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            ],
            [
                'name' => [
                    'required' => 'Nama harus diisi.',
                    'string' => 'Nama harus berupa teks.',
                    'max' => 'Nama tidak boleh lebih dari :max karakter.',
                ],
                'image' => [
                    'image' => 'image harus berupa gambar.',
                    'mimes' => 'image harus dalam format: :values.',
                    'max' => 'image tidak boleh lebih dari :max KB.',
                ],
            ]
        );

        if ($validate->fails()) {
            return redirect()->back()
                ->withErrors($validate)
                ->withInput();
        }

        try {
            $imagePath = $request->file('image')->store('images', 'public');

            album::create([
                'code' => Str::uuid(),
                'artis_id' => $artist->id,
                'name' => $request->input('name'),
                'image' => $imagePath,
            ]);
            $title = "MusiCave";
            $playlists = playlist::all();
            $albums = album::all();
        } catch (\Throwable $th) {
            return response()->view('artisVerified.playlist', compact('title', 'playlists', 'albums'));
        }
        return response()->view('artisVerified.playlist', compact('title', 'playlists', 'albums'));
    }


    protected function updateProfile(string $code, Request $request)
    {
        $user = User::where('code', $code)->first();
        $validate = Validator::make(
            $request->all(),
            [
                'name' => 'required|string|max:255',
                'avatar' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
                'deskripsi' =>  'max:500',
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
                    'uniqe' => 'Email sudah di pakai.',
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

    protected function hapusPlaylist(string $code)
    {
        $playlist = Playlist::where('code', $code)->first();

        if (!$playlist) {
            return response()->redirectTo('artisVerified/playlist');
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
            return response()->redirectTo('artis-verified/playlist');
        }
        return response()->redirectTo('artis-verified/playlist');
    }

    protected function tambah_playlist(string $code, Request $request)
    {
        $song = song::where('code', $code)->first();
        try {
            $song->playlist_id = $request->input('playlist_id');
            $song->update();
        } catch (\Throwable $th) {
            return response()->redirectTo('/artis-verified/playlist');
        }
        return response()->redirectTo('/artis-verified/playlist');
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

    protected function hapusAlbum(string $code)
    {
        $album = album::where('code', $code)->first();

        if (!$album) {
            return response()->redirectTo('artisVerified/album');
        }

        try {
            if (Storage::disk('public')->exists($album->image)) {
                Storage::disk('public')->delete($album->image);
            }
            song::where('album_id', $album->id)->update(['album_id' => null]);
            $album->delete();
        } catch (\Throwable $th) {
            Log::error('Error deleting playlist: ' . $th->getMessage());
            return response()->redirectTo('/artis-verified/playlist');
        }

        return response()->redirectTo('/artis-verified/playlist');
    }

    protected function viewUnggahAudio(Request $request): Response
    {
        $title = "Unggah Audio";
        $datas = song::with('artist')->get();
        $artis = artist::where('user_id', auth()->user()->id)->first();
        $genres = genre::all();
        $albums = album::all();
        return response()->view('artisVerified.unggahAudio', compact('title', 'datas', 'genres', 'albums', 'artis'));
    }

    protected function unggahAudio(Request $request)
    {
        $validator = Validator::make($request->only('image', 'judul', 'audio', 'genre', 'album'), [
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'judul' => 'required|string|max:255',
            'audio' => 'required|mimetypes:audio/mpeg,audio/wav|max:20480',
            'genre' => 'required|string|max:255',
            'album' => 'string|max:255',
        ], [
            'image.image' => 'File :attribute harus berupa gambar.',
            'image.mimes' => 'File :attribute harus berupa file gambar dengan tipe: :values.',
            'image.max' => 'File :attribute tidak boleh lebih dari :max kilobita.',
            'judul.required' => 'Kolom :attribute harus diisi.',
            'judul.string' => 'Kolom :attribute harus berupa teks.',
            'judul.max' => 'Kolom :attribute tidak boleh lebih dari :max karakter.',
            'audio.required' => 'Kolom :attribute harus diisi.',
            'audio.mimetypes' => 'File :attribute harus berupa file audio dengan tipe: :values.',
            'audio.max' => 'File :attribute tidak boleh lebih dari :max kilobita.',
            'genre.required' => 'Kolom :attribute harus diisi.',
            'genre.string' => 'Kolom :attribute harus berupa teks.',
            'genre.max' => 'Kolom :attribute tidak boleh lebih dari :max karakter.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }


        try {
            DB::beginTransaction();
            $code = Str::uuid();
            $image = $request->file('image')->store('images', 'public');
            $audio = $request->file('audio')->store('musics', 'public');

            $getID3 = new getID3();

            $audioInfo = $getID3->analyze($request->file('audio')->path());
            $durationInSeconds = $audioInfo['playtime_seconds'];
            $durationMinutes = floor($durationInSeconds / 60);
            $durationSeconds = $durationInSeconds % 60;
            $formattedDuration = sprintf('%02d:%02d', $durationMinutes, $durationSeconds);

            $artis = artist::where('user_id', Auth::user()->id)->first();

            song::create([
                'code' => $code,
                'judul' => $request->input('judul'),
                'image' => $image,
                'audio' => $audio,
                'waktu' => $formattedDuration,
                'is_approved' => false,
                'genre_id' => $request->input('genre'),
                'album_id' => $request->input('album') == null ? null : $request->input('album'),
                'artis_id' => $artis->id,
            ]);
            DB::commit();

            // Alert::success('message', 'Berhasil Mengunggah Lagu');
            return redirect('/artis-verified/unggahAudio')->with('success', 'Song uploaded successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Error uploading song: ' . $e->getMessage());
            // Alert::error('message', 'Gagal Mengunggah Lagu');
            return redirect('/artis-verified/unggahAudio')->with('error', 'Failed to upload song. Please try again later.');
        }
    }


    protected function billboard(string $code): Response
    {
        $title = "MusiCave";
        $billboard = billboard::where('code', $code)->first();
        $albums = album::where('artis_id', $billboard->artis_id)->get();
        $songs = song::where('artis_id', $billboard->artis_id)->get();
        $playlists = playlist::all();
        return response()->view('artisVerified.billboard.billboard', compact('title', 'billboard', 'albums', 'songs', 'playlists'));
    }

    protected function albumBillboard(string $code): Response
    {
        $title = "MusiCave";
        $album = album::where('code', $code)->first();
        $songs = song::where('album_id', $album->id)->get();
        $playlists = playlist::all();
        return response()->view('artisVerified.billboard.album', compact('title', 'album', 'songs', 'playlists'));
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
        $playlists = playlist::all();
        $songs = song::where('genre_id', $genre->id)->get();
        return response()->view('artisVerified.kategori.kategori', compact('title', 'genre', 'playlists', 'songs'));
    }

    protected function buatPlaylist(): Response
    {
        $title = "MusiCave";
        $songs = song::all();
        return response()->view('artisVerified.playlist.buat', compact('title', 'songs'));
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
        // $results = User::where('name', 'LIKE', '%' . $query . '%')->get();
        return response()->json(['results' => $results]);
    }

    protected function pencarian_input(Request $request)
    {
        $title = "MusiCave";
        $playlists = playlist::all();
        $song = song::where('judul', 'like', '%' .  $request->input('search') . '%')->first();
        $user = user::where('name', 'like', '%' .  $request->input('search') . '%')->first();

        if ($song) {
            $songs = song::all();
            return view('artisVerified.search.songSearch', compact('song', 'title', 'songs', 'playlists'));
        } else if ($user) {
            $artis = artist::where('user_id', $user->id)->first();
            $songs = song::where('artis_id', $artis->id)->get();
            return view('artisVerified.search.artisSearch', compact('user', 'title', 'songs', 'playlists'));
        } else {
            return "not found";
        }
    }

    public function search_result(Request $request, string $code)
    {
        $title = "MusiCave";
        $song = song::where('code', $code)->first();
        $user = user::where('code', $code)->first();
        $playlists = playlist::all();

        if ($song) {
            $songs = song::all();
            return view('artisVerified.search.songSearch', compact('song', 'title', 'songs', 'playlists'));
        } else if ($user) {
            $artis = artist::where('user_id', $user->id)->first();
            $songs = song::where('artis_id', $artis->id)->get();
            return view('artisVerified.search.artisSearch', compact('user', 'title', 'songs', 'playlists'));
        }
    }

    public function search_song(Request $request)
    {
        $query = $request->input('query');
        $results = song::with('artist.user')->where('judul', 'like', '%' . $query . '%')->get();

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

                if (Storage::disk('public')->exists($playlists->images) == "images/defaultPlaylist.png") {
                    $newImage = $request->file('images')->store('images', 'public');
                } else if (Storage::disk('public')->exists($playlists->images)) {
                    Storage::disk('public')->delete($playlists->images);
                    $newImage = $request->file('images')->store('images', 'public');
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

    protected function ubahAlbum(Request $request, string $code)
    {
        $title = "MusiCave";
        $album = album::where('code', $code)->first();
        try {
            if (!$request->file()) {
                $values =
                    [
                        'code' => $code,
                        'name' => $request->input('name') == null ? $album->name : $request->input('name'),
                        'image' => $album->image,
                    ];
            } else if ($existImage = $request->file('image')->store('images', 'public')) {
                if (Storage::disk('public')->exists($album->image)) {
                    Storage::disk('public')->delete($album->image);
                }

                $values =
                    [
                        'code' => $code,
                        'name' => $request->input('name') == null ? $album->name : $request->input('name'),
                        'image' => $existImage,
                    ];
            }
            $album->update($values);
            $album = album::all();
        } catch (\Throwable $th) {
            return response()->view('artisVerified.playlist', compact('title'));
        }
        return response()->view('artisVerified.playlist', compact('title', 'album'));
    }

    protected function detailPlaylist(string $code): Response
    {
        $playlistDetail = playlist::where('code', $code)->first();
        $songs = song::where('playlist_id', $playlistDetail->id)->get();
        $playlists = playlist::all();
        $title = "MusiCave";
        return response()->view('artisVerified.playlist.contoh', compact('title', 'playlistDetail', 'songs', 'playlists'));
    }

    protected function detailAlbum(string $code): Response
    {
        $albumDetail = album::where('code', $code)->first();
        $songs = song::all();
        $playlists = playlist::all();
        $title = "MusiCave";
        return response()->view('artisVerified.playlist.contohAlbum', compact('title', 'albumDetail', 'songs', 'playlists'));
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

    protected function viewKolaborasi(Request $request)
    {
        $title = "Kolaborasi";
        $datas = projects::with('artis')->get();
        $artisUser = artist::where('user_id', auth()->user()->id)->first();
        $artis = artist::all();
        $messages = messages::with(['sender.user', 'receiver', 'project'])->get();
        return response()->view('artisVerified.kolaborasi', compact('title', 'datas', 'artis', 'artisUser', 'messages'));
    }

    protected function viewLirikAndChat(Request $request, string $code)
    {
        $title = "Kolaborasi";
        $project = DB::table('projects')->where('code', $code)->first();
        $artis = artist::where('user_id', auth()->user()->id)->first();
        $messages = messages::with(['sender', 'project'])->where('project_id', $project->id)->get();
        try {
            projects::where('code', $project->code)->update(['penerima_project' => $artis->id]);
        } catch (\Throwable $th) {
            return response()->view('artisVerified.lirikAndChat', compact('title', 'project', 'messages'));
        }
        return response()->view('artisVerified.lirikAndChat', compact('title', 'project', 'messages'));
    }

    protected function showData(string $id)
    {
        $data = DB::table('projects')->where('code', $id)->get();
        return response()->view('artisVerified.kolaborasi', compact('data'));
    }

    protected function logout(Request $request)
    {
        Auth::logout();
        return response()->redirectTo("/masuk");
    }

    protected function Project(Request $request)
    {
        $validate = Validator::make(
            $request->only('judul', 'lirik', 'code'),
            [
                'judul' => 'required|string|max:255',
                'lirik' => 'required|string',
                'code' => [
                    'required',
                    Rule::in([$request->input('code')]),
                ]
            ],
            [
                'required' => 'Kolom :attribute harus diisi.',
                'string' => 'Kolom :attribute harus berupa teks.',
                'max' => [
                    'string' => 'Kolom :attribute tidak boleh lebih dari :max karakter.',
                ],
                'in' => 'Kolom :attribute tidak valid.',
            ]
        );

        if ($validate->fails()) {
            return redirect()->back()
                ->withErrors($validate)
                ->withInput();
        }

        $project = projects::where('code', $request->input('code'))->first();

        $data = [
            'code' => $project->code,
            'name' => $project->name,
            'judul' => $request->input('judul'),
            'lirik' => $request->input('lirik'),
            'konsep' => $project->konsep,
            'harga' => $project->harga,
            'artist_id' => Auth::user()->id,
            'is_approved' => false,
            'is_reject' => false,
        ];

        // dd($data);

        try {
            $project->update($data);
        } catch (Throwable $e) {
            return response()->redirectTo('/artis-verified/kolaborasi')->with('message', "Gagal untuk register!!");
        }
        return response()->redirectTo('/artis-verified/kolaborasi')->with('message', 'User created successfully.');
    }

    protected function message(Request $request, string $code)
    {
        $project = projects::where('code', $code)->first();
        $sender = artist::where('user_id', auth()->user()->id)->first();
        if ($sender->id === $project->artist_id)
        {
            $data = [
                'code' => Str::uuid(),
                'sender_id' => $sender->id,
                'receiver_id' => $project->request_project_artis_id,
                'project_id' => $project->id,
                'message' => $request->input('message')
            ];
        } else {
            $data = [
                'code' => Str::uuid(),
                'sender_id' => $sender->id,
                'receiver_id' => $project->artist_id,
                'project_id' => $project->id,
                'message' => $request->input('message')
            ];
        }

        try {
            $message = messages::create($data);
            $data = messages::with(['sender', 'receiver', 'project'])->get();
        } catch (\Throwable $th) {
            return redirect()->back();
        }

        return redirect()->back()->with([
            'message' => $message->message,
            'datas' => $data
        ]);
    }

    protected function rejectProject(Request $request)
    {
        $project = projects::where('code', $request->input('code'))->first();
        // dd($project);
        try {
            $data = [
                'code' => $project->code,
                'name' => $project->name,
                'judul' => "none",
                'lirik' => "none",
                'konsep' => $project->konsep,
                'harga' => $project->harga,
                'artist_id' => Auth::user()->id,
                'is_approved' => false,
                'is_reject' => true,
            ];
            $project->update($data);
        } catch (\Throwable $th) {
            return redirect()->back();
        }
        return redirect()->back();
    }

    protected function createProject(Request $request)
    {
        $validate = Validator::make(
            $request->only('name', 'konsep'),
            [
                'name' => 'required|string|max:255|min:1',
                'konsep' => 'required|string|max:500|min:1',
            ],
            [
                'required' => 'Kolom :attribute harus diisi.',
                'string' => 'Kolom :attribute harus berupa teks.',
                'max' => [
                    'string' => 'Kolom :attribute tidak boleh lebih dari :max karakter.',
                ],
                'numeric' => 'Kolom :attribute harus berupa angka.',
                'min' => [
                    'numeric' => 'Kolom :attribute harus lebih besar atau sama dengan :min.',
                ],
            ]
        );

        if ($validate->fails()) {
            return redirect()->back()
                ->withErrors($validate)
                ->withInput();
        }

        $artis = artist::where('user_id', auth()->user()->id)->first();

        $code = Str::uuid();
        $data = projects::create(
            [
                'code' => $code,
                'name' => $request->input('name'),
                'konsep' => $request->input('konsep'),
                'artist_id' => $artis->id,
            ]
        );

        // dd($data);
        try {
        } catch (Throwable $e) {
            return response()->redirectTo('/artis-verified/kolaborasi')->with('message', "Gagal untuk register!!");
        }
        return response()->redirectTo('/artis-verified/kolaborasi')->with('message', 'User created successfully.');
    }

    protected function bayar(Request $request, string $code)
    {
        $project = projects::where('code', $code)->first();
        $range = $request->input('range');

        if ($range < 40) {
            $persentase = 40;
        } elseif ($range > 80) {
            $persentase = 80;
        }

        // Nilai uang tetap
        $uangTetap = 1800000;

        // Hitung jumlah uang berdasarkan persentase
        $uangYangDiterima = ($range / 100) * $uangTetap;
        // Bagikan uang ke pesngguna berdasarkan persentase
        $uangPengguna = ($uangYangDiterima / 100) * $range;

        try {
            $admin = admin::where('id', 1)->first();
            $admin->penghasilan = '200.000';
            $admin->update();

            $artisVerified = artist::where('id', $project->pembuat_project)->first();
            $artis = artist::where('id', $project->penerima_project)->first();
            $artisVerified->penghasilan = $uangYangDiterima;
            $artisVerified->update();
            $artis->penghasilan = $uangPengguna;
            $artis->update();
        } catch (\Throwable $th) {
            return response()->redirectTo('/artis-verified/kolaborasi');
        }
        return response()->redirectTo('/artis-verified/kolaborasi');
    }
}
