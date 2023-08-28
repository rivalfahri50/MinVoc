<?php

namespace App\Http\Controllers;

use App\Models\artist;
use App\Models\playlist;
use App\Models\song;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Throwable;

class penggunaController extends Controller
{
    protected function index(): Response
    {
        $title = "MusiCave";
        $songs = song::all();
        $artist = artist::with('user')->get();
        return response()->view('users.index', compact('title', 'songs', 'artist'));
    }

    protected function pencarian(): Response
    {
        $title = "MusiCave";
        $songs = song::all();
        $artist = artist::with('user')->get();
        return response()->view('users.pencarian', compact('title', 'artist', 'songs'));
    }

    protected function playlist(): Response
    {
        $title = "MusiCave";
        return response()->view('users.playlist', compact('title'));
    }

    protected function riwayat(): Response
    {
        $title = "MusiCave";
        return response()->view('users.riwayat', compact('title'));
    }

    protected function profile(): Response
    {
        $title = "MusiCave";
        return response()->view('users.profile.profile', compact('title'));
    }

    protected function profile_ubah(Request $request, string $code): Response
    {
        $title = "MusiCave";
        $user = User::where('code', $code)->get();
        return response()->view('users.profile.profile_ubah', compact('title', 'user'));
    }

    protected function billboard(): Response
    {
        $title = "MusiCave";
        return response()->view('users.billboard.billboard', compact('title'));
    }

    protected function album(): Response
    {
        $title = "MusiCave";
        return response()->view('users.billboard.album', compact('title'));
    }

    protected function kategori(): Response
    {
        $title = "MusiCave";
        return response()->view('users.kategori.kategori', compact('title'));
    }

    protected function buatPlaylist(): Response
    {
        $title = "MusiCave";
        try {
            $data = playlist::create(
                [
                    'code' => Str::uuid(),
                ]
            );
        } catch (\Throwable $th) {
            return response()->view('users.playlist.buat', compact('title'));
        }
        return response()->view('users.playlist.buat', compact('title', 'data'));
    }

    protected function contohPlaylist(): Response
    {
        $title = "MusiCave";
        return response()->view('users.playlist.contoh', compact('title'));
    }

    protected function disukaiPlaylist(): Response
    {
        $title = "MusiCave";
        return response()->view('users.playlist.disukai', compact('title'));
    }

    protected function updateProfile(string $code, Request $request)
    {
        $validate = Validator::make(
            $request->all(),
            [
                'name' => 'required|string|max:255',
                'avatar' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                'email' => 'required|string|email|max:255',
                'deskripsi' =>  'max:255',
            ],
            [
                'name' => [
                    'required' => 'Nama harus diisi.',
                    'string' => 'Nama harus berupa teks.',
                    'max' => 'Nama tidak boleh lebih dari :max karakter.',
                ],
                'avatar' => [
                    'image' => 'Avatar harus berupa gambar.',
                    'mimes' => 'Avatar harus dalam format: :values.',
                    'max' => 'Avatar tidak boleh lebih dari :max KB.',
                ],
                'email' => [
                    'required' => 'Email harus diisi.',
                    'string' => 'Email harus berupa teks.',
                    'email' => 'Format email tidak valid.',
                    'max' => 'Email tidak boleh lebih dari :max karakter.',
                ],
                'deskripsi' => [
                    'max' => 'Deskripsi tidak boleh lebih dari :max karakter.',
                ],
            ]
        );


        if ($validate->fails()) {
            return redirect()->back()
                ->withErrors($validate)
                ->withInput();
        }


        $user = User::where('code', $code)->first();
        $existingPhotoPath = $user->avatar;

        if ($request->hasFile('avatar') && $request->file('avatar')) {
            if ($validate->fails()) {
                return redirect()->back()
                    ->withErrors($validate)
                    ->withInput();
            }

            $newImage = $request->file('avatar')->store('images', 'public');

            $value = [
                'code' => $code,
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'avatar' => $newImage,
                'deskripsi' => $request->input('deskripsi'),
                'password' => $user->password,
                'role_id' => $user->role_id,
            ];

            if (Storage::disk('public')->exists($existingPhotoPath)) {
                Storage::disk('public')->delete($existingPhotoPath);
            }
        } else {
            if ($request->input('deskripsi') === "none" || $request->input('deskripsi') === null) {
                $value = [
                    'code' => $code,
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                    'deskripsi' => "none",
                    'password' => $user->password,
                    'role_id' => $user->role_id,
                ];
            } else {
                $value = [
                    'code' => $code,
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                    'deskripsi' => $request->input('deskripsi'),
                    'password' => $user->password,
                    'role_id' => $user->role_id,
                ];
            }
        }
        try {
            User::where('code', $code)->update($value);
        } catch (Throwable $e) {
            return response()->redirectTo('/pengguna/profile')->with('failed', "failed");
        }
        return response()->redirectTo('/pengguna/profile')->with('failed', "failed");
    }

    protected function search(Request $request)
    {
        // if($request->ajax())
        // {
        //     $datas = 
        // }
    }

    protected function logout(Request $request)
    {
        Auth::logout();
        return response()->redirectTo("/masuk");
    }
}
