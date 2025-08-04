<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MitraProduct extends Model
{
    use HasFactory;

    protected $table = 'mitra_products';

    protected $fillable = [
        'nama_produk',
        'kategori',
        'harga',
        'kuantitas',
        'gambar',
        'status',
        'terjual',
    ];
}
