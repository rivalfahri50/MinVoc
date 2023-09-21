<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class aturanPembayaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'opsi_id',
        'pendapatanArtis',
        'pendapatanAdmin',
    ];

    public function opsi()
    {
        return $this->hasOne(opsiPembayaran::class, 'id', 'opsi_id');
    }
}
