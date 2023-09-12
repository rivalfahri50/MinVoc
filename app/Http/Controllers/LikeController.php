<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\artist;
use App\Models\likeArtis;
use App\Models\song;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function likeCheck(song $song)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Pengguna tidak diotentikasi'], 401);
        }
        $data = likeArtis::where('user_id', $user->id)->get();
        return response()->json($data);
    }

    public function likeArtist(Request $request, artist $artist)
    {
       
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Pengguana tidak diotentifikasi'], 401);
        }
        if (likeArtis::where('user_id', $user->id)->where('artist_id', $artist->id)->exists()) {
            likeArtis::where('user_id', $user->id)->where('artist_id', $artist->id)->delete();
        $artist->decrement('likes');
        }else{
            likeArtis::create([
                'user_id' => $user->id,
                'artist_id' => $artist->id,
            ]);
            $artist->increment('likes');
        }
        return response()->json(['success' => true]);
    }

}
