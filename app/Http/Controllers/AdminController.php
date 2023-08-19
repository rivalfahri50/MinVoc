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
        if (auth()->guard('admin')->attempt($request->only('name', 'password'))) {
            return redirect()->intended('/admin/dashboard');
        }

        return back()->withErrors([
            'name' => 'The provided credentials do not match our records.',
        ]);
    }
}
