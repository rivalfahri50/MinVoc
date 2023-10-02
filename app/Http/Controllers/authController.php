<?php

namespace App\Http\Controllers;

use App\Models\admin;
use App\Models\artist;
use App\Models\role;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Throwable;

class authController extends Controller
{
    protected function viewWelcome(Request $request)
    {
        $title = "MusiCave";
        return response()->view('welcomePage', compact('title'));
    }

    protected function viewMasuk(Request $request)
    {
        $title = "MusiCave";
        return response()->view('auth.masuk', compact('title'));
    }

    protected function viewMasukAdmin(Request $request)
    {
        $title = "MusiCave";
        return response()->view('auth.masukAdmin', compact('title'));
    }

    protected function viewBuatAkun(Request $request)
    {
        $title = "MusiCave";
        return response()->view('auth.buatAkun', compact('title'));
    }

    protected function viewLupaPassword(Request $request)
    {
        $title = "MusiCave";
        return response()->view('auth.lupaPassword', compact('title'));
    }

    protected function viewUbahPassword(Request $request)
    {
        $title = "MusiCave";
        return response()->view('auth.ubahPassword', compact('title'));
    }

    protected function resetPasswordToken(string $token)
    {
        $title = "musiCave";
        return response()->view('auth.ubahPassword', compact('title', 'token'));
    }

    protected function resetPassword(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email|unique:users,email',
        ], [
            'email.unique' => 'Alamat email ini sudah terdaftar di sistem kami.',
        ]);

        $status = Password::sendResetLink($validatedData);

        $message = $status === Password::RESET_LINK_SENT
            ? 'Kami telah mengirimkan email dengan tautan reset kata sandi Anda!'
            : 'Kami tidak dapat menemukan pengguna dengan alamat email tersebut.';

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => $message, 'title' => 'musiCave'])
            : back()->withErrors(['email' => $message]);
    }


    protected function ubahPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|string|min:6|same:password_confirmation|confirmed',
        ], [
            'token.required' => 'Token diperlukan.',
            'email.required' => 'Alamat email diperlukan.',
            'email.email' => 'Format alamat email tidak valid.',
            'password.required' => 'Kata sandi diperlukan.',
            'password.string' => 'Kata sandi harus berupa teks.',
            'password.min' => 'Kata sandi harus memiliki setidaknya 6 karakter.',
            'password.same' => 'Kata sandi harus sama dengan konfirmasi kata sandi.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));
                $user->save();
                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('pengguna')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }

    protected function storeSignIn(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $validator = Validator::make($request->only('email', 'password', 'kebijakan_privasi'), [
            'email' => 'required|string|max:50|email|exists:users,email',
            'password' => 'required|string|min:6',
            'kebijakan_privasi' => 'required',
        ], [
            'kebijakan_privasi.required' => 'Kebijakan Privasi wajib diisi.',
            'email.required' => 'Kolom email wajib diisi.',
            'email.string' => 'Kolom email harus berupa teks.',
            'email.max' => 'Panjang email tidak boleh lebih dari :max karakter.',
            'email.email' => 'Format email tidak valid.',
            'email.exists' => 'Email yang dimasukkan tidak terdaftar.',
            'password.required' => 'Kolom password wajib diisi.',
            'password.string' => 'Kolom password harus berupa teks.',
            'password.min' => 'Panjang password minimal :min karakter.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }


        if (Auth::attempt($credentials)) {
            User::where('id', auth()->user()->id)->update(['is_login' => true]);
            $user = auth()->user();
            switch ($user->role_id) {
                case 3:
                    return redirect()->intended(route('user.dashboard'));
                case 2:
                    return redirect()->intended(route('artist.dashboard'));
                case 1:
                    return redirect()->intended(route('artist-verified.dashboard'));
                case 4:
                    if (auth('admin')->attempt($credentials)) {
                        return redirect()->intended(route('admin.dashboard'));
                    }
                    break;
            }
        }
        try {
        } catch (\Throwable $th) {
            return abort(404);
        }
        return back()->withErrors(['password' => 'Kredensial tidak valid..']);
    }

    protected function storeSignUp(Request $request)
    {
        $validate = Validator::make(
            $request->all(),
            [
                'role' => 'required|in:pengguna,artis,admin',
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:6|same:password_confirmation|confirmed',
            ],
            [
                'role.required' => 'Peran harus diisi.',
                'role.in' => 'Peran harus salah satu dari: pengguna, artis, admin.',
                'name.required' => 'Nama harus diisi.',
                'name.string' => 'Nama harus berupa teks.',
                'name.max' => 'Nama tidak boleh lebih dari :max karakter.',
                'email.required' => 'Alamat email harus diisi.',
                'email.email' => 'Alamat email harus valid.',
                'email.unique' => 'Alamat email sudah digunakan.',
                'password.required' => 'Kata sandi harus diisi.',
                'password.string' => 'Kata sandi harus berupa teks.',
                'password.min' => 'Kata sandi harus memiliki minimal :min karakter.',
                'password.same' => 'Kata sandi dan konfirmasi kata sandi harus sama.',
                'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.'
            ]
        );


        if ($validate->fails()) {
            return redirect()->back()
                ->withErrors($validate)
                ->withInput();
        }

        $code = Str::uuid();
        $defaultRole = role::where('name', $request->only('role'))->first();

        try {
            if ($request->input('name')) {
                $user = User::create(
                    [
                        'code' => $code,
                        'role_id' => $defaultRole->id,
                        'deskripsi' => "none",
                        'name' => $request->input('name'),
                        'email' => $request->input('email'),
                        'password' => $request->input('password')
                    ]
                );

                if ($user->role_id == 2) {
                    artist::create([
                        'code' => Str::uuid(),
                        'user_id' => $user->id,
                        'is_verified' => false
                    ]);
                } else if ($user->role_id == 1) {
                    artist::create([
                        'user_id' => $user->id,
                        'is_verified' => true
                    ]);
                }
            }
        } catch (Throwable $e) {
            return response()->redirectTo('/buat-akun')->with('failed', "Gagal untuk register!!");
        }
        return response()->redirectTo('/masuk')->with('success', 'Berhasil register.');
    }

    protected function logout()
    {
        User::where('id', auth()->user()->id)->update(['is_login' => false]);
        try {
            Auth::logout();
        } catch (\Throwable $th) {
            return abort(404);
        }
        return redirect("/masuk");
    }
}
