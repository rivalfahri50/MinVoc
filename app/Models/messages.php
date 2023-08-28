<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class messages extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'sender_id',
        'receiver_id',
        'project_id',
        'message',
    ];

    public function messages()
    {
        return $this->hasOne(User::class, 'id', 'sender_id');
    }
}
