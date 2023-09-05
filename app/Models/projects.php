<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class projects extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'konsep',
        'judul',
        'lirik',
        'harga',
        'artist_id',
        'is_approved',
        'is_reject',
    ];
}
