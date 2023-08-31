<?php

namespace App\Http\Controllers;

use App\Models\artist;
use App\Models\genre;
use App\Models\messages;
use App\Models\playlist;
use App\Models\projects;
use App\Models\song;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use SebastianBergmann\CodeCoverage\Report\Xml\Project;
use Throwable;

class ArtistController extends Controller
{
    protected function index(): Response
    {
        $title = "MusiCave";
        $songs = song::all();
        $genres = genre::all();
        $artist = artist::with('user')->get();
        return response()->view('artis.dashboard', compact('title', 'songs', 'genres', 'artist'));
    }

    protected function playlist(): Response
    {
        $title = "MusiCave";
        $playlists = playlist::all();
        return response()->view('artis.playlist', compact('title', 'playlists'));
    }

    protected function penghasilan(): Response
    {
        $title = "MusiCave";
        $totalPengguna = User::count();
        $totalLagu = song::count();
        $totalArtist = artist::count();
        $songs = song::all();
        return response()->view('artis.penghasilan', compact('title', 'totalPengguna', 'totalLagu', 'totalArtist', 'songs'));
    }

    protected function riwayat(): Response
    {
        $title = "MusiCave";
        return response()->view('artis.riwayat', compact('title'));
    }

    protected function profile(): Response
    {
        $title = "MusiCave";
        return response()->view('artis.profile.profile', compact('title'));
    }

