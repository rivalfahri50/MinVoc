<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class playlist extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'deskripsi',
        'image',
        'song_id',
    ];
}
