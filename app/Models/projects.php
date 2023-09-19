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
        'images',
        'audio',
        'harga',
        'is_take',
        'artist_id',
        'request_project_artis_id_1',
        'request_project_artis_id_2',
        'status',
        'pengajuan_project',
        'pembuat_project',
        'penerima_project',
        'is_reject',
        'is_approved',
    ];

public function artis()
    {
        return $this->hasOne(artist::class, 'id', 'artist_id');
    }

    public function messages()
    {
        return $this->hasMany(messages::class, 'project_id');
    }
}