    protected function profile_ubah(string $code): Response
    {
        $title = "MusiCave";
        $user = User::where('code', $code)->get();
        return response()->view('artis.profile.profile_ubah', compact('title', 'user'));
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

            if ($request->input('deskripsi') === "none" || $request->input('deskripsi') === null) {
                $value = [
                    'code' => $code,
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                    'deskripsi' => "none",
                    'avatar' => $newImage,
                    'password' => $user->password,
                    'role_id' => $user->role_id,
                ];
            } else {
                $value = [
                    'code' => $code,
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                    'deskripsi' => $request->input('deskripsi'),
                    'avatar' => $newImage,
                    'password' => $user->password,
                    'role_id' => $user->role_id,
                ];
            }
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
            return response()->redirectTo('/artis/profile')->with('failed', "failed");
        }
        return response()->redirectTo('/artis/profile')->with('failed', "failed");
    }

    protected function billboard(): Response
    {
        $title = "MusiCave";
        return response()->view('artis.billboard.billboard', compact('title'));
    }

    protected function album(): Response
    {
        $title = "MusiCave";
        return response()->view('artis.billboard.album', compact('title'));
    }

    protected function kategori(string $code): Response
    {
        $title = "MusiCave";
        $genre = genre::where('code', $code)->first();
        return response()->view('artis.kategori.kategori', compact('title', 'genre'));
    }

    protected function buatPlaylist(): Response
    {
        $title = "MusiCave";
        $songs = song::all();
        return response()->view('artis.playlist.buat', compact('title', 'songs'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $results = User::where('name', 'LIKE', '%' . $query . '%')->get();
        return response()->json(['results' => $results]);
    }

    public function verified(Request $request)
    {
        $title = "MusiCave";
        return response()->view('artis.verified', compact('title'));
    }

    protected function storePlaylist(Request $request): Response
    {
        $title = "MusiCave";
        try {
            if (!$request->file()) {
                $values =
                    [
                        'code' => Str::uuid(),
                        'name' => $request->input('name') == null ? "Playlist Lagu" : $request->input('name'),
                        'deskripsi' => $request->input('deskripsi') == null ? "none" : $request->input('deskripsi'),
                        'images' => 'images/defaultPlaylist.png',
                        'user_id' => Auth::user()->id
                    ];
            } else if ($existImage = $request->file('images')->store('images', 'public')) {
                $values =
                    [
                        'code' => Str::uuid(),
                        'name' => $request->input('name') == null ? "Playlist Lagu" : $request->input('name'),
                        'deskripsi' => $request->input('deskripsi') == null ? "none" : $request->input('deskripsi'),
                        'images' => $existImage,
                        'user_id' => Auth::user()->id
                    ];
            }
            playlist::create($values);
            $playlists = playlist::all();
        } catch (\Throwable $th) {
            return response()->view('artis.playlist', compact('title'));
        }
        return response()->view('artis.playlist', compact('title', 'playlists'));
    }

    protected function ubahPlaylist(Request $request, string $code)
    {
        $title = "MusiCave";
        $playlists = playlist::where('code', $code)->first();
        try {
            if (!$request->file()) {
                $values =
                    [
                        'code' => $code,
                        'name' => $request->input('name') == null ? $playlists->name : $request->input('name'),
                        'deskripsi' => $request->input('deskripsi') == null ? $playlists->deskripsi : $request->input('deskripsi'),
                        'images' => $playlists->images,
                        'user_id' => $playlists->user_id
                    ];
            } else if ($existImage = $request->file('images')->store('images', 'public')) {
                if (Storage::disk('public')->exists($playlists->images)) {
                    Storage::disk('public')->delete($playlists->images);
                }

                $values =
                    [
                        'code' => $code,
                        'name' => $request->input('name') == null ? $playlists->name : $request->input('name'),
                        'deskripsi' => $request->input('deskripsi') == null ? $playlists->deskripsi : $request->input('deskripsi'),
                        'images' => $existImage,
                        'user_id' => $playlists->user_id
                    ];
            }
            playlist::where('code', $code)->update($values);
            $playlists = playlist::all();
        } catch (\Throwable $th) {
            return response()->view('artis.playlist', compact('title'));
        }
        return response()->view('artis.playlist', compact('title', 'playlists'));
    }

    protected function detailPlaylist(string $code): Response
    {
        $playlistDetail = playlist::where('code', $code)->first();
        $songs = song::all();
        $title = "MusiCave";
        return response()->view('artis.playlist.contoh', compact('title', 'playlistDetail', 'songs'));
    }

    protected function contohPlaylist(): Response
    {
        $title = "MusiCave";
        return response()->view('artis.playlist.contoh', compact('title'));
    }

    protected function disukaiPlaylist(): Response
    {
        $title = "MusiCave";
        return response()->view('artis.playlist.disukai', compact('title'));
    }

    protected function viewKolaborasi(Request $request)
    {
        $title = "Kolaborasi";
        $datas = projects::all();
        return response()->view('artis.kolaborasi', compact('title', 'datas'));
    }

    protected function viewLirikAndChat(Request $request, string $code)
    {
        $title = "Kolaborasi";
        $project = DB::table('projects')->where('code', $code)->get();
        $datas = messages::with('messages')->get();
        return response()->view('artis.lirikAndChat', compact('title', 'project', 'datas'));
    }

    protected function showData(string $id)
    {
        $data = DB::table('projects')->where('code', $id)->get();
        return response()->view('artis.kolaborasi', compact('data'));
    }

    protected function logout(Request $request)
    {
        Auth::logout();
        return response()->redirectTo("/masuk");
    }

    protected function Project(Request $request)
    {
        $validate = Validator::make(
            $request->only('judul', 'lirik', 'code'),
            [
                'judul' => 'required|string|max:255',
                'lirik' => 'required|string',
                'code' => [
                    'required',
                    Rule::in([$request->input('code')]),
                ]
            ],
            [
                'required' => 'Kolom :attribute harus diisi.',
                'string' => 'Kolom :attribute harus berupa teks.',
                'max' => [
                    'string' => 'Kolom :attribute tidak boleh lebih dari :max karakter.',
                ],
                'in' => 'Kolom :attribute tidak valid.',
            ]
        );

        if ($validate->fails()) {
            return redirect()->back()
                ->withErrors($validate)
                ->withInput();
        }

        $project = projects::where('code', $request->input('code'))->first();

        $data = [
            'code' => $project->code,
            'name' => $project->name,
            'genre' => $project->genre,
            'judul' => $request->input('judul'),
            'lirik' => $request->input('lirik'),
            'konsep' => $project->konsep,
            'harga' => $project->harga,
            'artist_id' => Auth::user()->id,
            'is_approved' => false,
            'is_reject' => false,
        ];

        try {
            $project->update($data);
        } catch (Throwable $e) {
            return response()->redirectTo('/admin/dashboard')->with('message', "Gagal untuk register!!");
        }
        return response()->redirectTo('/admin/dashboard')->with('message', 'User created successfully.');
    }

    protected function message(Request $request)
    {
        try {
            $message = messages::create([
                'code' => Str::uuid(),
                'sender_id' => Auth::user()->id,
                'receiver_id' => 1,
                'project_id' => $request->input('id_project'),
                'message' => $request->input('message')
            ]);
            $data = messages::with('messages')->get();
            // dd($message);
        } catch (\Throwable $th) {
            return redirect()->back();
        }

        return redirect()->back()->with([
            'message' => $message->message,
            'datas' => $data
        ]);
    }

    protected function rejectProject(Request $request)
    {
        $project = projects::where('code', $request->input('code'))->first();
        // dd($project);
        try {
            $data = [
                'code' => $project->code,
                'name' => $project->name,
                'genre' => $project->genre,
                'judul' => "none",
                'lirik' => "none",
                'konsep' => $project->konsep,
                'harga' => $project->harga,
                'artist_id' => Auth::user()->id,
                'is_approved' => false,
                'is_reject' => true,
            ];
            $project->update($data);
        } catch (\Throwable $th) {
            return redirect()->back();
        }
        return redirect()->back();
    }
}
