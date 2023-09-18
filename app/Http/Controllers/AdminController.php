<?php

namespace App\Http\Controllers;

use App\Models\admin;
use App\Models\artist;
use App\Models\billboard;
use App\Models\genre;
use App\Models\notif;
use App\Models\penghasilan;
use App\Models\projects;
use App\Models\song;
use App\Models\User;
use Illuminate\Auth\Authenticatable as AuthAuthenticatable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;
use Throwable;

class AdminController extends Controller
{
    use AuthAuthenticatable;
    protected function index(Request $request): Response
    {
        $title = "MusiCave";
        $totalPengguna = User::whereNotIn('id', [1, 2, 3])->count();
        $totalLagu = song::count();
        $totalArtist = artist::count();
        $songs = song::all();
        $notifs = notif::where('user_id', auth()->user()->id)->get();

        $adminId = admin::where('id',1)->first()->id;
        $month = [];

        for ($i = 1; $i <= 12; $i++) {
            $totalPendapatan = admin::where('id', $adminId)
                ->whereYear('created_at', date('Y'))
                ->whereMonth('created_at', $i)
                ->sum('penghasilan');
            $month[] = $totalPendapatan;
        }
        return response()->view('admin.dashboard', compact('title', 'month','totalPendapatan', 'totalPengguna', 'totalLagu', 'totalArtist', 'songs', 'notifs'));
    }
    protected function persetujuan(): Response
    {
        $title = "MusiCave";
        $persetujuan = song::where('is_approved', false)->get();
        $notifs = notif::where('user_id', auth()->user()->id)->get();
        return response()->view('admin.persetujuan', compact('title', 'persetujuan', 'notifs'));
    }
    protected function show($id): Response
    {
        $title = "MusiCave";
        $show = song::findOrFail($id);
        $notifs = notif::where('user_id', auth()->user()->id)->get();
        return response()->view('admin.persetujuan', compact('title', 'show', 'notifs'));
    }

    protected function kategori(): Response
    {
        $title = "MusiCave";
        $genres = genre::all();
        $notifs = notif::where('user_id', auth()->user()->id)->get();
        return response()->view('admin.kategori', compact('title', 'genres', 'notifs'));
    }

    protected function iklan(): Response
    {
        $title = "MusiCave";
        $billboards = billboard::all();
        $artist = artist::where('is_verified', 1)->get();
        $notifs = notif::where('user_id', auth()->user()->id)->get();
        return response()->view('admin.iklan', compact('title', 'artist', 'billboards', 'notifs'));
    }

    protected function riwayat(): Response
    {
        $title = "MusiCave";
        $songs = song::all();
        $notifs = notif::where('user_id', auth()->user()->id)->get();
        return response()->view('admin.riwayat', compact('title', 'songs', 'notifs'));
    }

    protected function pencairan(): Response
    {
        $title = "MusiCave";
        $penghasilanAll = penghasilan::with('artist.user')->get();
        $notifs = notif::where('user_id', auth()->user()->id)->get();
        return response()->view('admin.pencairan', compact('title', 'notifs', 'penghasilanAll'));
    }

    protected function verifikasi(): Response
    {
        $title = "MusiCave";
        $artist = artist::where('is_verified', 0)->get();
        $notifs = notif::where('user_id', auth()->user()->id)->get();
        return response()->view('admin.verifikasi', compact('title', 'artist', 'notifs'));
    }

    protected function setujuMusic(string $code)
    {
        $title = "MusiCave";
        $song = song::where('code', $code)->first();
        $artis = artist::where('id', $song->artis_id)->first();
        $user = User::where('id', $artis->user_id)->first();

        $data = [
            'artis_id' => $song->artis_id,
            'title' => $song->judul,
            'user_id' => $user->id,
            'is_reject' => false
        ];
        notif::create($data);
        try {
            $song->is_approved = true;
            $song->update();
            $persetujuan = song::all();
            $notifs = notif::where('user_id', auth()->user()->id)->get();
        } catch (\Throwable $th) {
            Alert::error('message', 'Lagu Gagal Dalam Perizinan Publish');
            return response()->redirectTo('/admin/persetujuan')->with(['persetujuan' => $persetujuan, 'title' => $title, 'notifs' => $notifs]);
        }
        Alert::success('message', 'Lagu Berhasil Publish');
        return response()->redirectTo('/admin/persetujuan')->with(['persetujuan' => $persetujuan, 'title' => $title, 'notifs' => $notifs]);
    }

