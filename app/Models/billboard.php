<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class billboard extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'artis_id',
        'deskripsi',
        'image_background',
        'image_artis',
    ];

    public function artis()
    {
        return $this->hasOne(artist::class, 'id', 'artis_id');
    }
}
