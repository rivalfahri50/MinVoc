<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class penghasilan extends Model
{
    use HasFactory;
    protected $table = 'penghasilan';
    protected $fillable = ['artist_id','penghasilan','bulan'];
    // public function riwayat() {
    //     return $this->belongsTo(Riwayat::class);
    // }
    public function artist() {
        return $this->belongsTo(artist::class,'id','user_id');
    }
}

