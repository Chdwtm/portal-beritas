<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $fillable = ['nama'];

    public function beritas()
    {
        return $this->hasMany(Berita::class, 'kategori_id', 'id'); // Pastikan relasi benar
    }
}