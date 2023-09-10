<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, CanResetPassword;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code',
        'avatar',
        'deskripsi',
        'name',
        'email',
        'password',
        'role_id',
    ];

    public function likedSongs()
    {
        return $this->belongsToMany(Song::class, 'likes', 'user_id', 'song_id')->withTimestamps();
    }

    public function hasLikedSong($songId)
    {
        return $this->likedSongs->contains($songId);
    }

    public function likeArtist()
    {
        return $this->belongsToMany(artist::class, 'likes', 'user_id', 'artist_id')->withTimestamps();
    }
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
