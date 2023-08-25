<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class penggunaController extends Controller
{
    protected function index(): Response
    {
        $title = "MusiCave";
        return response()->view('users.index', compact('title'));
    }

    protected function pencarian(): Response
    {
        $title = "MusiCave";
        return response()->view('users.pencarian', compact('title'));
    }

    protected function playlist(): Response
    {
        $title = "MusiCave";
        return response()->view('users.playlist', compact('title'));
    }

    protected function riwayat(): Response
    {
        $title = "MusiCave";
        return response()->view('users.riwayat', compact('title'));
    }

    protected function profile(): Response
    {
        $title = "MusiCave";
        return response()->view('users.profile.profile', compact('title'));
    }

    protected function profile_ubah(): Response
    {
        $title = "MusiCave";
        return response()->view('users.profile.profile_ubah', compact('title'));
    }

    protected function billboard(): Response
    {
        $title = "MusiCave";
        return response()->view('users.billboard.billboard', compact('title'));
    }

    protected function album(): Response
    {
        $title = "MusiCave";
        return response()->view('users.billboard.album', compact('title'));
    }

    protected function kategori(): Response
    {
        $title = "MusiCave";
        return response()->view('users.kategori.kategori', compact('title'));
    }

    protected function buatPlaylist(): Response
    {
        $title = "MusiCave";
        return response()->view('users.playlist.buat', compact('title'));
    }

    protected function contohPlaylist(): Response
    {
        $title = "MusiCave";
        return response()->view('users.playlist.contoh', compact('title'));
    }

    protected function disukaiPlaylist(): Response
    {
        $title = "MusiCave";
        return response()->view('users.playlist.disukai', compact('title'));
    }
}
