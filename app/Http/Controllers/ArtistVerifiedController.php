<?php

namespace App\Http\Controllers;

use App\Models\admin;
use App\Models\album;
use App\Models\artist;
use App\Models\billboard;
use App\Models\genre;
use App\Models\messages;
use App\Models\notif;
use App\Models\penghasilan;
use App\Models\playlist;
use App\Models\projects;
use App\Models\Riwayat;
use App\Models\song;
use App\Models\User;
use Carbon\Carbon;
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
use Illuminate\Support\Facades\Cache;
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
        $notifs = notif::where('user_id', auth()->user()->id)->get();
        return response()->view('artisVerified.dashboard', compact('title', 'songs', 'genres', 'artist', 'billboards', 'playlists', 'notifs'));
    }

    protected function playlist(): Response
    {
        $title = "MusiCave";
        $playlists = playlist::all();
        $albums = album::all();
        $notifs = notif::where('user_id', auth()->user()->id)->get();
        return response()->view('artisVerified.playlist', compact('title', 'playlists', 'albums', 'notifs'));
    }

    protected function penghasilan(Request $request): Response
    {
        $title = "MusiCave";
        $totalPengguna = User::count();
        $totalpenghasilan = penghasilan::sum('penghasilan');
        $totalLagu = song::count();
        $totalArtist = artist::count();
        $songs = song::all();
        $songs = song::all();
        $projects = projects::where('status', 'accept')->get();
        $artistid = (int) artist::where('user_id', auth()->user()->id)->first()->id;
        $penghasilan = penghasilan::where('artist_id', $artistid)->pluck('penghasilan')->toArray();
        $totalpenghasilan = penghasilan::where('artist_id', $artistid)->sum('penghasilan');
        $penghasilanData = penghasilan::where('artist_id', $artistid)->first();
        // $month = penghasilan::where('artist_id', $artistid)->pluck('bulan')->toArray();
        $month = [];
        if ($request->has("artist_id")) {
            $artistId = (int) $request->artist_id;
            $bulan = $request->bulan;
            for ($i = 1; $i <= 12; $i++) {
                $totalPendapatan = penghasilan::where('artist_id', $artistId)
                    ->where('bulan', $bulan)
                    ->whereYear('created_at', date('Y'))
                    ->whereMonth('created_at', $i)
                    ->sum('penghasilan');
                $month[] = $totalPendapatan;
            }
        } else {
            $artistId = (int) auth()->user()->artist->id;
            for ($i = 1; $i <= 12; $i++) {
                $totalPendapatan = penghasilan::where('artist_id', $artistId)
                    ->whereYear('created_at', date('Y'))
                    ->whereMonth('created_at', $i)
                    ->sum('penghasilan');
                $month[] = $totalPendapatan;
            }
        }
        $notifs = notif::where('user_id', auth()->user()->id)->get();
        return response()->view('artisVerified.penghasilan', compact('title', 'totalpenghasilan', 'month', 'totalPengguna', 'totalLagu', 'totalArtist', 'songs', 'penghasilan', 'projects', 'notifs', 'penghasilanData'));
    }

    protected function pencairan()
    {
        $artistid = (int) artist::where('user_id', auth()->user()->id)->first()->id;
        $penghasilanData = penghasilan::where('artist_id', $artistid)->first();

        return response()->json(['penghasilan' => $penghasilanData]);
    }

    protected function pencairanDana(Request $request, string $code)
    {
        $artis = artist::where('user_id', $code)->first();
        $penghasilan = penghasilan::where('artist_id', $artis->id)->first();

        $data = [
            'is_take' => true,
            'Pengajuan' => $request->input('pencairan'),
            'Pengajuan_tanggal' => now()
        ];

        $penghasilan->update($data);
        return redirect()->back();
    }

    protected function riwayat(): Response
    {
        $title = "MusiCave";
        $riwayat = Riwayat::all();
        $notifs = notif::where('user_id', auth()->user()->id)->get();

        try {
            $uniqueRows = $riwayat->unique(function ($item) {
                return $item->user_id . $item->song_id . $item->play_date;
            });
        } catch (\Throwable $th) {
            return abort(404);
        }
        return response()->view('artisVerified.riwayat', compact('title', 'uniqueRows', 'notifs'));
    }

    protected function profile(string $code)
    {
        $user = artist::with('user')->where('user_id', $code)->first();
        return response()->json(['user' => $user]);
    }

    protected function profile_ubah(string $code): Response
    {
        $title = "MusiCave";
        $user = User::where('code', $code)->get();
        $notifs = notif::where('user_id', auth()->user()->id)->get();
        return response()->view('artisVerified.profile.profile_ubah', compact('title', 'user', 'notifs'));
    }

    protected function undangColab(Request $request, string $code)
    {
        $kolaborator = $request->input('kolaborator');
        if (empty($kolaborator[1]) === null) {
            $data = [
                'request_project_artis_id_1' => $kolaborator[0],
                'request_project_artis_id_2' => null,
                'status' => "pending",
                'pengajuan_project' => now()
            ];
        } else {
            $data = [
                'request_project_artis_id_1' => $kolaborator[0],
                'request_project_artis_id_2' => isset($kolaborator[1]) ? $kolaborator[1] : null,
                'status' => "pending",
                'pengajuan_project' => now()
            ];
        }
        // dd($data);
        projects::where('code', $code)
            ->update($data);
        try {
        } catch (\Throwable $th) {
            return abort(404);
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
            $notifs = notif::where('user_id', auth()->user()->id)->get();
        } catch (\Throwable $th) {
            return abort(404);
        }
        return response()->view('artisVerified.playlist', compact('title', 'playlists', 'albums', 'notifs'));
    }


    protected function updateProfile(string $code, Request $request)
    {
        $user = User::where('code', $code)->first();
        $validate = Validator::make(
            $request->all(),
            [
                'name' => 'required|string|max:255',
                'avatar' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                'email' => 'required|string|email|max:50|unique:users,email,' . $user->id,
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
            return abort(404);
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
            return abort(404);
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
            return abort(404);
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
            return abort(404);
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
            return abort(404);
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
        $notifs = notif::where('user_id', auth()->user()->id)->get();
        return response()->view('artisVerified.unggahAudio', compact('title', 'datas', 'genres', 'albums', 'artis', 'notifs'));
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

        $artis = artist::where('user_id', Auth::user()->id)->first();
        $data = [
            'artis_id' => $artis->id,
            'title' => $request->input('judul'),
            'user_id' => auth()->user()->id,
            'is_reject' => false
        ];


        DB::beginTransaction();
        $code = Str::uuid();
        $image = $request->file('image')->store('images', 'public');
        $audioPath = $request->file('audio')->store('musics', 'public');
        // $audio = $request->file('audio')->store('musics', 'public');
        // $namaFile = time() . '_' . $request->file('audio')->getClientOriginalName();

        // Simpan file audio dengan nama yang ditentukan di penyimpanan lokal
        // $audioPath = $request->file('audio')->storeAs('musics', $namaFile);

        $getID3 = new getID3();

        $audioInfo = $getID3->analyze($request->file('audio')->path());
        $durationInSeconds = $audioInfo['playtime_seconds'];
        $durationMinutes = floor($durationInSeconds / 60);
        $durationSeconds = $durationInSeconds % 60;
        $formattedDuration = sprintf('%02d:%02d', $durationMinutes, $durationSeconds);


        notif::create($data);
        song::create([
            'code' => $code,
            'judul' => $request->input('judul'),
            'image' => $image,
            'audio' => $audioPath,
            'waktu' => $formattedDuration,
            'is_approved' => false,
            'genre_id' => $request->input('genre'),
            'album_id' => $request->input('album') == null ? null : $request->input('album'),
            'artis_id' => $artis->id,
        ]);
        DB::commit();

            $penghasilanArtist = (int) $artis->penghasilan + 35000;
            $artis->update(['penghasilan' => $penghasilanArtist]);

        return redirect('/artis-verified/unggahAudio')->with('success', 'Song uploaded successfully.');
        try {
        } catch (\Throwable $e) {
            DB::rollBack();
            return abort(404);
        }
    }


    protected function billboard(string $code): Response
    {
        $title = "MusiCave";
        $billboard = billboard::where('code', $code)->first();
        $albums = album::where('artis_id', $billboard->artis_id)->get();
        $songs = song::where('artis_id', $billboard->artis_id)->get();
        $playlists = playlist::all();
        $notifs = notif::where('user_id', auth()->user()->id)->get();
        return response()->view('artisVerified.billboard.billboard', compact('title', 'billboard', 'albums', 'songs', 'playlists', 'notifs'));
    }

    protected function albumBillboard(string $code): Response
    {
        $title = "MusiCave";
        $album = album::where('code', $code)->first();
        $songs = song::where('album_id', $album->id)->get();
        $playlists = playlist::all();
        $notifs = notif::where('user_id', auth()->user()->id)->get();
        return response()->view('artisVerified.billboard.album', compact('title', 'album', 'songs', 'playlists', 'notifs'));
    }

    protected function album(): Response
    {
        $title = "MusiCave";
        $notifs = notif::where('user_id', auth()->user()->id)->get();
        return response()->view('artisVerified.billboard.album', compact('title', 'notifs'));
    }

    protected function kategori(string $code): Response
    {
        $title = "MusiCave";
        $genre = genre::where('code', $code)->first();
        $playlists = playlist::all();
        $songs = song::where('genre_id', $genre->id)->get();
        $notifs = notif::where('user_id', auth()->user()->id)->get();
        return response()->view('artisVerified.kategori.kategori', compact('title', 'genre', 'playlists', 'songs', 'notifs'));
    }

    protected function buatPlaylist(): Response
    {
        $title = "MusiCave";
        $songs = song::all();
        $notifs = notif::where('user_id', auth()->user()->id)->get();
        return response()->view('artisVerified.playlist.buat', compact('title', 'songs', 'notifs'));
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
        $songs = Song::where('judul', 'LIKE', '%' . $query . '%')->get();
        $users = User::where('name', 'LIKE', '%' . $query . '%')
            ->where('role_id', '!=', 3)
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

    protected function pencarian_input(Request $request)
    {
        $title = "MusiCave";
        $playlists = playlist::all();
        $song = song::where('judul', 'like', '%' .  $request->input('search') . '%')->first();
        $user = user::where('name', 'like', '%' .  $request->input('search') . '%')->first();
        $notifs = notif::where('user_id', auth()->user()->id)->get();

        if ($song) {
            $songs = song::all();
            return view('artisVerified.search.songSearch', compact('song', 'title', 'songs', 'playlists', 'notifs'));
        } else if ($user) {
            $artis = artist::where('user_id', $user->id)->first();
            $songs = song::where('artis_id', $artis->id)->get();
            return view('artisVerified.search.artisSearch', compact('user', 'title', 'songs', 'playlists', 'notifs', 'artis'));
        } else {
            return abort(404);
        }
    }

    public function search_result(Request $request, string $code)
    {
        $title = "MusiCave";
        $song = song::where('code', $code)->first();
        $user = user::where('code', $code)->first();
        $notifs = notif::where('user_id', auth()->user()->id)->get();
        $playlists = playlist::all();

        if ($song) {
            $songs = song::all();
            return view('artisVerified.search.songSearch', compact('song', 'title', 'songs', 'playlists', 'notifs'));
        } else if ($user) {
            $artis = artist::where('user_id', $user->id)->first();
            $songs = song::where('artis_id', $artis->id)->get();
            return view('artisVerified.search.artisSearch', compact('user', 'title', 'songs', 'playlists', 'notifs'));
        } else {
            return abort(404);
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
        $notifs = notif::where('user_id', auth()->user()->id)->get();
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
            return abort(404);
        }
        return response()->view('artisVerified.playlist', compact('title', 'playlists', 'notifs'));
    }

    protected function ubahPlaylist(Request $request, string $code)
    {
        $title = "MusiCave";
        $playlists = playlist::where('code', $code)->first();
        $notifs = notif::where('user_id', auth()->user()->id)->get();

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
            return abort(404);
        }
        return response()->view('artisVerified.playlist', compact('title', 'playlists', 'notifs'));
    }

    protected function ubahAlbum(Request $request, string $code)
    {
        $title = "MusiCave";
        $album = album::where('code', $code)->first();
        $notifs = notif::where('user_id', auth()->user()->id)->get();

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
            return abort(404);
        }
        return response()->view('artisVerified.playlist', compact('title', 'album', 'notifs'));
    }

    protected function detailPlaylist(string $code): Response
    {
        $playlistDetail = playlist::where('code', $code)->first();
        $songs = song::where('playlist_id', $playlistDetail->id)->get();
        $playlists = playlist::all();
        $title = "MusiCave";
        $notifs = notif::where('user_id', auth()->user()->id)->get();
        return response()->view('artisVerified.playlist.contoh', compact('title', 'playlistDetail', 'songs', 'playlists', 'notifs'));
    }

    protected function detailAlbum(string $code): Response
    {
        $albumDetail = album::where('code', $code)->first();
        $songs = song::all();
        $playlists = playlist::all();
        $title = "MusiCave";
        $notifs = notif::where('user_id', auth()->user()->id)->get();

        return response()->view('artisVerified.playlist.contohAlbum', compact('title', 'albumDetail', 'songs', 'playlists', 'notifs'));
    }

    protected function contohPlaylist(): Response
    {
        $title = "MusiCave";
        $notifs = notif::where('user_id', auth()->user()->id)->get();
        return response()->view('artisVerified.playlist.contoh', compact('title', 'notifs'));
    }

    protected function disukaiPlaylist(): Response
    {
        $title = "MusiCave";
        $notifs = notif::where('user_id', auth()->user()->id)->get();
        return response()->view('artisVerified.playlist.disukai', compact('title', 'notifs'));
    }

    protected function viewKolaborasi(Request $request)
    {
        $title = "Kolaborasi";
        $datas = projects::with('artis')->get();
        $artisUser = artist::where('user_id', auth()->user()->id)->first();
        $messages = messages::with(['sender.user', 'receiver', 'project'])->get();
        $notifs = notif::where('user_id', auth()->user()->id)->get();
        $artis = artist::with('user')->get();

        return response()->view('artisVerified.kolaborasi', compact('title', 'datas', 'artisUser', 'messages', 'artis', 'notifs'));
    }

    protected function artisSelect()
    {
        $artis = artist::with('user')->get();
        return response()->json($artis);
    }


    protected function viewLirikAndChat(Request $request, string $code)
    {
        try {
            $title = "Kolaborasi";
            $project = DB::table('projects')->where('code', $code)->first();
            $artis = artist::where('user_id', auth()->user()->id)->first();
            $messages = messages::with(['sender', 'project'])->where('project_id', $project->id)->get();
            projects::where('code', $project->code)->update(['penerima_project' => $artis->id]);
            $notifs = notif::where('user_id', auth()->user()->id)->get();
        } catch (\Throwable $th) {
            return abort(404);
        }
        return response()->view('artisVerified.lirikAndChat', compact('title', 'project', 'messages', 'notifs', 'artis'));
    }

    protected function showData(string $id)
    {
        $data = DB::table('projects')->where('code', $id)->get();
        $notifs = notif::where('user_id', auth()->user()->id)->get();
        return response()->view('artisVerified.kolaborasi', compact('data', 'notifs'));
    }

    protected function logout(Request $request)
    {
        Auth::logout();
        return response()->redirectTo("/masuk");
    }

    protected function Project(Request $request, string $code)
    {
        $statusPersetujuan = Cache::get('status_persetujuan_' . auth()->user()->id);
        $validate = Validator::make(
            $request->only('images', 'name', 'audio', 'range'),
            [
                'images' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'name' => 'required|string|max:255',
                'audio' => 'required|mimes:mp3|max:10240',
                'range' => 'required|integer|min:0|max:100',
            ],
            [
                'images.required' => 'Gambar wajib diunggah.',
                'images.image' => 'File harus berupa gambar.',
                'images.mimes' => 'Format gambar yang diperbolehkan adalah: jpeg, png, jpg, gif.',
                'images.max' => 'Ukuran gambar maksimal adalah 2 MB.',

                'name.required' => 'Judul wajib diisi.',
                'name.string' => 'Judul harus berupa teks.',
                'name.max' => 'Judul tidak boleh lebih dari 255 karakter.',

                'audio.required' => 'File audio wajib diunggah.',
                'audio.mimes' => 'Format audio yang diperbolehkan adalah: mp3.',
                'audio.max' => 'Ukuran file audio maksimal adalah 10 MB.',

                'range.required' => 'Rentang wajib diisi.',
                'range.integer' => 'Rentang harus berupa angka bulat.',
                'range.min' => 'Rentang minimal adalah 0.',
                'range.max' => 'Rentang maksimal adalah 100.',
            ]
        );

        setlocale(LC_MONETARY, 'id_ID');

        if ($validate->fails()) {
            return redirect()->back()
                ->withErrors($validate)
                ->withInput();
        }

        $project = projects::where('code', $code)->first();

        $range = $request->input('range');

        if ($range < 40) {
            $persentase = 40;
        } elseif ($range > 80) {
            $persentase = 80;
        }

        $uangTetap = 2000000;
        $uangYangDiterima = ($range / 100) * $uangTetap;

        $data = [
            'code' => $project->code,
            'name' => $project->name,
            'konsep' => $project->konsep,
            'judul' => $request->input('name'),
            'images' => $images,
            'audio' => $request->file('audio'),
            'harga' => $uangYangDiterima,
            'status' => "accept",
            'pembuat_project' => Auth::user()->id,
            // 'penerima_project' => $project->request_project_artis_id,
            'is_approved' => true,
            'is_reject' => false,
        ];

        // dd($project->request_project_artis_id_);
        $project->update($data);
        try {
        } catch (Throwable $e) {
            return abort(404);
        }
        return response()->redirectTo('/artis-verified/kolaborasi')->with('message', 'User created successfully.');
    }

    protected function message(Request $request, string $code)
    {
        try {
            $project = projects::where('code', $code)->first();
            $sender = artist::where('user_id', auth()->user()->id)->first();
            if ($sender->id === $project->artist_id) {
                $data = [
                    'code' => Str::uuid(),
                    'sender_id' => $sender->id,
                    'receiver_id_1' => $project->request_project_artis_id_1,
                    'receiver_id_2' => $project->request_project_artis_id_2,
                    'project_id' => $project->id,
                    'message' => $request->input('message')
                ];
            } else if ($sender->id === $project->request_project_artis_id_1) {
                $data = [
                    'code' => Str::uuid(),
                    'sender_id' => $sender->id,
                    'receiver_id_1' => $project->request_project_artis_id_2,
                    'receiver_id_2' => $project->artist_id,
                    'project_id' => $project->id,
                    'message' => $request->input('message')
                ];
            } else if ($sender->id === $project->request_project_artis_id_2) {
                $data = [
                    'code' => Str::uuid(),
                    'sender_id' => $sender->id,
                    'receiver_id_1' => $project->request_project_artis_id_1,
                    'receiver_id_2' => $project->artist_id,
                    'project_id' => $project->id,
                    'message' => $request->input('message')
                ];
            }
            $message = messages::create($data);
            $data = messages::with(['sender', 'receiver', 'project'])->get();
        } catch (\Throwable $th) {
            return abort(404);
        }
        return redirect()->back()->with([
            'message' => $message->message,
            'datas' => $data
        ]);
    }

    protected function rejectProject(Request $request)
    {
        $project = projects::with('messages')->where('code', $request->input('code'))->first();
        $artis = artist::where('user_id', auth()->user()->id)->first();
        $message = messages::where('project_id', $project->id)->get();
        try {
            if ($project->artist_id == $artis->id) {
                foreach ($message as $item) {
                    $item->delete();
                }
                $data = [
                    'code' => $project->code,
                    'name' => $project->name,
                    'judul' => "none",
                    'lirik' => "none",
                    'konsep' => $project->konsep,
                    'harga' => $project->harga,
                    'artist_id' => $artis->id,
                    'is_approved' => false,
                    'is_reject' => true,
                ];
                $project->delete($data);
            } else {
                $data = [
                    'code' => $project->code,
                    'name' => $project->name,
                    'judul' => "none",
                    'lirik' => "none",
                    'status' => "reject",
                    'konsep' => $project->konsep,
                    'harga' => $project->harga,
                    'artist_id' => $artis->id,
                    'is_approved' => false,
                    'is_reject' => true,
                ];
                $project->update($data);
            }
        } catch (\Throwable $th) {
            return abort(404);
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
        try {
            projects::create(
                [
                    'code' => $code,
                    'name' => $request->input('name'),
                    'konsep' => $request->input('konsep'),
                    'artist_id' => $artis->id,
                ]
            );
        } catch (Throwable $e) {
            return abort(404);
        }
        return response()->redirectTo('/artis-verified/kolaborasi')->with('message', 'User created successfully.');
    }

    protected function bayar(Request $request, string $code)
    {
        dd($code);
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
            return abort(404);
        }
        return response()->redirectTo('/artis-verified/kolaborasi');
    }
}
