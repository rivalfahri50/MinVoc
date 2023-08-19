<?php

namespace App\Http\Controllers;

use App\Models\admin;
use Illuminate\Auth\Authenticatable as AuthAuthenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    use AuthAuthenticatable;

    protected function storeSignIn(Request $request, admin $admin)
    {
        $validator = Validator::make(
            $request->all(),
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

        if ($validator) {
            if (auth()->guard('admin')->attempt($request->only('name', 'password'))) {
                return redirect()->intended('/admin/dashboard');
            }
        }

        return back()->withErrors([
            'name' => 'The provided credentials do not match our records.',
        ]);
    }
}
