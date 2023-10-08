<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\admin;
use App\Models\artist;
use App\Models\aturanPembayaran;
use App\Models\Like;
use App\Models\penghasilan;
use App\Models\projects;
use App\Models\Song;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class SongController extends Controller
{
    protected function ambillagu(Request $request)
    {
        $genreId = $request->input('genre_id');
        $query = Song::with('artist.user');
        if ($genreId) {
            $query->where('genre_id', $genreId);
        }

        $lagu = $query->get();

        return response()->json($lagu);
    }

    protected function ambilLikeLagu(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Pengguna tidak diotentikasi'], 401);
        }
        $likedSongIds = $user->likedSongs->pluck('id')->toArray();

        $genreId = $request->input('genre_id');
        $query = Song::with('artist.user');

        if ($genreId) {
            $query->where('genre_id', $genreId);
        }
        $query->whereIn('id', $likedSongIds);

        $lagu = $query->get();

        return response()->json($lagu);
    }

    public function cekLike(Song $song)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Pengguna tidak diotentikasi'], 401);
        }
        $data = Like::where('user_id', $user->id)->get();
        return response()->json($data);
    }
    protected function toggleLike(Request $request, Song $song)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Pengguna tidak diotentikasi'], 401);
        }
        if (Like::where('user_id', $user->id)->where('song_id', $song->id)->exists()) {
            Like::where('user_id', $user->id)->where('song_id', $song->id)->delete();
            $song->decrement('likes');
        } else {
            Like::create([
                'user_id' => $user->id,
                'song_id' => $song->id,
            ]);
            $song->increment('likes');
        }
        return response()->json(['success' => true]);
    }


    public function playCount($song_id)
    {
        $song = Song::find($song_id);
        if ($song) {
            $song->increment('didengar');
            if ($song->didengar % 1000 === 0) {
                $admin = admin::where('user_id', 1)->first();
                $penghasilanSaatIni = $admin->penghasilan;
                $jumlahTambahan = 200;
                $penghasilanBaru = $penghasilanSaatIni + $jumlahTambahan;
                $admin->update(['penghasilan' => $penghasilanBaru]);

                $pendapatan = aturanPembayaran::where('opsi_id', 1)->first();
                $artist_id =  song::findOrFail($song_id)->artist->id;

                $penghasilanArtist = isset($pendapatan->pendapatanArtis) != null ? $pendapatan->pendapatanArtis : 2000;
                artist::findOrFail($artist_id)->update(['penghasilan' => song::findOrFail($song_id)->artist->penghasilan + $penghasilanArtist]);
                // $cek_penghasilan = penghasilan::create(['artist_id' => $artist_id, 'bulan' => Carbon::now()->format('m'), 'penghasilan' => (string)$penghasilanArtist, 'status' => "riwayat lagu"]);
                penghasilan::create(['artist_id' => $artist_id, 'bulan' => Carbon::now()->format('m'), 'penghasilan' => (string)$penghasilanArtist, 'status' => "riwayat lagu"]);
            }
            return response()->json(['message' => 'play count update sukses']);
        } else {
            return response()->json(['message' => 'song not found'], 404);
        }
    }

    public function ambilLaguAlbum(Request $request)
    {
        $albumId = $request->input('album_id');
        $query = Song::with('artist.user');

        // Tambahkan filter berdasarkan album_id jika ada
        if ($albumId) {
            $query->where('album_id', $albumId);
        }

        $lagu = $query->get();

        return response()->json($lagu);
    }

    public function ambilLaguArtist(Request $request)
    {
        $artistId = $request->input('artis_id');
        $query = Song::with('artist.user');
        if ($artistId) {
            $query->where('artis_id', $artistId);
        }
        $lagu = $query->get();
        // Kemudian, Anda dapat mengembalikan data lagu sebagai respons JSON
        return response()->json($lagu);
    }

    public function ambilLaguPlaylist(Request $request)
    {
        $playlistId = $request->input('playlist_id');
        $query = Song::with('artist.user');

        // Tambahkan filter berdasarkan album_id jika ada
        if ($playlistId) {
            $query->where('playlist_id', $playlistId);
        }

        $lagu = $query->get();

        return response()->json($lagu);
    }

    // public function ambilLaguProject(Request $request)
    // {
    //     $projectId = $request->input('project_id');
    //     $lagu = projects::where('id', $projectId)->get();
    //     return response()->json($lagu);
    // }
    public function ambilLaguProject(Request $request)
    {
        $projectId = $request->input('id');
        $query = projects::with('artis.user');

        // Tambahkan filter berdasarkan album_id jika ada
        if ($projectId) {
            $query->where('project_id', $projectId);
        }

        $lagu = $query->get();

        return response()->json($lagu);
    }
}
