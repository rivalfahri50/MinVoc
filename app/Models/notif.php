<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class notif extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'message',
        'title',
        'user_id',
        'song_id',
        'type',
        'is_reject',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    public function song()
    {
        return $this->hasOne(Song::class, 'id', 'song_id');
    }
}