    protected function buatBillboard(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'artis_id' => 'required',
                'image_background' => 'image|mimes:jpeg,jpg,png,gif|max:10000',
                'image_artis' => 'image|mimes:jpeg,jpg,png,gif|max:10000',
            ],
            [
                'image_background.image' => 'File latar belakang harus berupa gambar.',
                'image_background.mimes' => 'File latar belakang harus berupa JPEG, JPG, PNG, atau GIF.',
                'image_background.max' => 'Ukuran file latar belakang tidak boleh melebihi 10MB.',
                'image_artis.image' => 'File gambar artis harus berupa gambar.',
                'image_artis.mimes' => 'File gambar artis harus berupa JPEG, JPG, PNG, atau GIF.',
                'image_artis.max' => 'Ukuran file gambar artis tidak boleh melebihi 10MB.',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $title = "MusiCave";
        $artist = artist::where('is_verified', 1)->get();
        $notifs = notif::where('user_id', auth()->user()->id)->get();
        if ($request->hasFile('image_background') && $request->hasFile('image_artis')) {
            $backgroundBillboard = $request->file('image_background')->store('backgorund_billboard', 'public');
            $backgroundArtis = $request->file('image_artis')->store('image_artis', 'public');
        }

        billboard::create([
            'code' => Str::uuid(),
            'artis_id' => $request->input('artis_id'),
            'deskripsi' => $request->input('deskripsi'),
            'image_background' => $backgroundBillboard,
            'image_artis' => $backgroundArtis,
        ]);
        try {
            $billboards = billboard::all();
        } catch (\Throwable $th) {
            Alert::error('message', 'Gagal Untuk Menambah Billboard');
            return response()->view('admin.iklan', compact('artist', 'title', 'notifs'));
        }

        Alert::success('message', 'Berhasil Untuk Menambah Billboard');
        return redirect()->back();
    }

    public function updateBillboard(Request $request, string $code)
    {
        $billboard = billboard::where('code', $code)->first();

        if (!$billboard) {
            return redirect()->back()->with('error', 'Billboard not found.');
        }

        // Validasi input sesuai kebutuhan
        $this->validate($request, [
            'artis_id' => 'required|exists:artists,id',
            'deskripsi' => 'required|string|max:250',
            'image_background' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'image_artis' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'image_background.image' => 'File latar belakang harus berupa gambar.',
            'image_background.mimes' => 'File latar belakang harus berupa JPEG, JPG, PNG, atau GIF.',
            'image_background.max' => 'Ukuran file latar belakang tidak boleh melebihi 10MB.',
            'image_artis.image' => 'File gambar artis harus berupa gambar.',
            'image_artis.mimes' => 'File gambar artis harus berupa JPEG, JPG, PNG, atau GIF.',
            'image_artis.max' => 'Ukuran file gambar artis tidak boleh melebihi 10MB.',
        ]);

        // Update nama artis dan deskripsi
        $billboard->artis_id = $request->input('artis_id');
        $billboard->deskripsi = $request->input('deskripsi');

        // Handle gambar background baru jika diunggah
        if ($request->hasFile('image_background')) {
            // Hapus gambar lama jika ada
            if ($billboard->image_background) {
                Storage::delete('public/' . $billboard->image_background);
            }

            // Simpan gambar baru
            $imagePath = $request->file('image_background')->store('public');
            $billboard->image_background = str_replace('public/', '', $imagePath);
        }

        // Handle gambar artis baru jika diunggah
        if ($request->hasFile('image_artis')) {
            // Hapus gambar lama jika ada
            if ($billboard->image_artis) {
                Storage::delete('public/' . $billboard->image_artis);
            }

            // Simpan gambar baru
            $imagePath = $request->file('image_artis')->store('public');
            $billboard->image_artis = str_replace('public/', '', $imagePath);
        }

        if ($billboard->save()) {

            Alert::success('message', 'Berhasil Untuk Memperbarui Billboard');
            return redirect()->back()->with('success', 'Billboard updated successfully.');
        } else {
            Alert::error('message', 'Gagal Untuk Memperbarui Billboard');
            return redirect()->back()->with('error', 'Failed to update billboard.');
        }
    }

