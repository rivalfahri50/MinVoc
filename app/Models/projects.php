<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class projects extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'konsep',
        'judul',
        'lirik',
        'harga',
        'artist_id',
        'is_approved',
        'is_reject',
    ];

    public function artist_pembuatProject()
    {
        return $this->hasOne(artist::class, 'pembuat_project', 'artis_id');
    }

    public function artist_penerimaProject()
    {
        return $this->hasOne(artist::class, 'penerima_project', 'artis_id');
    }
}
