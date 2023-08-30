<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\song;
use Illuminate\Http\Request;

class songController extends Controller
{
    public function ambillagu(){
       $semualagu = song::all();
       return response()->json($semualagu);
    }
}
