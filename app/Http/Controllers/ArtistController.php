<?php

namespace App\Http\Controllers;

use App\Models\album;
use App\Models\artist;
use App\Models\billboard;
use App\Models\genre;
use App\Models\Like;
use App\Models\messages;
use App\Models\notif;
use App\Models\Notifikasi;
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
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Input;
use RealRashid\SweetAlert\Facades\Alert;
use Throwable;
use Google_Client;
use Google_Service_Drive;
use GuzzleHttp\Psr7\Utils;
use GuzzleHttp\Psr7\stream_for;
use Google_Service_Drive_DriveFile;
use GuzzleHttp\Psr7\Request as Psr7Request;
use GuzzleHttp\Client as GuzzleClient;


class ArtistController extends Controller
{
    protected function index(): Response
    {
        $title = "MusiCave";
        $songs = song::all();
        $song = song::where('didengar', '>', '1000')->orderByDesc('didengar')->get();
        $genres = genre::all();
        $artist = artist::with('user')->get();
        $playlists = playlist::all();
        $billboards = billboard::all();
        $notifs = notif::with('user.artist.song', 'song')->where('user_id', auth()->user()->id)->get();
        return response()->view('artis.dashboard', compact('title', 'songs', 'song', 'genres', 'artist', 'billboards', 'playlists', 'notifs'));
    }

    protected function playlist(): Response
    {
        $title = "MusiCave";
        $playlists = playlist::all();
        $albums = album::all();
        $notifs = notif::with('user.artist.song', 'song')->where('user_id', auth()->user()->id)->get();
        return response()->view('artis.playlist', compact('title', 'playlists', 'albums', 'notifs'));
    }

    protected function penghasilan(Request $request): Response
    {
        $title = "MusiCave";
        $projects = projects::all();
        $songs = song::all();
        $artistid = (int) artist::where('user_id', auth()->user()->id)->first()->id;
        $totalpenghasilan = penghasilan::where('artist_id', $artistid)->sum('penghasilan');
        $penghasilan = penghasilan::where('artist_id', $artistid)->pluck('penghasilan')->toArray();
        $penghasilanArtis = penghasilan::with('artist')->where('artist_id', $artistid)->where('is_submit', false)->get();
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

        $notifs = notif::with('user.artist.song', 'song')->where('user_id', auth()->user()->id)->get();
        return response()->view('artis.penghasilan', compact('title', 'month', 'totalpenghasilan', 'songs', 'penghasilan', 'projects', 'notifs', 'penghasilanArtis'));
    }

