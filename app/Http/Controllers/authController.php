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
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status), 'title' => 'musiCave'])
            : back()->withErrors(['email' => __($status)]);
    }

    protected function ubahPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|string|min:6|same:password_confirmation|confirmed',
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
        $validate = Validator::make(
            $request->only('name', 'password', 'kebijakan_privasi'),
            [
                'name' => 'required|string|max:50|exists:users,name',
                'password' => 'required|string|min:6',
                'kebijakan_privasi' => 'required',
            ],
            [
                'name.required' => 'Kolom nama wajib diisi.',
                'name.string' => 'Kolom nama harus berupa teks.',
                'kebijakan_privasi.required' => 'Anda harus menyetujui kebijakan privasi.',
                'name.max' => 'Panjang nama tidak boleh lebih dari :max karakter.',
                'name.exists' => 'Nama yang dimasukkan tidak valid.',
                'password.required' => 'Kolom password wajib diisi.',
                'password.string' => 'Kolom password harus berupa teks.',
                'password.min' => 'Panjang password minimal :min karakter.',
            ]
        );

        if ($validate->fails()) {
            return redirect()->back()
                ->withErrors($validate)
                ->withInput();
        }

        $credentials = $request->only('name', 'password');
        
        if (Auth::attempt($credentials)) {
            if (auth()->user()->role_id == 3) {
                return redirect()->intended('/pengguna/dashboard');
            } else if (auth()->user()->role_id == 2) {
                return redirect()->intended('/artis/dashboard');
            } else if (auth()->user()->role_id == 1) {
                return redirect()->intended('/artis-verified/dashboard');
            }
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
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
                'role.in' => 'Peran harus salah satu dari: pengguna, artis.',
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
            $user = User::create(
                [
                    'code' => $code,
                    'role_id' => $defaultRole->id,
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                    'password' => $request->input('password')
                ]
            );

            if ($user->role_id == 2) {
                artist::create([
                    'user_id' => $user->id,
                    'is_verified' => false
                ]);
            } else if ($user->role_id == 1) {
                artist::create([
                    'user_id' => $user->id,
                    'is_verified' => true
                ]);
            } else if ($user->role_id == 4) {
                admin::create([
                    'user_id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'password' => $user->password,
                ]);
            }
        } catch (Throwable $e) {
            return response()->redirectTo('/buat-akun')->with('failed', "Gagal untuk register!!");
        }
        return response()->redirectTo('/masuk')->with('success', 'User created successfully.');
    }
}
