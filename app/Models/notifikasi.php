<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'role', 'judul','deskripsi','kategori'];

    // Metode untuk mengirim notifikasi persetujuan verifikasi artis
   }
