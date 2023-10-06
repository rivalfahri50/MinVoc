<?php

namespace App\Http\Controllers;

use App\Models\admin;
use App\Models\album;
use App\Models\artist;
use App\Models\aturanPembayaran;
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
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use getID3;
use Illuminate\Support\Facades\Cache;
use RealRashid\SweetAlert\Facades\Alert;
use Throwable;
use Google_Client;
use Google_Service_Drive;
use GuzzleHttp\Psr7\Utils;
use GuzzleHttp\Psr7\stream_for;
use Google_Service_Drive_DriveFile;
use GuzzleHttp\Psr7\Request as Psr7Request;
use GuzzleHttp\Client as GuzzleClient;

class ArtistVerifiedController extends Controller
{
    protected function index(): Response
    {
        $title = "MusiCave";
        $song = song::where('didengar', '>', '1000')->orderByDesc('didengar')->get();
        $songs = song::all();
        $genres = genre::all();
        $playlists = playlist::all();
        $artist = artist::with('user')->get();
        $billboards = billboard::all();
        $artistid = (int) artist::where('user_id', auth()->user()->id)->first()->id;
        $totalpenghasilan = penghasilan::where('artist_id', $artistid)->sum('penghasilan');
        $notifs = notif::with('user.artist.song', 'song')->where('user_id', auth()->user()->id)->get();
        $artistid = (int) artist::where('user_id', auth()->user()->id)->first()->id;
        $totalpenghasilan = penghasilan::where('artist_id', $artistid)->sum('penghasilan');
        return response()->view('artisVerified.dashboard', compact('title', 'songs', 'song', 'genres', 'artist', 'billboards', 'playlists', 'notifs', 'totalpenghasilan'));
    }

    protected function playlist(): Response
    {
        $title = "MusiCave";
        $playlists = playlist::all();
        $albums = album::all();
        $notifs = notif::with('user.artist.song', 'song')->where('user_id', auth()->user()->id)->get();
        return response()->view('artisVerified.playlist', compact('title', 'playlists', 'albums', 'notifs'));
    }

    protected function penghasilan(Request $request): Response
    {
        $title = "MusiCave";
        $totalPengguna = User::count();
        $totalLagu = song::count();
        $totalArtist = artist::count();
        $songs = song::all();
        $songs = song::all();
        $projects = projects::where('status', 'accept')->get();
        $artistid = (int) artist::where('user_id', auth()->user()->id)->first()->id;
        $penghasilan = penghasilan::where('artist_id', $artistid)->pluck('penghasilanCair')->toArray();
        $penghasilanArtis = penghasilan::with('artist')->where('artist_id', $artistid)->where('is_submit', false)->get();
        $totalpenghasilan = penghasilan::where('artist_id', $artistid)->sum('penghasilan');
        $penghasilanData = penghasilan::where('artist_id', $artistid)->where('is_take', false)->first();
        if (isset($penghasilanData->Pengajuan)) {
            $penghasilanData = penghasilan::where('artist_id', $artistid)->where('Pengajuan', $penghasilanData->Pengajuan)->latest('terakhir_diambil')->first();
        }
        // $month = penghasilan::where('artist_id', $artistid)->pluck('bulan')->toArray();
        $month = [];

        // dd($totalpenghasilan);
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
        return response()->view('artisVerified.penghasilan', compact('title', 'totalpenghasilan', 'month', 'totalPengguna', 'totalLagu', 'totalArtist', 'songs', 'penghasilan', 'projects', 'notifs', 'penghasilanData', 'penghasilanArtis'));
    }

    protected function riwayatPenghasilan(Request $request)
    {
        $title = 'MusiCave';
        $artis = artist::where('user_id', auth()->user()->id)->first();
        $penghasilan = penghasilan::with('artist')->where('is_submit', true)->where('artist_id', $artis->id)->get();
        $notifs = notif::with('user.artist.song', 'song')->where('user_id', auth()->user()->id)->get();
        return response()->view('artisVerified.riwayatpenghasilan', compact('title', 'notifs', 'penghasilan'));
    }

