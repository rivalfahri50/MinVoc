<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class song extends Model
{
    use HasFactory;
    protected $fillable = [
        'code',
        'judul',
        'audio',
        'image',
        'waktu',
        'didengar',
        'likes',
        'is_approved',
        'genre_id',
        'album_id',
        'artis_id',
    ];

    public function artist()
    {
        return $this->hasOne(artist::class, 'id', 'artis_id');
    }

    public function genre()
    {
        return $this->hasOne(genre::class, 'id', 'genre_id');
    }
}
