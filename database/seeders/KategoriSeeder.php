<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori;

class KategoriSeeder extends Seeder
{
    public function run()
    {
        Kategori::insert([
            ['nama' => 'Politik'],
            ['nama' => 'Ekonomi'],
            ['nama' => 'Olahraga'],
            ['nama' => 'Teknologi'],
            ['nama' => 'Hiburan'],
        ]);
    }
}