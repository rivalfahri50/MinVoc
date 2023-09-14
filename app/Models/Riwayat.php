<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Riwayat extends Model
{
    use HasFactory;
    protected $table = 'riwayat';
    protected $fillable = ['user_id','song_id', 'play_date'];

    public function user(){
        return $this->belongsTo(song::class, 'user_id');
    }
    public function song(){
        return $this->belongsTo(song::class, 'song_id');
    }

}
