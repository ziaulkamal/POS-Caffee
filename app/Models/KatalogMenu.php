<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KatalogMenu extends Model
{
    use HasFactory;

    protected $table = 'katalog_menus';

    protected $fillable = [
        'kategori',
        'nama_menu',
        'harga',
        'gambar',
        'status',
    ];
}
