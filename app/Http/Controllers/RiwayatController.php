<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Riwayat;
use Illuminate\Http\Request;

class RiwayatController extends Controller
{
    public function simpanRiwayat(Request $request)
{
    // Validasi input yang diterima
    $request->validate([
        'user_id' => 'required|integer',
        'song_id' => 'required|integer',
        'play_date' => 'required|date',
    ]);

    // Simpan riwayat pemutaran lagu ke dalam database
    Riwayat::create([
        'user_id' => $request->input('user_id'),
        'song_id' => $request->input('song_id'),
        'play_date' => $request->input('play_date'),
    ]);

    return response()->json(['message' => 'Riwayat lagu disimpan']);
}
}
