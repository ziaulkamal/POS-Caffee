<?php

namespace Database\Seeders;

use App\Models\MitraProduct;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MitraProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            ['nama' => 'Keripik', 'harga' => 1000],
            ['nama' => 'Peyek', 'harga' => 1000],
            ['nama' => 'Pisang Sale', 'harga' => 1000],
            ['nama' => 'Kue Donat', 'harga' => 2000],
            ['nama' => 'Kue Biasa', 'harga' => 2000],
            ['nama' => 'Lainya 1K', 'harga' => 1000],
            ['nama' => 'Lainya 2K', 'harga' => 2000],
        ];

        foreach ($products as $item) {
            MitraProduct::create([
                'nama_produk' => $item['nama'],
                'kategori' => 'makanan',
                'harga' => $item['harga'],
                'kuantitas' => 100,
                'gambar' => null,
                'status' => fake()->randomElement(['tersedia', 'habis']),
                'terjual' => fake()->numberBetween(0, 100),
            ]);
        }
    }
}
