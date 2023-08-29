<?php

namespace App\Http\Controllers;

use App\Models\song;
use getID3;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Throwable;

class ArtistVerifiedController extends Controller
{
    protected function index(): Response
    {
        $title = "MusiCave";
        return response()->view('artisVerified.dashboard', compact('title'));
    }

    protected function pencarian(): Response
    {
        $title = "MusiCave";
        return response()->view('artisVerified.pencarian', compact('title'));
    }

    protected function playlist(): Response
    {
        $title = "MusiCave";
        return response()->view('artisVerified.playlist', compact('title'));
    }

    protected function riwayat(): Response
    {
        $title = "MusiCave";
        return response()->view('artisVerified.riwayat', compact('title'));
    }

    protected function profile(): Response
    {
        $title = "MusiCave";
        return response()->view('artisVerified.profile.profile', compact('title'));
    }

    protected function profile_ubah(): Response
    {
        $title = "MusiCave";
        return response()->view('artisVerified.profile.profile_ubah', compact('title'));
    }

    protected function billboard(): Response
    {
        $title = "MusiCave";
        return response()->view('artisVerified.billboard.billboard', compact('title'));
    }

    protected function album(): Response
    {
        $title = "MusiCave";
        return response()->view('artisVerified.billboard.album', compact('title'));
    }

    protected function kategori(): Response
    {
        $title = "MusiCave";
        return response()->view('artisVerified.kategori.kategori', compact('title'));
    }

    protected function buatPlaylist(): Response
    {
        $title = "MusiCave";
        return response()->view('artisVerified.playlist.buat', compact('title'));
    }

    protected function contohPlaylist(): Response
    {
        $title = "MusiCave";
        return response()->view('artisVerified.playlist.contoh', compact('title'));
    }

    protected function disukaiPlaylist(): Response
    {
        $title = "MusiCave";
        return response()->view('artisVerified.playlist.disukai', compact('title'));
    }

    protected function viewUnggahAudio(Request $request): Response
    {
        $title = "Unggah Audio";
        $datas = song::with('artist')->get();
        return response()->view('artisVerified.unggahAudio', compact('title', 'datas'));
    }

    protected function unggahAudio(Request $request)
    {
        $validate = Validator::make($request->only('image', 'judul', 'audio', 'genre'), [
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'judul' => 'required|string|max:255',
            'audio' => 'required|mimetypes:audio/mpeg,audio/wav|max:20480',
            'genre' => 'required|string|max:255',
        ], [
            'image' => [
                'image' => 'File :attribute harus berupa gambar.',
                'mimes' => 'File :attribute harus berupa file gambar dengan tipe: :values.',
                'max' => 'File :attribute tidak boleh lebih dari :max kilobita.',
            ],
            'judul' => [
                'required' => 'Kolom :attribute harus diisi.',
                'string' => 'Kolom :attribute harus berupa teks.',
                'max' => 'Kolom :attribute tidak boleh lebih dari :max karakter.',
            ],
            'audio' => [
                'required' => 'Kolom :attribute harus diisi.',
                'mimetypes' => 'File :attribute harus berupa file audio dengan tipe: :values.',
                'max' => 'File :attribute tidak boleh lebih dari :max kilobita.',
            ],
            'genre' => [
                'required' => 'Kolom :attribute harus diisi.',
                'string' => 'Kolom :attribute harus berupa teks.',
                'max' => 'Kolom :attribute tidak boleh lebih dari :max karakter.',
            ],
        ]);


        if ($validate->fails()) {
            return redirect()->back()
                ->withErrors($validate)
                ->withInput();
        }

        $code = Str::uuid();

        if ($request->file('image') && $request->file('audio')) {
            $image = $request->file('image')->store('images', 'public');
            $audio = $request->file('audio')->store('musics', 'public');
            $getID3 = new getID3();

            // Mendapatkan informasi tentang berkas audio
            $audioInfo = $getID3->analyze($request->file('audio')->path());

            // Durasi audio dalam detik
            $durationInSeconds = $audioInfo['playtime_seconds'];

            // Konversi durasi ke menit dan detik dengan padding nol
            $durationMinutes = floor($durationInSeconds / 60);
            $durationSeconds = $durationInSeconds % 60;

            // Format durasi dengan padding nol
            $formattedDuration = sprintf('%02d:%02d', $durationMinutes, $durationSeconds);
            try {
             song::create(
                    [
                        'code' => $code,
                        'judul' => $request->input('judul'),
                        'genre' => $request->input('genre'),
                        'audio' => $audio,
                        'image' => $image,
                        'waktu' => "$formattedDuration",
                        'artist_id' => Auth::user()->id,
                        'is_approved' => false,
                    ]
                );
            } catch (Throwable $e) {
                return response()->redirectTo('/artis-verified/unggahAudio')->with('failed', "Gagal untuk register!!");
            }
        }

        return response()->redirectTo('/artis-verified/unggahAudio')->with('success', 'User created successfully.');
    }
}
