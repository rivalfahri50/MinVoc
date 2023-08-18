<?php

namespace App\Http\Controllers;

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
            'password' => 'required|min:8|confirmed',
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
        $validate = Validator::make($request->only('name', 'password'), [
            'name' => 'required|string|max:50|exists:users,name',
            'password' => 'required|string|min:6',
        ]);

        if ($validate->fails()) {
            return redirect()->back()
                ->withErrors($validate)
                ->withInput();
        }

        $credentials = $request->only('name', 'password');

        
        if (Auth::attempt($credentials)) {
            if (auth()->user()->role == 3) {
                return redirect()->intended('/pengguna/dashboard');
            } else if (auth()->user()->role == 2) {
                return redirect()->intended('/artis/dashboard');
            }
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    protected function storeSignUp(Request $request)
    {
        
        $validate = Validator::make($request->all(), [
            'role' => 'required|in:pengguna,artis',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validate->fails()) {
            return redirect()->back()
                ->withErrors($validate)
                ->withInput();
        }

        $code = Str::uuid();
        $defaultRole = role::where('name', $request->only('role'))->first();

        try {
            User::create(
                [
                    'code' => $code,
                    'role_id' => $defaultRole->id,
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                    'password' => $request->input('password')
                ]
            );
        } catch (Throwable $e) {
            return response()->redirectTo('/buat-akun')->with('failed', "Gagal untuk register!!");
        }
        return response()->redirectTo('/masuk')->with('success', 'User created successfully.');
    }
}
