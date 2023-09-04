<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Song;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SongController extends Controller
{
    protected function ambillagu()
    {
        $lagu = Song::with('artist.user')->get();
        return response()->json($lagu);
    }

    protected function toggleLike(Request $request, Song $song)
    {
        $isLiked = $request->input('isLiked');

        $song->update(['likes' => $isLiked ? $song->likes + 1 : $song->likes - 1]);

        // Simpan status suka ke sesi setelah memperbarui database
        session(['song_' . $song->id . '_liked' => $isLiked]);
        return response()->json(['success' => true]);

        // Ambil daftar lagu
        $songs = Song::all();
        return view('user.components.usersTemplates', compact('songs'));
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
}
