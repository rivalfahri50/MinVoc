<?php

namespace App\Http\Controllers;

use App\Models\messages;
use App\Models\projects;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        return response()->view('artis.dashboard', compact('title'));
    }

    protected function pencarian(): Response
    {
        $title = "MusiCave";
        return response()->view('artis.pencarian', compact('title'));
    }

    protected function playlist(): Response
    {
        $title = "MusiCave";
        return response()->view('artis.playlist', compact('title'));
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

    protected function profile_ubah(): Response
    {
        $title = "MusiCave";
        return response()->view('artis.profile.profile_ubah', compact('title'));
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

    protected function kategori(): Response
    {
        $title = "MusiCave";
        return response()->view('artis.kategori.kategori', compact('title'));
    }

    protected function buatPlaylist(): Response
    {
        $title = "MusiCave";
        return response()->view('artis.playlist.buat', compact('title'));
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
