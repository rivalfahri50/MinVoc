<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Like;
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
    }
