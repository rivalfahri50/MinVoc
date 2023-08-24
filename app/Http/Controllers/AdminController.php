<?php

namespace App\Http\Controllers;

use App\Models\admin;
use App\Models\projects;
use Illuminate\Auth\Authenticatable as AuthAuthenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Throwable;

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
            ],
        );

        if ($validator) {
            if (auth()->guard('admin')->attempt($request->all('name', 'password'))) {
                return redirect()->intended('/admin/dashboard');
            }
        }

        return back()->withErrors([
            'name' => 'The provided credentials do not match our records.',
        ]);
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
