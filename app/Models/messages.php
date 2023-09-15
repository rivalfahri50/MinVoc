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
        'receiver_id_1',
        'receiver_id_2',
        'project_id',
        'message',
    ];

    public function sender()
    {
        return $this->hasOne(artist::class, 'id', 'sender_id');
    }

    public function receiver()
    {
        return $this->hasOne(artist::class, 'id', 'receiver_id');
    }

    public function project()
    {
        return $this->hasOne(projects::class, 'id', 'project_id');
    }
}
