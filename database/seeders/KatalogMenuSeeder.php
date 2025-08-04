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
            ['kategori' => 'panas', 'nama_menu' => 'Lemon Tea', 'harga' => 5000, 'gambar' => null, 'status' => 'tersedia'],
            ['kategori' => 'dingin', 'nama_menu' => 'Lemon Tea', 'harga' => 10000, 'gambar' => null, 'status' => 'tersedia'],
            ['kategori' => 'panas', 'nama_menu' => 'teh tarik', 'harga' => 5000, 'gambar' => null, 'status' => 'tersedia'],
            ['kategori' => 'dingin', 'nama_menu' => 'teh tarik', 'harga' => 10000, 'gambar' => null, 'status' => 'tersedia'],
            ['kategori' => 'panas', 'nama_menu' => 'teh', 'harga' => 3000, 'gambar' => null, 'status' => 'tersedia'],
            ['kategori' => 'dingin', 'nama_menu' => 'teh', 'harga' => 5000, 'gambar' => null, 'status' => 'tersedia'],
            ['kategori' => 'panas', 'nama_menu' => 'teh hijau', 'harga' => 5000, 'gambar' => null, 'status' => 'tersedia'],
            ['kategori' => 'dingin', 'nama_menu' => 'teh hijau', 'harga' => 6000, 'gambar' => null, 'status' => 'tersedia'],
            ['kategori' => 'panas', 'nama_menu' => 'Cappucino', 'harga' => 5000, 'gambar' => null, 'status' => 'tersedia'],
            ['kategori' => 'dingin', 'nama_menu' => 'Cappucino', 'harga' => 10000, 'gambar' => null, 'status' => 'tersedia'],
            ['kategori' => 'panas', 'nama_menu' => 'Milo', 'harga' => 5000, 'gambar' => null, 'status' => 'tersedia'],
            ['kategori' => 'dingin', 'nama_menu' => 'Milo', 'harga' => 10000, 'gambar' => null, 'status' => 'tersedia'],
            ['kategori' => 'panas', 'nama_menu' => 'Susu', 'harga' => 5000, 'gambar' => null, 'status' => 'tersedia'],
            ['kategori' => 'dingin', 'nama_menu' => 'Susu', 'harga' => 6000, 'gambar' => null, 'status' => 'tersedia'],
            ['kategori' => 'panas', 'nama_menu' => 'Matcha', 'harga' => 10000, 'gambar' => null, 'status' => 'tersedia'],
            ['kategori' => 'dingin', 'nama_menu' => 'Matcha', 'harga' => 10000, 'gambar' => null, 'status' => 'tersedia'],
            ['kategori' => 'panas', 'nama_menu' => 'Luwak', 'harga' => 5000, 'gambar' => null, 'status' => 'tersedia'],
            ['kategori' => 'dingin', 'nama_menu' => 'Luwak', 'harga' => 5000, 'gambar' => null, 'status' => 'tersedia'],
            ['kategori' => 'panas', 'nama_menu' => 'Susu jahe', 'harga' => 5000, 'gambar' => null, 'status' => 'tersedia'],
            ['kategori' => 'dingin', 'nama_menu' => 'Susu jahe', 'harga' => 5000, 'gambar' => null, 'status' => 'tersedia'],
            ['kategori' => 'panas', 'nama_menu' => 'Jahe', 'harga' => 5000, 'gambar' => null, 'status' => 'tersedia'],
            ['kategori' => 'dingin', 'nama_menu' => 'Jahe', 'harga' => 5000, 'gambar' => null, 'status' => 'tersedia'],
            ['kategori' => 'panas', 'nama_menu' => 'Nutrisari', 'harga' => 5000, 'gambar' => null, 'status' => 'tersedia'],
            ['kategori' => 'dingin', 'nama_menu' => 'Nutrisari', 'harga' => 5000, 'gambar' => null, 'status' => 'tersedia'],
            ['kategori' => 'panas', 'nama_menu' => 'sanger', 'harga' => 8000, 'gambar' => null, 'status' => 'tersedia'],
            ['kategori' => 'dingin', 'nama_menu' => 'sanger', 'harga' => 10000, 'gambar' => null, 'status' => 'tersedia'],
            ['kategori' => 'panas', 'nama_menu' => 'kopi', 'harga' => 5000, 'gambar' => null, 'status' => 'tersedia'],
            ['kategori' => 'dingin', 'nama_menu' => 'kopi', 'harga' => 10000, 'gambar' => null, 'status' => 'tersedia'],
            ['kategori' => 'panas', 'nama_menu' => 'kopi mix', 'harga' => 5000, 'gambar' => null, 'status' => 'tersedia'],
            ['kategori' => 'dingin', 'nama_menu' => 'kopi mix', 'harga' => 10000, 'gambar' => null, 'status' => 'tersedia'],
            ['kategori' => 'panas', 'nama_menu' => 'kopi jahe', 'harga' => 5000, 'gambar' => null, 'status' => 'tersedia'],
            ['kategori' => 'panas', 'nama_menu' => 'coklat', 'harga' => 10000, 'gambar' => null, 'status' => 'tersedia'],
            ['kategori' => 'dingin', 'nama_menu' => 'coklat', 'harga' => 10000, 'gambar' => null, 'status' => 'tersedia'],
            ['kategori' => 'panas', 'nama_menu' => 'TOP kopi', 'harga' => 5000, 'gambar' => null, 'status' => 'tersedia'],
            ['kategori' => 'dingin', 'nama_menu' => 'TOP kopi', 'harga' => 10000, 'gambar' => null, 'status' => 'tersedia'],
        ];

        foreach ($menus as $menu) {
            KatalogMenu::create($menu);
        }
    }
}
