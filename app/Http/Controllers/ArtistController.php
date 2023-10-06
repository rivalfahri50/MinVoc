<?php

namespace App\Http\Controllers;

use App\Models\album;
use App\Models\artist;
use App\Models\billboard;
use App\Models\genre;
use App\Models\Like;
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
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use getID3;
use RealRashid\SweetAlert\Facades\Alert;
use Throwable;
use Google_Client;
use Google_Service_Drive;
use Google_Service_Drive_DriveFile;


class ArtistController extends Controller
{
    protected function index(): Response
    {
        try {
            $songs = song::all();
            $song = song::where('is_approved', true)->where('didengar', '>', '1000')->orderByDesc('didengar')->get();
            $genres = genre::all();
            $artist = artist::with('user')->get();
            $playlists = playlist::all();
            $billboards = billboard::all();
            $notifs = notif::with('user.artist.song', 'song')->where('user_id', auth()->user()->id)->get();
        } catch (\Throwable $th) {
            return abort(404);
        }
        return response()->view('artis.dashboard', compact('songs', 'song', 'genres', 'artist', 'billboards', 'playlists', 'notifs'));
    }

    protected function playlist(): Response
    {
        try {
            $playlists = playlist::all();
            $albums = album::all();
            $notifs = notif::with('user.artist.song', 'song')->where('user_id', auth()->user()->id)->get();
        } catch (\Throwable $th) {
            return abort(404);
        }
        return response()->view('artis.playlist', compact('playlists', 'albums', 'notifs'));
    }

    protected function penghasilan(Request $request): Response
    {
        try {
            $projects = projects::all();
            $songs = song::where('is_approved', true)->get();
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
        } catch (\Throwable $th) {
            return abort(404);
        }
        return response()->view('artis.penghasilan', compact('month', 'totalpenghasilan', 'songs', 'penghasilan', 'projects', 'notifs', 'penghasilanArtis'));
    }

    protected function riwayat(): Response
    {
        try {
            $riwayat = Riwayat::all();
            $uniqueRows = $riwayat->unique(function ($item) {
                return $item->user_id . $item->song_id . $item->play_date;
            });
            $notifs = notif::with('user.artist.song', 'song')->where('user_id', auth()->user()->id)->get();
        } catch (\Throwable $th) {
            return abort(404);
        }
        return response()->view('artis.riwayat', compact('notifs', 'uniqueRows'));
    }

    protected function profile(string $code)
    {
        try {
            $user = artist::with('user')->where('user_id', $code)->first();
        } catch (\Throwable $th) {
            return abort(404);
        }
        return response()->json(['user' => $user]);
    }

    protected function profile_ubah(string $code): Response
    {
        try {
            $user = User::where('code', $code)->get();
            $notifs = notif::with('user.artist.song', 'song')->where('user_id', auth()->user()->id)->get();
        } catch (\Throwable $th) {
            return abort(404);
        }
        return response()->view('artis.profile.profile_ubah', compact('user', 'notifs'));
    }

    protected function tambah_playlist(string $code, Request $request)
    {
        try {
            $song = song::where('is_approved', true)->where('code', $code)->first();
            $song->playlist_id = $request->input('playlist_id');
            $song->update();
        } catch (\Throwable $th) {
            return abort(404);
        }
        return response()->redirectTo('/artis/playlist');
    }

