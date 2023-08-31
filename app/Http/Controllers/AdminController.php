<?php

namespace App\Http\Controllers;

use App\Models\admin;
use App\Models\artist;
use App\Models\genre;
use App\Models\projects;
use App\Models\song;
use App\Models\User;
use Illuminate\Auth\Authenticatable as AuthAuthenticatable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Throwable;

class AdminController extends Controller
{
    use AuthAuthenticatable;
    protected function index(): Response
    {
        $title = "MusiCave";
        $totalPengguna = User::count();
        $totalLagu = song::count();
        $totalArtist = artist::count();
        $songs = song::all();
        return response()->view('admin.dashboard', compact('title', 'totalPengguna', 'totalLagu', 'totalArtist', 'songs'));
    }
    protected function persetujuan(): Response
    {
        $title = "MusiCave";
        $persetujuan = song::all();
        return response()->view('admin.persetujuan', compact('title', 'persetujuan'));
    }
    protected function show($id): Response
    {
        $title = "MusiCave";
        $show = song::findOrFail($id);
        return response()->view('admin.persetujuan', compact('title', 'show'));
    }

    protected function kategori(): Response
    {
        $title = "MusiCave";
        $genres = genre::all();
        return response()->view('admin.kategori', compact('title', 'genres'));
    }

    protected function iklan(): Response
    {
        $title = "MusiCave";
        return response()->view('admin.iklan', compact('title'));
    }
    protected function riwayat(): Response
    {
        $title = "MusiCave";
        return response()->view('admin.riwayat', compact('title'));
    }
    protected function verifikasi(): Response
    {
        $title = "MusiCave";
        return response()->view('admin.verifikasi', compact('title'));
    }

    protected function buatGenre(Request $request)
    {
        $validator = Validator::make(
            $request->only('name', 'images'),
            [
                'name' => 'required|string|max:50|unique:users,name',
                'images' => 'mimes:jpeg,jpg,png,gif|required|max:10000',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        } else {
            try {
                // Start a database transaction
                DB::beginTransaction();

                $genre = new Genre();
                $genre->code = Str::uuid();
                $genre->name = $request->input('name');

                // Handle file upload
                if ($request->hasFile('images')) {
                    $imagePath = $request->file('images')->store('genre_images', 'public');
                    $genre->images = $imagePath;
                }

                $genre->save();

                // Commit the transaction
                DB::commit();

                return redirect()->back()->with('success', 'Genre created successfully.');
            } catch (\Throwable $th) {
                // Roll back the transaction in case of an exception
                DB::rollBack();
                // Log the exception for debugging
                Log::error('Error creating genre: ' . $th->getMessage());

                return redirect()->back()->with('error', 'Failed to create genre.');
            }
        }
    }

    protected function hapusGenre(Request $request)
    {
        try {
            $codeToDelete = $request->input('code');
            $genre = genre::where('code', $codeToDelete)->first();

            if (!$genre) {
                return redirect()->back()->with('error', 'Record not found.');
            }
            $genre->delete();

            return redirect()->back()->with('success', 'Record deleted successfully.');
        } catch (\Throwable $th) {
            Log::error('Error deleting genre: ' . $th->getMessage());
            return redirect()->back()->with('error', 'Failed to delete record.');
        }
    }

    protected function storeSignIn(Request $request, admin $admin)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50|exists:users,name',
            'password' => 'required|string|min:6',
            'kebijakan_privasi' => 'required',
        ], [
            'name.required' => 'Kolom nama wajib diisi.',
            'name.string' => 'Kolom nama harus berupa teks.',
            'kebijakan_privasi.required' => 'Anda harus menyetujui kebijakan privasi.',
            'name.max' => 'Panjang nama tidak boleh lebih dari :max karakter.',
            'name.exists' => 'Nama yang dimasukkan tidak valid.',
            'password.required' => 'Kolom password wajib diisi.',
            'password.string' => 'Kolom password harus berupa teks.',
            'password.min' => 'Panjang password minimal :min karakter.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $credentials = $request->only('name', 'password');

        if (auth()->guard('admin')->attempt($credentials)) {
            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors(['name' => 'Invalid credentials.']);
    }

    protected function createProject(Request $request)
    {
        $validate = Validator::make(
            $request->only('judul', 'genre', 'konsep', 'harga'),
            [
                'judul' => 'required|string|max:255',
                'genre' => 'required|string|max:255',
                'konsep' => 'required|string|max:500',
                'harga' => 'required|numeric|min:0',
            ],
            [
                'required' => 'Kolom :attribute harus diisi.',
                'string' => 'Kolom :attribute harus berupa teks.',
                'max' => [
                    'string' => 'Kolom :attribute tidak boleh lebih dari :max karakter.',
                ],
                'numeric' => 'Kolom :attribute harus berupa angka.',
                'min' => [
                    'numeric' => 'Kolom :attribute harus lebih besar atau sama dengan :min.',
                ],
            ]
        );

        if ($validate->fails()) {
            return redirect()->back()
                ->withErrors($validate)
                ->withInput();
        }

        $code = Str::uuid();
        try {
            projects::create(
                [
                    'code' => $code,
                    'name' => $request->input('judul'),
                    'genre' => $request->input('genre'),
                    'judul' => "none",
                    'lirik' => "none",
                    'konsep' => $request->input('konsep'),
                    'harga' => $request->input('harga'),
                    'artist_id' => 0,
                    'is_approved' => false,
                    'is_reject' => false,
                ]
            );
        } catch (Throwable $e) {
            return response()->redirectTo('/admin/dashboard')->with('message', "Gagal untuk register!!");
        }
        return response()->redirectTo('/admin/dashboard')->with('message', 'User created successfully.');
    }
}
