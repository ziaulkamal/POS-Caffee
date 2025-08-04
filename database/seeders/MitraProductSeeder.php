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
        $makanan = [
            'Nasi Goreng',
            'Mie Goreng',
            'Mie Rebus',
            'Soto Ayam',
            'Bakso',
            'Nasi Uduk',
            'Ayam Geprek',
            'Roti Bakar',
            'Sosis Bakar',
            'Tahu Bakso',
            'Pempek',
            'Tahu Crispy',
            'Kentang Goreng',
            'Cireng',
            'Seblak',
            'Pisang Coklat',
            'Tempe Mendoan',
            'Indomie Rebus',
            'Indomie Goreng',
            'Martabak Mini'
        ];

        foreach ($makanan as $item) {
            MitraProduct::create([
                'nama_produk' => $item,
                'kategori' => 'makanan',
                'harga' => fake()->randomFloat(2, 5000, 20000),
                'kuantitas' => fake()->numberBetween(10, 100),
                'gambar' => null,
                'status' => fake()->randomElement(['tersedia', 'habis']),
                'terjual' => fake()->numberBetween(0, 100),
            ]);
        }
    }
}
