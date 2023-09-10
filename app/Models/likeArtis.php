<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class likeArtis extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','artist_id'];

    public function user() {
        return $this->belongsTo(user::class);
    }

    public function artist() {
        return $this->belongsTo(artist::class);
    }
}
