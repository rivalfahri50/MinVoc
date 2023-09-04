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
        return $this->hasOne(user::class, 'id', 'user_id');
    }
}