    protected function riwayat(): Response
    {
        $title = "MusiCave";
        $riwayat = Riwayat::all();
        $uniqueRows = $riwayat->unique(function ($item) {
            return $item->user_id . $item->song_id . $item->play_date;
        });
        $notifs = notif::with('user.artist.song', 'song')->where('user_id', auth()->user()->id)->get();
        return response()->view('artis.riwayat', compact('title', 'notifs', 'uniqueRows'));
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
        $notifs = notif::with('user.artist.song', 'song')->where('user_id', auth()->user()->id)->get();
        return response()->view('artis.profile.profile_ubah', compact('title', 'user', 'notifs'));
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
        return response()->redirectTo('/artis/playlist');
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
            $notifs = notif::with('user.artist.song', 'song')->where('user_id', auth()->user()->id)->get();
        } catch (\Throwable $th) {
            return abort(404);
        }
        return response()->view('artis.playlist', compact('title', 'playlists', 'albums', 'notifs'));
    }

    protected function verifiedAccount(string $code, Request $request)
    {
        $user = User::where('code', $code)->first();
        $artist = Artist::where('user_id', $user->id)->first();

        $validate = Validator::make(
            $request->all(),
            [
                'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ],
            [
                'foto' => [
                    'image' => 'foto harus berupa gambar.',
                    'mimes' => 'foto harus dalam format: :values.',
                    'max' => 'foto tidak boleh lebih dari :max KB.',
                ],
            ]
        );

        if ($validate->fails()) {
            return redirect()->back()
                ->withErrors($validate)
                ->withInput();
        }

        try {
            $imagePath = $request->file('foto')->store('images', 'public');
            $artist->pengajuan_verified_at = now()->toDateString();
            $artist->verification_status = "pending";
            $artist->image = $imagePath;
            $artist->pengajuan = true;
            $artist->update();
        } catch (\Throwable $th) {
            Alert::error('message', 'Gagal Mengirim Request Verification Account');
            return response()->redirectTo('/artis/verified')->with('failed', "failed");
        }
        Alert::success('message', 'Success Mengirim Request Verification Account, Mohon Tunggu!!')->autoClose(2000);
        return response()->redirectTo('/artis/verified')->with('message', "success");
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
            Alert::error('message', 'Profile gagal di perbarui');
            return redirect()->back();
        }
        Alert::success('message', 'Profile berhasil di perbarui');
        return redirect()->back();
    }

    protected function deleteSong(Request $request, string $code)
    {
        try {
            $music = song::where('code', $code)->first();
            $music->delete();
            Alert::success('message', 'berhasil menghapus lagu!');
        } catch (\Throwable $th) {
            return back();
        }
        return back();
    }

    protected function hapusPlaylist(string $code)
    {
        $playlist = Playlist::where('code', $code)->first();

        if (!$playlist) {
            return response()->redirectTo('artis/playlist');
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
        return response()->redirectTo('artis/playlist');
    }

    protected function filterDate(Request $request)
    {
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $startDate = $request->start_date;
        $endDate = $request->end_date;

        $start_date = Carbon::parse($startDate)->startOfDay();
        $end_date = Carbon::parse($endDate)->endOfDay();

        $results = penghasilan::with('artist')->whereBetween('created_at', [$start_date, $end_date])->where('is_submit', '===', 0)
            ->get();

        return redirect()->back()->with(['results' => $results])->withInput();
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
            return response()->redirectTo('artis/album');
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

        return response()->redirectTo('/artis/playlist');
    }

    protected function viewUnggahAudio(Request $request): Response
    {
        $title = "Unggah Audio";
        $datas = song::with('artist')->get();
        $artis = artist::where('user_id', auth()->user()->id)->first();
        $genres = genre::all();
        $albums = album::with('artis')->get();
        $notifs = notif::with('user.artist.song', 'song')->where('user_id', auth()->user()->id)->get();
        return response()->view('artis.unggahAudio', compact('title', 'datas', 'genres', 'albums', 'artis', 'notifs'));
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
            $getID3 = new getID3();

            $audioInfo = $getID3->analyze($request->file('audio')->path());
            $durationInSeconds = $audioInfo['playtime_seconds'];
            $durationMinutes = floor($durationInSeconds / 60);
            $durationSeconds = $durationInSeconds % 60;
            $formattedDuration = sprintf('%02d:%02d', $durationMinutes, $durationSeconds);

            $artis = artist::where('user_id', Auth::user()->id)->first();

            $client = new Google_Client();
            $client->setAuthConfig(public_path('client_secret_650886155711-77aeuhp9hlvh6vncaejjbic959d04snl.apps.googleusercontent.com.json'));
            $client->setAccessType('offline');
            $client->setScopes(['https://www.googleapis.com/auth/drive']);
            $client->setAccessToken(['access_token' => 'ya29.a0AfB_byDhu6puzaX7YsaNmwUVVCR-Hb8sYOxGW4PAwKMxW5MivyU10oJuhPiRlA_W0ZQsLSZ_NPz_1cxPEJ0dCx9j-JXPpbSUTF3ScdrfP8ce1CJsEsT0U2X3Ud2dtqRqt7pRcsHmBu4Q_WvyW5u0VIQztGNEpcX-zLoUaCgYKAV4SARESFQGOcNnCV-sp6LMyU3VCvJwvgZA8BA0171', 'refresh_token' => '1//04COM2mA9b_b0CgYIARAAGAQSNwF-L9IryJ_9yA4kVUaDFlRDP0PiP72e1DqAyqznHgdmAi1kwvxJ8SoGoxtjEmRlH0w2XRL5-EI']);

            if ($client->isAccessTokenExpired()) {
                $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
            }

            $driveService = new Google_Service_Drive($client);

            $audioFile = $request->file('audio');

            $mimeType = 'audio/mpeg';
            $fileExtension = 'mp3';

            $fileMetadata = new Google_Service_Drive_DriveFile([
                'name' => $audioFile->getClientOriginalName(),
                'mimeType' => $mimeType,
            ]);

            $fileContent = file_get_contents($audioFile->getRealPath());

            $file = $driveService->files->create($fileMetadata, [
                'data' => $fileContent,
                'mimeType' => $mimeType,
                'uploadType' => 'multipart',
            ]);

            song::create([
                'code' => $code,
                'judul' => $request->input('judul'),
                'image' => $image,
                'audio' => $file->id,
                'waktu' => $formattedDuration,
                'type' => 'pengajuan',
                'is_approved' => false,
                'genre_id' => $request->input('genre'),
                'album_id' => $request->input('album') == null ? null : $request->input('album'),
                'artis_id' => $artis->id,
            ]);
            DB::commit();

            $penghasilanArtist = (int) $artis->penghasilan + 200000;
            $artis->update(['penghasilan' => $penghasilanArtist]);

            Alert::success('message', 'Lagu berhasil di upload, tunggu admin untuk publish');
            return redirect('/artis/unggahAudio')->with('success', 'Song uploaded successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();
            Alert::error('message', 'Lagu gagal di upload');
            return redirect()->back();
        }
    }


    protected function billboard(string $code): Response
    {
        $title = "MusiCave";
        $billboard = billboard::where('code', $code)->first();
        $artis_id = $billboard->artis_id;
        $albums = album::where('artis_id', $billboard->artis_id)->get();
        $songs = song::all();
        $playlists = playlist::all();
        $notifs = notif::with('user.artist.song', 'song')->where('user_id', auth()->user()->id)->get();
        return response()->view('artis.billboard.billboard', compact('title', 'billboard', 'artis_id', 'albums', 'songs', 'playlists', 'notifs'));
    }

    protected function albumBillboard(string $code): Response
    {
        $title = "MusiCave";
        try {
            $album = album::where('code', $code)->first();
            $album_id = $album->id;
            $songs = song::where('album_id', $album->id)->get();
            $playlists = playlist::all();
            $notifs = notif::with('user.artist.song', 'song')->where('user_id', auth()->user()->id)->get();
        } catch (\Throwable $th) {
            abort(404);
        }
        return response()->view('artis.billboard.album', compact('title', 'album_id', 'album', 'songs', 'playlists', 'notifs'));
    }

    protected function album(): Response
    {
        $title = "MusiCave";
        $notifs = notif::with('user.artist.song', 'song')->where('user_id', auth()->user()->id)->get();
        return response()->view('artis.billboard.album', compact('title', 'notifs'));
    }

    protected function kategori(string $code): Response
    {
        $title = "MusiCave";
        $genre = genre::where('code', $code)->first();
        $genre_id = $genre->id;
        $playlists = playlist::all();
        $songs = song::where('genre_id', $genre->id)->get();
        $notifs = notif::with('user.artist.song', 'song')->where('user_id', auth()->user()->id)->get();
        return response()->view('artis.kategori.kategori', compact('title', 'genre_id', 'genre', 'songs', 'playlists', 'notifs'));
    }

    protected function buatPlaylist(): Response
    {
        $title = "MusiCave";
        $songs = song::all();
        $notifs = notif::with('user.artist.song', 'song')->where('user_id', auth()->user()->id)->get();
        return response()->view('artis.playlist.buat', compact('title', 'songs', 'notifs'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $songs = Song::where('judul', 'LIKE', '%' . $query . '%')->get();

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

    public function search_song(Request $request)
    {
        $query = $request->input('query');
        $id = $request->input('id');
        $results = song::with('artist.user')->where('judul', 'like', '%' . $query . '%')->where('album_id', $id)->get();

        return response()->json(['results' => $results]);
    }

    protected function deleteNotif(Request $request, string $code)
    {
        try {
            $notif = notif::where('code', $code)->first();
            $notif->delete();
        } catch (\Throwable $th) {
            abort(404);
        }
        return redirect()->back();
    }

    protected function pencarian_input(Request $request)
    {

        $validate = Validator::make(
            $request->only('search'),
            [
                'search' => 'required|string|max:255',
            ],
        );

        if ($validate->fails()) {
            return redirect()->back()
                ->withErrors($validate)
                ->withInput();
        }


        $title = "MusiCave";
        $playlists = playlist::all();
        $search = $request->input('search');
        // dd($search);

        $song = song::where('judul', 'like', '%' .  $request->input('search') . '%')->first();
        $user = user::where('name', 'like', '%' .  $request->input('search') . '%')->first();
        $totalDidengar = DB::table('riwayat')->where('user_id', auth()->user()->id)->sum('song_id');
        $notifs = notif::with('user.artist.song')->where('user_id', auth()->user()->id)->get();
        if ($song) {
            $songs = song::all();
            $notifs = notif::with('user.artist.song')->where('user_id', auth()->user()->id)->get();
            return view('artis.search.songSearch', compact('song', 'search','title', 'songs', 'playlists', 'notifs'));
        } else if ($user) {
            $artis = artist::where('user_id', $user->id)->first();
            $songs = song::where('artis_id', $artis->id)->get();
            $notifs = notif::with('user.artist.song')->where('user_id', auth()->user()->id)->get();
            return view('artis.search.artisSearch', compact('user','title', 'search','songs', 'playlists', 'notifs', 'totalDidengar'));
        } else {
            return response()->view('artis.searchNotFound', compact('title','search', 'notifs'));
        }
    }

    protected function detailArtis(Request $request, string $code)
    {
        $title = 'MusiCave';
        try {
            $artis = artist::where('code', $code)->first();
            $artis_id = $artis->id;
            $user = User::where('id', $artis->user_id)->first();
            $songs = song::where('artis_id', $artis->id)->get();
            $notifs = notif::with('user.artist.song', 'song')->where('user_id', auth()->user()->id)->get();
            $totalDidengar = DB::table('riwayat')->where('user_id', auth()->user()->id)->sum('song_id');
            $playlists = playlist::all();
        } catch (\Throwable $th) {
            abort(404);
        }
        return view('artis.search.artisSearch', compact('user', 'artis_id', 'title', 'songs', 'playlists', 'notifs', 'totalDidengar'));
    }

    public function search_result(Request $request, string $code)
    {
        $title = "MusiCave";
        $playlists = playlist::all();
        $user = user::where('code', 'like', '%' .  $code . '%')->first();
        $song = song::where('code', 'like', '%' .  $code . '%')->first();
        $totalDidengar = DB::table('riwayat')->where('user_id', auth()->user()->id)->sum('song_id');
        $notifs = notif::with('user.artist.song', 'song')->where('user_id', auth()->user()->id)->get();

        if ($song) {
            $songs = song::all();
            $notifs = notif::with('user.artist.song', 'song')->where('user_id', auth()->user()->id)->get();
            return view('artis.search.songSearch', compact('song', 'title', 'songs', 'playlists', 'notifs'));
        } else if ($user) {
            $artis = artist::where('user_id', $user->id)->first();
            $artis_id = $artis->id;
            $songs = song::where('artis_id', $artis->id)->get();
            $notifs = notif::with('user.artist.song')->where('user_id', auth()->user()->id)->get();
            return view('artis.search.artisSearch', compact('user','artis_id','title', 'songs', 'playlists', 'notifs', 'totalDidengar'));
        } else {
            return response()->view('artis.searchNotFound', compact('title', 'notifs'));
        }
    }

    public function verified(Request $request)
    {
        $title = "MusiCave";
        $artis = artist::where('user_id', auth()->user()->id)->first();
        $notifs = notif::with('user.artist.song', 'song')->where('user_id', auth()->user()->id)->get();
        return response()->view('artis.verified', compact('title', 'artis', 'notifs'));
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
            $notifs = notif::with('user.artist.song', 'song')->where('user_id', auth()->user()->id)->get();
            $playlists = playlist::all();
        } catch (\Throwable $th) {
            return abort(404);
        }
        return response()->view('artis.playlist', compact('title', 'playlists', 'notifs'));
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
            return abort(404);
        }
        $notifs = notif::with('user.artist.song', 'song')->where('user_id', auth()->user()->id)->get();
        return response()->view('artis.playlist', compact('title', 'playlists', 'notifs'));
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
            $notifs = notif::with('user.artist.song', 'song')->where('user_id', auth()->user()->id)->get();
        } catch (\Throwable $th) {
            return abort(404);
        }
        return redirect()->back();
    }

    protected function detailPlaylist(string $code): Response
    {
        $playlistDetail = playlist::where('code', $code)->first();
        $playlist_id = $playlistDetail->id;
        $songs = song::where('playlist_id', $playlistDetail->id)->get();
        $playlists = playlist::all();
        $title = "MusiCave";
        $notifs = notif::with('user.artist.song', 'song')->where('user_id', auth()->user()->id)->get();
        return response()->view('artis.playlist.contoh', compact('title', 'playlist_id', 'playlistDetail', 'songs', 'playlists', 'notifs'));
    }

    protected function detailAlbum(string $code): Response
    {
        $albumDetail = album::where('code', $code)->first();
        $album_id = $albumDetail->id;
        $songs = song::all();
        $playlists = playlist::all();
        $title = "MusiCave";
        $notifs = notif::with('user.artist.song', 'song')->where('user_id', auth()->user()->id)->get();
        return response()->view('artis.playlist.contohAlbum', compact('title', 'album_id', 'albumDetail', 'songs', 'playlists', 'notifs'));
    }

    protected function contohPlaylist(): Response
    {
        $title = "MusiCave";
        $notifs = notif::with('user.artist.song', 'song')->where('user_id', auth()->user()->id)->get();
        return response()->view('artis.playlist.contoh', compact('title', 'notifs'));
    }

    protected function disukaiPlaylist(): Response
    {
        $title = "MusiCave";
        $notifs = notif::with('user.artist.song', 'song')->where('user_id', auth()->user()->id)->get();
        $songId = Like::where('user_id', Auth::user()->id)->pluck('song_id')->toArray();
        $song = song::whereIn('id', $songId)->get();
        return response()->view('artis.playlist.disukai', compact('title', 'song', 'notifs'));
    }

    protected function viewKolaborasi(Request $request)
    {
        $title = "Kolaborasi";
        $datas = projects::all();
        $notifs = notif::with('user.artist.song', 'song')->where('user_id', auth()->user()->id)->get();
        return response()->view('artis.kolaborasi', compact('title', 'datas', 'notifs'));
    }

    protected function viewLirikAndChat(Request $request, string $code)
    {
        $title = "Kolaborasi";
        $project = DB::table('projects')->where('code', $code)->first();
        $artis = artist::where('user_id', auth()->user()->id)->first();
        $datas = messages::with('messages')->get();
        $notifs = notif::with('user.artist.song', 'song')->where('user_id', auth()->user()->id)->get();
        try {
            projects::where('code', $project->code)->update(['penerima_project' => $artis->id]);
        } catch (\Throwable $th) {
            return abort(404);
        }
        return response()->view('artis.lirikAndChat', compact('title', 'project', 'datas', 'notifs'));
    }

    protected function showData(string $id)
    {
        $data = DB::table('projects')->where('code', $id)->get();
        $notifs = notif::with('user.artist.song', 'song')->where('user_id', auth()->user()->id)->get();
        return response()->view('artis.kolaborasi', compact('data', 'notifs'));
    }

    protected function logout(Request $request)
    {
        User::where('id', auth()->user()->id)->update(['is_login' => false]);
        try {
            Auth::logout();
        } catch (\Throwable $th) {
            return abort(404);
        }
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

        try {
            $project->update($data);
        } catch (Throwable $e) {
            return abort(404);
        }
        return response()->redirectTo('/artis/kolaborasi')->with('message', 'User created successfully.');
    }

    protected function message(Request $request)
    {
        $project = projects::where('id', $request->input('id_project'))->first();
        $user = artist::where('user_id', auth()->user()->id)->first();
        $message = messages::create([
            'code' => Str::uuid(),
            'sender_id' => $project->pembuat_project,
            'receiver_id' => $project->penerima_project,
            'project_id' => $project->id,
            'message' => $request->input('message')
        ]);
        try {
            $data = messages::with('messages')->get();
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
        $project = projects::where('code', $request->input('code'))->first();
        try {
            $data = [
                'code' => $project->code,
                'name' => $project->name,
                'genre' => $project->genre,
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

        try {
            $code = Str::uuid();
            projects::create(
                [
                    'code' => $code,
                    'name' => $request->input('name'),
                    'konsep' => $request->input('konsep'),
                    'judul' => "none",
                    'lirik' => "none",
                    'artist_id' => 0,
                    'is_approved' => false,
                    'is_reject' => false,
                ]
            );
        } catch (Throwable $e) {
            return abort(404);
        }
        return response()->redirectTo('/artis/kolaborasi')->with('message', 'User created successfully.');
    }
}
