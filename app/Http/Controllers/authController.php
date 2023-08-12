<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class authController extends Controller
{
    protected function viewMasuk(Request $request)
    {
        $title = "MusiCave";
        return response()->view('masuk', compact('title'));
    }
    protected function viewMasukAdmin(Request $request)
    {
        $title = "MusiCave";
        return response()->view('masukAdmin', compact('title'));
    }
    protected function viewBuatAkun(Request $request)
    {
        $title = "MusiCave";
        return response()->view('buatAkun', compact('title'));
    }
    protected function viewLupaPassword(Request $request)
    {
        $title = "MusiCave";
        return response()->view('lupaPassword', compact('title'));
    }
    protected function viewUbahPassword(Request $request)
    {
        $title = "MusiCave";
        return response()->view('ubahPassword', compact('title'));
    }
}
