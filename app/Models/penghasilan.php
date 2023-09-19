<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class penghasilan extends Model
{
    use HasFactory;
    protected $table = 'penghasilan';
    protected $fillable = [
        'artist_id',
        'penghasilan',
        'status',
        'bulan',
        'is_take',
        'terakhir_diambil',
        'penghasilanCair',
        'Pengajuan',
        'is_submit',
        'Pengajuan_tanggal'
    ];
    public function artist()
    {
        return $this->hasOne(artist::class, 'id', 'artist_id');
    }
}
