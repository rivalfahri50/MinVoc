<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class artist extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'user_id',
        'image',
        'likes',
        'is_verified',
        'verification_status',
        'penghasilan',
        'pengajuan_verified_at',
    ];
    public function likedByUsers()
    {
        return $this->belongsToMany(user::class, 'likes', 'user_id', 'artist_id')->withTimestamps();
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function song()
    {
        return $this->hasOne(Song::class, 'artis_id', 'id');
    }

    public function penghasilan() {
        return $this->hasMany(penghasilan::class,'id');
    }
}
