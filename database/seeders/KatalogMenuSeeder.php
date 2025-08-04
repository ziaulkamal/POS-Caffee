<?php

namespace Database\Seeders;

use App\Models\KatalogMenu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KatalogMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menus = [
            'Kopi Hitam',
            'Kopi Susu',
            'Cappuccino',
            'Latte',
            'Americano',
            'Espresso',
            'Kopi Tubruk',
            'Matcha Latte',
            'Coklat Panas',
            'Teh Tarik',
            'Es Teh Manis',
            'Lemon Tea',
            'Cold Brew',
            'Es Kopi Susu',
            'Es Coklat',
            'Thai Tea',
            'Green Tea',
            'Taro Latte',
            'Vanilla Latte',
            'Kopi Aren'
        ];

        foreach ($menus as $menu) {
            KatalogMenu::create([
                'kategori' => fake()->randomElement(['panas', 'dingin']),
                'nama_menu' => $menu,
                'harga' => fake()->randomFloat(2, 8000, 25000),
                'gambar' => null, // atau bisa isi 'kopi.jpg'
                'status' => fake()->randomElement(['tersedia', 'habis']),
            ]);
        }
    }
}