    protected function buatAlbum(Request $request, string $code)
    {
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
            $user = User::where('code', $code)->first();
            $artist = Artist::where('user_id', $user->id)->first();
            $imagePath = $request->file('image')->store('images', 'public');

            album::create([
                'code' => Str::uuid(),
                'artis_id' => $artist->id,
                'name' => $request->input('name'),
                'image' => $imagePath,
            ]);

            $playlists = playlist::all();
            $albums = album::all();
            $notifs = notif::with('user.artist.song', 'song')->where('user_id', auth()->user()->id)->get();
        } catch (\Throwable $th) {
            return abort(404);
        }
        return response()->view('artis.playlist', compact('playlists', 'albums', 'notifs'));
    }

    protected function verifiedAccount(string $code, Request $request)
    {
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
            $user = User::where('code', $code)->first();
            $artist = Artist::where('user_id', $user->id)->first();
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

    protected function deleteSong(Request $request, string $code)
    {
        try {
            $music = song::where('is_approved', true)->where('code', $code)->first();
            $music->delete();
            Alert::success('message', 'berhasil menghapus lagu!');
        } catch (\Throwable $th) {
            return back();
        }
        return back();
    }

    protected function hapusPlaylist(string $code)
    {
        try {
            $playlist = Playlist::where('code', $code)->first();
            if (!$playlist) {
                return response()->redirectTo('artis/playlist');
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
        return response()->redirectTo('artis/playlist');
    }

    protected function filterDate(Request $request)
    {
        try {
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
        } catch (\Throwable $th) {
            return abort(404);
        }
        return redirect()->back()->with(['results' => $results])->withInput();
    }

    protected function hapusSongPlaylist(string $code)
    {
        try {
            $song = song::where('is_approved', true)->where('code', $code)->first();
            $song->playlist_id = null;
            $song->save();
        } catch (\Throwable $th) {
            return abort(404);
        }
        return redirect()->back();
    }

    protected function hapusAlbum(string $code)
    {
        try {
            $album = album::where('code', $code)->first();
            if (!$album) {
                return response()->redirectTo('artis/album');
            }
            if (Storage::disk('public')->exists($album->image)) {
                Storage::disk('public')->delete($album->image);
            }
            song::where('is_approved', true)->where('album_id', $album->id)->update(['album_id' => null]);
            $album->delete();
        } catch (\Throwable $th) {
            return abort(404);
        }

        return response()->redirectTo('/artis/playlist');
    }

    protected function viewUnggahAudio(Request $request): Response
    {
        try {
            $datas = song::with('artist')->where('is_approved', true)->get();
            $artis = artist::where('user_id', auth()->user()->id)->first();
            $genres = genre::all();
            $albums = album::with('artis')->get();
            $notifs = notif::with('user.artist.song', 'song')->where('user_id', auth()->user()->id)->get();
        } catch (\Throwable $th) {
            return abort(404);
        }
        return response()->view('artis.unggahAudio', compact('datas', 'genres', 'albums', 'artis', 'notifs'));
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
        $client->setAuthConfig(public_path('client_secret_351376302605-gpiholslclg7qng4barme2pbc9p7uk6a.apps.googleusercontent.com.json'));
        $client->setAccessType('offline');
        $client->setScopes(['https://www.googleapis.com/auth/drive']);
        $client->setAccessToken(['access_token' => 'ya29.a0AfB_byAn7PyPttpEskjiqUmUKcn2ujCrfXiP_uJUH5FJoGu_KuQ2FjUZ-UyW6izVdfj6idyyfUYA9mgtMMBQmhnevUF-TOpihxvy7WmAQRfL2Q_I8yW-_-WoDw2eo51-YzKxdCkTp19JRqXm1Yv-VRrZc3iitYmRG65RaCgYKASoSARASFQGOcNnC9DdQMQBGI-GbcgPem2kjMQ0171', 'refresh_token' => '1//049ykOLkzjfFoCgYIARAAGAQSNwF-L9Irbn3FX82sowJi_jWc-qDo4Ia9A-mfA-2xNOBwP8-J5jZi5zKxJ5LgA3hB8kGxDCd9fTQ']);

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
        try {

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
        try {
            $billboard = billboard::where('code', $code)->first();
            $artis_id = $billboard->artis_id;
            $albums = album::where('artis_id', $billboard->artis_id)->get();
            $songs = song::where('is_approved', true)->where('artis_id', $billboard->artis_id)->get();
            $playlists = playlist::all();
            $notifs = notif::with('user.artist.song', 'song')->where('user_id', auth()->user()->id)->get();
        } catch (\Throwable $th) {
            return abort(404);
        }
        return response()->view('artis.billboard.billboard', compact('billboard', 'artis_id', 'albums', 'songs', 'playlists', 'notifs'));
    }

    protected function albumBillboard(string $code): Response
    {
        try {
            $album = album::where('code', $code)->first();
            $album_id = $album->id;
            $songs = song::where('is_approved', true)->where('album_id', $album->id)->get();
            $playlists = playlist::all();
            $notifs = notif::with('user.artist.song', 'song')->where('user_id', auth()->user()->id)->get();
        } catch (\Throwable $th) {
            abort(404);
        }
        return response()->view('artis.billboard.album', compact('album_id', 'album', 'songs', 'playlists', 'notifs'));
    }

    protected function album(): Response
    {
        try {
            $notifs = notif::with('user.artist.song', 'song')->where('user_id', auth()->user()->id)->get();
        } catch (\Throwable $th) {
            return abort(404);
        }
        return response()->view('artis.billboard.album', compact('notifs'));
    }

    protected function kategori(string $code): Response
    {
        try {
            $genre = genre::where('code', $code)->first();
            $genre_id = $genre->id;
            $playlists = playlist::all();
            $songs = song::where('is_approved', true)->where('genre_id', $genre->id)->get();
            $notifs = notif::with('user.artist.song', 'song')->where('user_id', auth()->user()->id)->get();
        } catch (\Throwable $th) {
            return abort(404);
        }
        return response()->view('artis.kategori.kategori', compact('genre_id', 'genre', 'songs', 'playlists', 'notifs'));
    }

    protected function buatPlaylist(): Response
    {
        try {
            $songs = song::where('is_approved', true)->get();
            $notifs = notif::with('user.artist.song', 'song')->where('user_id', auth()->user()->id)->get();
        } catch (\Throwable $th) {
            return abort(404);
        }
        return response()->view('artis.playlist.buat', compact('songs', 'notifs'));
    }

    public function search(Request $request)
    {
        try {
            $query = $request->input('query');
            $songs = Song::where('is_approved', true)->where('judul', 'LIKE', '%' . $query . '%')->get();

            $users = User::where('name', 'LIKE', '%' . $query . '%')
                ->where('role_id', '!=', 3)
                ->where('role_id', '!=', 4)
                ->get();
            $results = [
                'songs' => $songs,
                'artists' => $users,
            ];
        } catch (\Throwable $th) {
            return abort(404);
        }
        return response()->json(['results' => $results]);
    }

    public function search_song(Request $request, string $code)
    {
        try {
            $query = $request->input('query');
            $id = $request->input('id');
            $playlist = playlist::where('code', $code)->first();
            $results = song::with('artist.user')->where('is_approved', true)->where('playlist_id', $playlist->id)->where('judul', 'like', '%' . $query . '%')->where('album_id', $id)->get();
        } catch (\Throwable $th) {
            return abort(404);
        }
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

        try {
            $playlists = playlist::all();
            $search = $request->input('search');

            $song = song::where('is_approved', true)->where('judul', 'like', '%' .  $request->input('search') . '%')->first();
            $user = user::where('name', 'like', '%' .  $request->input('search') . '%')->first();
            $totalDidengar = DB::table('riwayat')->where('user_id', auth()->user()->id)->sum('song_id');
            $notifs = notif::with('user.artist.song')->where('user_id', auth()->user()->id)->get();

            if ($song) {
                $songs = song::where('is_approved', true)->get();
                $notifs = notif::with('user.artist.song')->where('user_id', auth()->user()->id)->get();
                return view('artis.search.songSearch', compact('song', 'search', 'songs', 'playlists', 'notifs'));
            } else if ($user) {
                $artis = artist::where('user_id', $user->id)->first();
                $artis_id = $artis->id;
                $songs = song::where('is_approved', true)->where('artis_id', $artis->id)->get();
                $notifs = notif::with('user.artist.song')->where('user_id', auth()->user()->id)->get();
                return view('artis.search.artisSearch', compact('user', 'artis_id', 'search', 'songs', 'playlists', 'notifs', 'totalDidengar'));
            } else {
                return response()->view('artis.searchNotFound', compact('search', 'notifs'));
            }
        } catch (\Throwable $th) {
            return abort(404);
        }
    }

    protected function detailArtis(Request $request, string $code)
    {
        try {
            $artis = artist::where('code', $code)->first();
            $artis_id = $artis->id;
            $user = User::where('id', $artis->user_id)->first();
            $songs = song::where('is_approved', true)->where('artis_id', $artis->id)->get();
            $notifs = notif::with('user.artist.song', 'song')->where('user_id', auth()->user()->id)->get();
            $totalDidengar = DB::table('riwayat')->where('user_id', auth()->user()->id)->sum('song_id');
            $playlists = playlist::all();
        } catch (\Throwable $th) {
            abort(404);
        }
        return view('artis.search.artisSearch', compact('user', 'artis_id', 'songs', 'playlists', 'notifs', 'totalDidengar'));
    }

    public function search_result(Request $request, string $code)
    {
        try {
            $playlists = playlist::all();
            $user = user::where('code', 'like', '%' .  $code . '%')->first();
            $song = song::where('is_approved', true)->where('code', 'like', '%' .  $code . '%')->first();
            $totalDidengar = DB::table('riwayat')->where('user_id', auth()->user()->id)->sum('song_id');
            $notifs = notif::with('user.artist.song', 'song')->where('user_id', auth()->user()->id)->get();

            if ($song) {
                $songs = song::where('is_approved', true)->get();
                $notifs = notif::with('user.artist.song', 'song')->where('user_id', auth()->user()->id)->get();
                return view('artis.search.songSearch', compact('song', 'songs', 'playlists', 'notifs'));
            } else if ($user) {
                $artis = artist::where('user_id', $user->id)->first();
                $artis_id = $artis->id;
                $songs = song::where('is_approved', true)->where('artis_id', $artis->id)->get();
                $notifs = notif::with('user.artist.song')->where('user_id', auth()->user()->id)->get();
                return view('artis.search.artisSearch', compact('user', 'artis_id', 'songs', 'playlists', 'notifs', 'totalDidengar'));
            } else {
                return response()->view('artis.searchNotFound', compact('notifs'));
            }
        } catch (\Throwable $th) {
            return abort(404);
        }
    }

    public function verified(Request $request)
    {
        try {
            $artis = artist::where('user_id', auth()->user()->id)->first();
            $notifs = notif::with('user.artist.song', 'song')->where('user_id', auth()->user()->id)->get();
        } catch (\Throwable $th) {
            return abort(404);
        }
        return response()->view('artis.verified', compact('artis', 'notifs'));
    }

    protected function storePlaylist(Request $request): Response
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
            $notifs = notif::with('user.artist.song', 'song')->where('user_id', auth()->user()->id)->get();
            $playlists = playlist::all();
        } catch (\Throwable $th) {
            return abort(404);
        }
        return response()->view('artis.playlist', compact('playlists', 'notifs'));
    }

    protected function ubahPlaylist(Request $request, string $code)
    {
        try {
            $playlists = playlist::where('code', $code)->first();
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
        return response()->view('artis.playlist', compact('playlists', 'notifs'));
    }

    protected function ubahAlbum(Request $request, string $code)
    {
        try {
            $album = album::where('code', $code)->first();
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
            // $notifs = notif::with('user.artist.song', 'song')->where('user_id', auth()->user()->id)->get();
        } catch (\Throwable $th) {
            return abort(404);
        }
        return redirect()->back();
    }

    protected function detailPlaylist(string $code): Response
    {
        try {
            $playlistDetail = playlist::where('code', $code)->first();
            $playlist_id = $playlistDetail->id;
            $songs = song::where('is_approved', true)->where('playlist_id', $playlistDetail->id)->get();
            $playlists = playlist::all();
            $notifs = notif::with('user.artist.song', 'song')->where('user_id', auth()->user()->id)->get();
        } catch (\Throwable $th) {
            return abort(404);
        }
        return response()->view('artis.playlist.contoh', compact('playlist_id', 'playlistDetail', 'songs', 'playlists', 'notifs'));
    }

    protected function detailAlbum(string $code): Response
    {
        try {
            $albumDetail = album::where('code', $code)->first();
            $album_id = $albumDetail->id;
            $songs = song::where('is_approved', true)->get();
            $playlists = playlist::all();
            $notifs = notif::with('user.artist.song', 'song')->where('user_id', auth()->user()->id)->get();
        } catch (\Throwable $th) {
            return abort(404);
        }
        return response()->view('artis.playlist.contohAlbum', compact('album_id', 'albumDetail', 'songs', 'playlists', 'notifs'));
    }

    protected function contohPlaylist(): Response
    {
        try {
            $notifs = notif::with('user.artist.song', 'song')->where('user_id', auth()->user()->id)->get();
        } catch (\Throwable $th) {
            return abort(404);
        }
        return response()->view('artis.playlist.contoh', compact('notifs'));
    }

    protected function disukaiPlaylist(): Response
    {
        try {
            $notifs = notif::with('user.artist.song', 'song')->where('user_id', auth()->user()->id)->get();
            $songId = Like::where('user_id', Auth::user()->id)->pluck('song_id')->toArray();
            $song = song::where('is_approved', true)->whereIn('id', $songId)->get();
        } catch (\Throwable $th) {
            return abort(404);
        }
        return response()->view('artis.playlist.disukai', compact('song', 'notifs'));
    }

    protected function viewKolaborasi(Request $request)
    {
        try {
            $title = "Kolaborasi";
            $datas = projects::all();
            $notifs = notif::with('user.artist.song', 'song')->where('user_id', auth()->user()->id)->get();
        } catch (\Throwable $th) {
            return abort(404);
        }
        return response()->view('artis.kolaborasi', compact('datas', 'notifs'));
    }

    protected function viewLirikAndChat(Request $request, string $code)
    {
        try {
            $project = DB::table('projects')->where('code', $code)->first();
            $artis = artist::where('user_id', auth()->user()->id)->first();
            $datas = messages::with('messages')->get();
            $notifs = notif::with('user.artist.song', 'song')->where('user_id', auth()->user()->id)->get();
            projects::where('code', $project->code)->update(['penerima_project' => $artis->id]);
        } catch (\Throwable $th) {
            return abort(404);
        }
        return response()->view('artis.lirikAndChat', compact('project', 'datas', 'notifs'));
    }

    protected function showData(string $id)
    {
        try {
            $data = DB::table('projects')->where('code', $id)->get();
            $notifs = notif::with('user.artist.song', 'song')->where('user_id', auth()->user()->id)->get();
        } catch (\Throwable $th) {
            return abort(404);
        }
        return response()->view('artis.kolaborasi', compact('data', 'notifs'));
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

        try {
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
            $project->update($data);
        } catch (Throwable $e) {
            return abort(404);
        }
        return response()->redirectTo('/artis/kolaborasi')->with('message', 'User created successfully.');
    }

    protected function message(Request $request)
    {
        $project = projects::where('id', $request->input('id_project'))->first();
        try {
            $message = messages::create([
                'code' => Str::uuid(),
                'sender_id' => $project->pembuat_project,
                'receiver_id' => $project->penerima_project,
                'project_id' => $project->id,
                'message' => $request->input('message')
            ]);
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
        try {
            $project = projects::where('code', $request->input('code'))->first();
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
