<?php

namespace App\Http\Controllers;

use App\Models\song;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Throwable;

class ArtistVerifiedController extends Controller
{
    protected function viewDashboard(Request $request): Response
    {
        $title = "Dashboard";
        return response()->view('artisVerified.dashboard', compact('title'));
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
            try {
                song::create(
                    [
                        'code' => $code,
                        'judul' => $request->input('judul'),
                        'genre' => $request->input('genre'),
                        'audio' => $audio,
                        'image' => $image,
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
