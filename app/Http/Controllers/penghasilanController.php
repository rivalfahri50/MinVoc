<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\artist;
use App\Models\penghasilan;
use Illuminate\Http\Request;

class penghasilanController extends Controller
{
    public function simpanPenghasilan(Request $request) {
        $artist = artist::find($request->artist_id);
        if (!$artist) {
            return redirect()->back()->with('artist', 'artist tidak ditemukan');
        }
        $penghasilan = new penghasilan();
        $penghasilan->artist_id = $artist->id;
        $penghasilan->penghasilan = $request->penghasilan; // Atur nilai penghasilan sesuai kebutuhan
        $penghasilan->bulan = $request->bulan; // Atur bulan penghasilan
        $penghasilan->save();

        // Redirect atau tampilkan pesan sukses
        return redirect()->back()->with('success', 'Data penghasilan berhasil disimpan.');
    }
}
