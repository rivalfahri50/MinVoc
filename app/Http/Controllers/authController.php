<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
}
