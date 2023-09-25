<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Like;
use App\Models\Song;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
            return response()->json(['message' => 'play count update sukses']);
        } else {
            return response()->json(['message' => 'song not found'], 404);
        }
    }

    public function ambilLaguArtist($artistId){
         // Mengambil lagu berdasarkan artistId yang diberikan
         $laguArtis = Song::whereHas('artis_id', function ($query) use ($artistId) {
            $query->where('id', $artistId);
        })->get();
        return response()->json($laguArtis);
    }

    public function ambilLaguAlbum(Request $request) {
        $albumId = $request->input('album_id');
        $query = Song::with('artist.user');

        // Tambahkan filter berdasarkan album_id jika ada
        if ($albumId) {
            $query->where('album_id', $albumId);
        }

        $lagu = $query->get();

        return response()->json($lagu);
    }
    public function ambilLaguPlaylist(Request $request) {
        $playlistId = $request->input('playlist_id');
        $query = Song::with('artist.user');

        // Tambahkan filter berdasarkan album_id jika ada
        if ($playlistId) {
            $query->where('playlist_id', $playlistId);
        }

        $lagu = $query->get();

        return response()->json($lagu);
    }
    }
