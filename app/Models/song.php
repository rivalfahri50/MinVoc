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
        'genre',
        'audio',
        'image',
        'artist_id',
        'is_approved',
    ];

    public function artist()
    {
        return $this->hasOne(artist::class, 'id', 'artist_id');
    }
}
