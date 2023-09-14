<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class notif extends Model
{
    use HasFactory;

    protected $fillable = [
        'artis_id',
        'message',
        'title',
        'user_id',
        'is_reject',
    ];

    public function artis(): HasOne
    {
        return $this->hasOne(artist::class, 'id', 'artis_id');
    }
}
