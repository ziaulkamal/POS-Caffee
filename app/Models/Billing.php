<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Billing extends Model
{
    use HasFactory;

    protected $table = 'billings';

    protected $fillable = [
        'nama_pelanggan',
        'kode_trx',
        'total_bayar',
        'status',
        'metode_bayar',
    ];
}
