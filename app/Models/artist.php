<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class artist extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'is_verified',
    ];

    public function user()
    {
        return $this->hasOne(user::class, 'id', 'user_id');
    } 

}
