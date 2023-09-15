<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\artist;
use App\Models\penghasilan;
use App\Models\Riwayat;
use App\Models\song;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RiwayatController extends Controller
{
    public function simpanRiwayat(Request $request)
    {

        // Simpan riwayat pemutaran lagu ke dalam database
        $user_id = Auth::user()->id;
        $song_id = $request->song_id;
        $play_date = Carbon::now()->format('Y-m-d H:i:s');

        $penghasilanArtist = (int) song::findOrFail($song_id)->artist->penghasilan + 35000;
        $artist_id =  song::findOrFail($song_id)->artist->id;
        $cek_penghasilan = penghasilan::updateOrCreate(['artist_id'=> $artist_id, 'bulan' => Carbon::now()->format('m')],['penghasilan'=>(string)$penghasilanArtist]);
        artist::findOrFail($artist_id)->update(['penghasilan' => $penghasilanArtist]);

        Log::info("Mencoba menyimpan riwayat: user_id=$user_id, song_id=$song_id, play_date=$play_date");

        Riwayat::create([
            'user_id' => $user_id,
            'song_id' => $song_id,
            'play_date' => $play_date,
        ]);

        Log::info("Riwayat lagu disimpan");

        return response()->json(['message' => 'Riwayat lagu disimpan']);
    }
}
