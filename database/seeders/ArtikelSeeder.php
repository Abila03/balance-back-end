<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Artikel;

class ArtikelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Generate 10 data artikel
        for ($i = 1; $i <= 10; $i++) {
            Artikel::create([
                'judul' => 'Judul Artikel ' . $i,
                'isi' => 'Isi Artikel ' . $i,
                'kategori' => 'Kategori Artikel ' . $i,
                'id_pengguna' => $i,
            ]);
        }
    }
}
