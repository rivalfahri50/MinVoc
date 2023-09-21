<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class opsiPembayaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'tipe',
        'pendapatanArtis',
        'pendapatanAdmin',
    ];
}