    protected function pencairan()
    {
        $artistid = (int) artist::where('user_id', auth()->user()->id)->first()->id;
        $penghasilanData = penghasilan::where('artist_id', $artistid)->get();
        $totalPenghasilan = $penghasilanData->sum('penghasilan');
        $totalPenghasilanFormatted = number_format($totalPenghasilan, 0, ',', '.');

        return response()->json(['total_penghasilan' => $totalPenghasilanFormatted]);
    }

    protected function pencairanDana(Request $request, string $code)
    {
        try {
            $artis = artist::where('user_id', $code)->first();
            $penghasilan = penghasilan::where('artist_id', $artis->id)->get();
            foreach ($penghasilan as $p) {
                $data = $p->penghasilan;
                $data = [
                    'is_take' => true,
                    'Pengajuan' => (int) str_replace('.', '', $data),
                    'Pengajuan_tanggal' => now()
                ];
                $p->update($data);
            }
        } catch (\Throwable $th) {
            Alert::error('message', 'Permintaan gagal terkirim');
        }
        Alert::success('message', 'Permintaan telah terkirim');
        return redirect()->back();
    }

    protected function riwayat(): Response
    {
        $title = "MusiCave";
        $riwayat = Riwayat::all();
        $notifs = notif::with('user.artist.song', 'song')->where('user_id', auth()->user()->id)->get();

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
        $notifs = notif::with('user.artist.song', 'song')->where('user_id', auth()->user()->id)->get();
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
        Alert::success('message', 'Berhasil mengundang');
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
            $notifs = notif::with('user.artist.song', 'song')->where('user_id', auth()->user()->id)->get();
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
            Alert::error('message', 'Profile gagal di perbarui');
            return redirect()->back();
        }
        Alert::success('message', 'Profile berhasil di perbarui');
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
        $albums = album::with('artis')->get();
        $notifs = notif::with('user.artist.song', 'song')->where('user_id', auth()->user()->id)->get();
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
                'is_approved' => false,
                'type' => 'pengajuan',
                'genre_id' => $request->input('genre'),
                'album_id' => $request->input('album') == null ? null : $request->input('album'),
                'artis_id' => $artis->id,
            ]);
            DB::commit();

            Alert::success('message', 'Lagu berhasil di upload, tunggu admin untuk publish');
            return redirect('/artis-verified/unggahAudio')->with('success', 'Song uploaded successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();
            Alert::error('message', 'Lagu gagal di upload');
            return abort(404);
        }
    }


    protected function billboard(string $code): Response
    {
        try {
            $title = "MusiCave";
            $billboard = billboard::where('code', $code)->first();
            $artis_id = $billboard->artis_id;
            $albums = album::where('artis_id', $billboard->artis_id)->get();
            $songs = song::where('artis_id', $billboard->artis_id)->get();
            $playlists = playlist::all();
            $notifs = notif::with('user.artist.song', 'song')->where('user_id', auth()->user()->id)->get();
        } catch (\Throwable $th) {
            abort(404);
        }
        return response()->view('artisVerified.billboard.billboard', compact('title', 'billboard', 'artis_id', 'albums', 'songs', 'playlists', 'notifs'));
    }

    protected function albumBillboard(string $code): Response
    {
        $title = "MusiCave";
        try {
            $album = album::where('code', $code)->first();
            $songs = song::where('album_id', $album->id)->get();
            $playlists = playlist::all();
            $album_id = $album->id;
            $notifs = notif::with('user.artist.song', 'song')->where('user_id', auth()->user()->id)->get();
        } catch (\Throwable $th) {
            abort(404);
        }
        return response()->view('artisVerified.billboard.album', compact('title', 'album', 'songs', 'playlists', 'notifs', 'album_id'));
    }

    protected function album(): Response
    {
        $title = "MusiCave";
        $notifs = notif::with('user.artist.song', 'song')->where('user_id', auth()->user()->id)->get();
        return response()->view('artisVerified.billboard.album', compact('title', 'notifs'));
    }

    protected function kategori(string $code): Response
    {
        $title = "MusiCave";
        $genre = genre::where('code', $code)->first();
        $genre_id = $genre->id;
        $playlists = playlist::all();
        $songs = song::where('genre_id', $genre->id)->get();
        $genre_id = $genre->id;
        $notifs = notif::with('user.artist.song', 'song')->where('user_id', auth()->user()->id)->get();
        return response()->view('artisVerified.kategori.kategori', compact('title', 'genre', 'playlists', 'songs', 'notifs', 'genre_id'));
    }

    protected function buatPlaylist(): Response
    {
        $title = "MusiCave";
        $songs = song::all();
        $notifs = notif::with('user.artist.song', 'song')->where('user_id', auth()->user()->id)->get();
        return response()->view('artisVerified.playlist.buat', compact('title', 'songs', 'notifs'));
    }

    protected function deleteNotif(Request $request, string $code)
    {
        $notif = notif::where('code', $code)->first();
        $notif->delete();
        try {
        } catch (\Throwable $th) {
            abort(404);
        }
        return redirect()->back();
    }

    protected function deleteSong(Request $request, string $code)
    {
        try {
            $music = song::where('code', $code)->first();

            if (Storage::disk('public')->exists($music->audio)) {
                Storage::disk('public')->delete($music->audio);
            }

            if (Storage::disk('public')->exists($music->image)) {
                Storage::disk('public')->delete($music->image);
            }

            $music->delete();
            Alert::success('message', 'berhasil menghapus lagu!');
        } catch (\Throwable $th) {
            return back();
        }
        return back();
    }

    protected function search(Request $request)
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

    protected function filterDatePencairan(Request $request)
    {
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $startDate = $request->start_date;
        $endDate = $request->end_date;

        $start_date = Carbon::parse($startDate)->startOfDay();
        $end_date = Carbon::parse($endDate)->endOfDay();

        $results = penghasilan::with('artist')->whereBetween('Pengajuan_tanggal', [$start_date, $end_date])->where('is_submit', true)
            ->get();

        return redirect()->back()->with(['results' => $results])->withInput();
    }

    protected function pencarian_input(Request $request)
    {
        $title = "MusiCave";
        $playlists = playlist::all();
        $song = song::where('judul', 'like', '%' .  $request->input('search') . '%')->first();
        $user = user::where('name', 'like', '%' .  $request->input('search') . '%')->first();
        $totalDidengar = DB::table('riwayat')->where('user_id', auth()->user()->id)->sum('song_id');
        $notifs = notif::with('user.artist.song', 'song')->where('user_id', auth()->user()->id)->get();

        if ($song) {
            $songs = song::all();
            return view('artisVerified.search.songSearch', compact('song', 'title', 'songs', 'playlists', 'notifs', 'totalDidengar'));
        } else if ($user) {
            $artis = artist::where('user_id', $user->id)->first();
            $artis_id = $artis->id;
            $songs = song::where('artis_id', $artis->id)->get();
            return view('artisVerified.search.artisSearch', compact('user', 'title', 'songs', 'playlists', 'notifs', 'artis', 'totalDidengar'));
        } else {
            return response()->view('artisverified.searchNotFound', compact('title', 'notifs'));
        }
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
            return view('artisverified.search.songSearch', compact('song', 'title', 'songs', 'playlists', 'notifs', 'totalDidengar'));
        } else if ($user) {
            $artis = artist::where('user_id', $user->id)->first();
            $artis_id = $artis->id;
            $songs = song::where('artis_id', $artis->id)->get();
            $notifs = notif::with('user.artist.song', 'song')->where('user_id', auth()->user()->id)->get();
            return view('artisverified.search.artisSearch', compact('user', 'title', 'songs', 'playlists', 'notifs', 'totalDidengar'));
        } else {
            return response()->view('artisverified.searchNotFound', compact('title', 'notifs'));
        }
    }

    protected function detailArtis(Request $request, string $code)
    {
        $title = 'MusiCave';
        try {
            $artis = artist::where('code', $code)->first();
            $user = User::where('id', $artis->user_id)->first();
            $songs = song::where('artis_id', $artis->id)->get();
            $notifs = notif::with('user.artist.song', 'song')->where('user_id', auth()->user()->id)->get();
            $totalDidengar = DB::table('riwayat')->where('user_id', auth()->user()->id)->sum('song_id');
            $playlists = playlist::all();
            $artis_id = $artis->id;
        } catch (\Throwable $th) {
            abort(404);
        }
        return view('artisVerified.search.artisSearch', compact('user', 'title', 'songs', 'playlists', 'notifs', 'totalDidengar'));
    }


    public function search_song(Request $request, string $code)
    {
        $query = $request->input('query');
        $id = $request->input('id');
        $playlist = playlist::where('code', $code)->first();
        $results = song::with('artist.user')->where('playlist_id', $playlist->id)->where('judul', 'like', '%' . $query . '%')->where('album_id', $id)->get();

        return response()->json(['results' => $results]);
    }

    protected function storePlaylist(Request $request): Response
    {
        $title = "MusiCave";
        $notifs = notif::with('user.artist.song', 'song')->where('user_id', auth()->user()->id)->get();
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
        $notifs = notif::with('user.artist.song', 'song')->where('user_id', auth()->user()->id)->get();

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
        $notifs = notif::with('user.artist.song', 'song')->where('user_id', auth()->user()->id)->get();

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
        return response()->view('artisVerified.playlist.contoh', compact('title', 'playlist_id', 'playlistDetail', 'songs', 'playlists', 'notifs'));
    }

    protected function detailAlbum(string $code): Response
    {
        $albumDetail = album::where('code', $code)->first();
        $songs = song::all();
        $album_id = $albumDetail->id;
        $playlists = playlist::all();
        $title = "MusiCave";
        $notifs = notif::with('user.artist.song', 'song')->where('user_id', auth()->user()->id)->get();

        return response()->view('artisVerified.playlist.contohAlbum', compact('title', 'albumDetail', 'songs', 'playlists', 'notifs', 'album_id'));
    }

    protected function contohPlaylist(): Response
    {
        $title = "MusiCave";
        $notifs = notif::with('user.artist.song', 'song')->where('user_id', auth()->user()->id)->get();
        return response()->view('artisVerified.playlist.contoh', compact('title', 'notifs'));
    }

    protected function disukaiPlaylist(): Response
    {
        $title = "MusiCave";
        $songId = Like::where('user_id', Auth::user()->id)->pluck('song_id')->toArray();
        $song = song::whereIn('id', $songId)->get();
        $notifs = notif::with('user.artist.song', 'song')->where('user_id', auth()->user()->id)->get();
        return response()->view('artisVerified.playlist.disukai', compact('title', 'song', 'notifs'));
    }

    protected function viewKolaborasi(Request $request)
    {
        $title = "Kolaborasi";
        $datas = projects::with(['artis', 'artis2'])->get();
        $project_id = empty($datas->first()->id) ? 0 : $datas->first()->id;
        $artisUser = artist::where('user_id', auth()->user()->id)->first();
        $messages = messages::with(['sender.user', 'receiver', 'project'])->get();
        $notifs = notif::with('user.artist.song', 'song')->where('user_id', auth()->user()->id)->get();
        $artis = artist::with('user')->get();

        return response()->view('artisVerified.kolaborasi', compact('title', 'datas', 'project_id', 'artisUser', 'messages', 'artis', 'notifs'));
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
            $genre = genre::all();
            $project = projects::where('code', $code)->first();
            $artis = artist::where('user_id', auth()->user()->id)->first();
            $messages = messages::with(['sender', 'project'])->where('project_id', $project->id)->get();
            projects::where('code', $project->code)->update(['penerima_project' => $artis->id]);
            $notifs = notif::with('user.artist.song', 'song')->where('user_id', auth()->user()->id)->get();
            $pendapatan = aturanPembayaran::where('opsi_id', 3)->first();
            $uang =  isset($pendapatan->pendapatanArtis) != null ? $pendapatan->pendapatanArtis : 30000;
            if ($artis->id === $project->request_project_artis_id_1 || $artis->id === $project->request_project_artis_id_2) {
                $project->update(['is_take' => true]);
            }
        } catch (\Throwable $th) {
            return abort(404);
        }
        return response()->view('artisVerified.lirikAndChat', compact('title', 'project', 'messages', 'notifs', 'artis', 'genre', 'uang'));
    }

    protected function showData(string $id)
    {
        $data = DB::table('projects')->where('code', $id)->get();

        $notifs = notif::with('user.artist.song', 'song')->where('user_id', auth()->user()->id)->get();
        return response()->view('artisVerified.kolaborasi', compact('data', 'notifs'));
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

        $pendapatan = aturanPembayaran::where('opsi_id', 3)->first();
        $project = projects::where('code', $code)->first();

        $range = $request->input('range');

        if ($range < 40) {
            $persentase = 40;
        } elseif ($range > 80) {
            $persentase = 80;
        }

        $uangTetap = isset($pendapatan->pendapatanArtis) != null ? $pendapatan->pendapatanArtis : 28000;
        $uangYangDiterima = ($range / 100) * $uangTetap;


        if (isset($project->request_project_artis_id_1) || isset($project->request_project_artis_id_2)) {
            $sisaPengasilan = $uangTetap - $uangYangDiterima;
            penghasilan::create([
                'artist_id' => $project->request_project_artis_id_1,
                'penghasilan' => $sisaPengasilan,
                'status' => 'kolaborasi',
                'is_take' => false,
                'bulan' =>  date('n')
            ]);
            if ($project->request_project_artis_id_1 !== null && $project->request_project_artis_id_2 !== null) {
                penghasilan::create([
                    'artist_id' => $project->request_project_artis_id_1,
                    'penghasilan' => $sisaPengasilan / 2,
                    'status' => 'kolaborasi',
                    'bulan' =>  date('n'),
                    'is_take' => false,
                ]);

                penghasilan::create([
                    'artist_id' => $project->request_project_artis_id_2,
                    'penghasilan' => $sisaPengasilan / 2,
                    'status' => 'kolaborasi',
                    'bulan' =>  date('n'),
                    'is_take' => false,
                ]);
            }
        }

        penghasilan::create([
            'artist_id' => artist::where('user_id', auth()->user()->id)->first()->id,
            'penghasilan' => $uangYangDiterima,
            'status' => 'kolaborasi',
            'is_take' => false,
            'bulan' =>  date('n')
        ]);
        $admin = admin::where('user_id', 1)->first();
        $penghasilanSaatIni = $admin->penghasilan;
        $jumlahTambahan = isset($pendapatan->pendapatanAdmin) != null ? $pendapatan->pendapatanAdmin : 2000;
        $penghasilanBaru = $penghasilanSaatIni + $jumlahTambahan;
        $admin->update(['penghasilan' => $penghasilanBaru]);

        try {

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

            $images = $request->file('images')->store('images', 'public');
            $data = [
                'code' => $project->code,
                'name' => $project->name,
                'konsep' => $project->konsep,
                'judul' => $request->input('name'),
                'images' => $images,
                'audio' => $file->id,
                'harga' => $uangYangDiterima,
                'status' => "accept",
                'pembuat_project' => Auth::user()->id,
                'is_approved' => true,
                'is_reject' => false,
            ];

            $getID3 = new getID3();
            $audioInfo = $getID3->analyze($request->file('audio')->path());
            $durationInSeconds = $audioInfo['playtime_seconds'];
            $durationMinutes = floor($durationInSeconds / 60);
            $durationSeconds = $durationInSeconds % 60;
            $formattedDuration = sprintf('%02d:%02d', $durationMinutes, $durationSeconds);

            $artis = artist::where('user_id', auth()->user()->id)->first();

            song::create([
                'code' => $code,
                'judul' => $request->input('name'),
                'image' => $images,
                'audio' => $file->id,
                'waktu' => $formattedDuration,
                'is_approved' => true,
                'genre_id' => $request->input('genre'),
                'album_id' => $request->input('album') == null ? null : $request->input('album'),
                'artis_id' => $artis->id,
            ]);

            $project->update($data);
        } catch (Throwable $e) {
            return abort(404);
        }
        Alert::success('message', 'Project berhasil di buat');
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
            Alert::erorr('message', 'Project Kolaborasi Gagal Di Hapus');
            return abort(404);
        }
        Alert::success('message', 'Project Kolaborasi Berhasil Di Hapus');
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
            $artis = artist::where('user_id', auth()->user()->id)->first();
            $code = Str::uuid();
            projects::create(
                [
                    'code' => $code,
                    'name' => $request->input('name'),
                    'konsep' => $request->input('konsep'),
                    'artist_id' => $artis->id,
                ]
            );
        } catch (Throwable $e) {
            Alert::error('message', 'Project Gagal Di Buat');
            return redirect()->back();
        }
        Alert::success('message', 'Project Berhasil Di Buat, Silakan Berkolaborasi');
        return response()->redirectTo('/artis-verified/kolaborasi')->with('message', 'User created successfully.');
    }

    protected function bayar(Request $request, string $code)
    {
        // dd($code);
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
