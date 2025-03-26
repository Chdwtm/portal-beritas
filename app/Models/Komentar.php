<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Komentar extends Model
{
    use HasFactory;

    protected $fillable = ['berita_id', 'user_id', 'komentar'];
    public $timestamps = true; // Pastikan timestamps aktif agar waktu komentar tersimpan otomatis

    // **Relasi ke User**
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // **Relasi ke Berita**
    public function berita()
    {
        return $this->belongsTo(Berita::class, 'berita_id');
    }
}