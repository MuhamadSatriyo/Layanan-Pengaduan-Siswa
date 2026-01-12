<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        foreach (Kategori::defaultKategori() as $kategori) {
            Kategori::firstOrCreate($kategori);
        }
    }
}