<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class album extends Model
{
    use HasFactory;
    protected $fillable = [
        'code',
        'artis_id',
        'name',
        'image',
    ];

    public function artis()
    {
        return $this->hasOne(artist::class, 'id', 'artis_id'); 
    }
}