    protected function buatGenre(Request $request)
    {
        $validator = Validator::make(
            $request->only('name', 'images'),
            [
                'name' => 'required|unique:admins,name|string|max:50',
                'images' => 'mimes:jpeg,jpg,png,gif|required|max:10000',
            ],
            [
                'images.mimes' => 'File gambar harus berupa JPEG, JPG, PNG, atau GIF.',
                'images.required' => 'File gambar harus diunggah.',
                'images.max' => 'Ukuran file gambar tidak boleh melebihi 10MB.',
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

                $genre = new genre();
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

                Alert::success('message', 'Berhasil Membuat Genre');
                return redirect()->back()->with('success', 'Genre created successfully.');
            } catch (\Throwable $genre) {
                DB::rollBack();
                Log::error('Terjadi kesalahan saat membuat genre: ' . $genre->getMessage());

                Alert::error('message', 'Gagal Membuat Genre');
                return redirect()->back()->with('error', 'Gagal membuat genre.');
            }
        }
    }
    public function editGenre(Request $request, string $code)
    {
        $genre = genre::find($code);

        if (!$genre) {
            return redirect()->back()->with('error', 'Genre not found.');
        }

        $validator = $request->validate(
            [
                'name' => 'required|string|max:50',
                'images' => 'image|mimes:jpeg,jpg,png,gif|max:10000', // Menggunakan "image" sebagai aturan validasi
            ],
            [
                'images.mimes' => 'File gambar harus berupa JPEG, JPG, PNG, atau GIF.',
                'images.max' => 'Ukuran file gambar tidak boleh melebihi 10MB.',
            ]
        );

        try {
            if ($request->hasFile('images')) {

                if ($genre->images) {
                    Storage::disk('public')->delete($genre->images);
                }

                $imagePath = $request->file('images')->store('genre_images', 'public');
                $genre->images = $imagePath;
            }

            $genre->name = $request->input('name');
            $genre->save();
            Alert::success('success', 'Berhasil Mengedit Genre');
            return redirect()->back()->with('success', 'Genre updated successfully.');
        } catch (\Throwable $th) {
            Log::error('Error editing genre: ' . $th->getMessage());
            Alert::error('error', 'Gagal Mengedit Genre');
            return redirect()->back()->with('error', 'Failed to edit genre.');
        }
    }
    protected function setujuVerified(Request $request, string $code)
    {
        $artis = artist::where('code', $code)->first();
        $user = User::where('id', $artis->user_id)->first();

        try {
            $artis->is_verified = true;
            $artis->verification_status = "success";
            $user->role_id = 1;
            $artis->update();
            $user->update();
        } catch (\Throwable $th) {
            Alert::error('message', 'Gagal Update Artis Verified');
            return redirect()->back()->with('message', 'failed update artis.');
        }
        Alert::success('message', 'Success Update Artis Verified');
        return redirect()->back()->with('message', 'success update artis.');
    }

    protected function hapusVerified(Request $request, string $code)
    {
        $artis = artist::where('code', $code)->first();

        try {
            notif::create([
                'artis_id' => $artis->id,
                'title' => "Pengajuan verifikasi akun ditolak",
                'message' => $request->input('alasan'),
                'user_id' => $artis->user_id,
                'is_reject' => false
            ]);

            $artis->image = "none";
            $artis->pengajuan_verified_at = null;
            $artis->verification_status = "none";
            $artis->update();
        } catch (\Throwable $th) {
            Alert::error('message', 'Gagal Menghapus Artis Verified');
            return redirect()->back()->with('message', 'failed update artis.');
        }
        Alert::success('message', 'Success Menghapus Artis Verified');
        return redirect()->back()->with('message', 'success update artis.');
    }

    protected function hapusGenre(Request $request, string $code)
    {
        try {
            $genre = genre::where('code', $code)->first();

            if (!$genre) {
                return redirect()->back()->with('error', 'Record not found.');
            }

            $genre->delete();
        } catch (\Throwable $th) {
            Alert::warning('message', 'Lagu Genre Sedang Digunakan');
            return redirect()->back()->with('error', 'Failed to delete record.');
        }

        Alert::success('message', 'Berhasil Menghapus Genre');
        return redirect()->back()->with('success', 'Record deleted successfully.');
    }

    protected function hapusMusic(Request $request, string $code)
    {
        try {
            $music = song::where('code', $code)->first();

            if (!$music) {
                return redirect()->back()->with('error', 'Record not found.');
            }

            $music->delete();
        } catch (\Throwable $th) {
            Alert::warning('message', 'Lagu Sedang Digunakan');
            return redirect()->back()->with('error', 'Failed to delete record.');
        }

        Alert::success('message', 'Success Menghapus');
        return redirect()->back()->with('success', 'Record deleted successfully.');
    }

    protected function hapusBillboard(Request $request, string $code)
    {
        try {
            $billboard = billboard::where('code', $code)->first();

            if (!$billboard) {
                return redirect()->back()->with('error', 'Record not found.');
            }

            $billboard->delete();
        } catch (\Throwable $th) {
            Alert::warning('message', 'Billboard Sedang Digunakan');
            return redirect()->back()->with('error', 'Failed to delete record.');
        }

        Alert::success('message', 'Berhasil Menghapus');
        return redirect()->back()->with('success', 'Record deleted successfully.');
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
