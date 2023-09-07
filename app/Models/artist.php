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
        'is_verified',
        'verification_status',
        'pengajuan_verified_at',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function song()
    {
        return $this->belongsTo(song::class, 'id', 'user_id');
    }
}
