<?php

use App\Http\Controllers\BillingController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\TransaksiController;
use Illuminate\Support\Facades\Route;





Route::get('/', [PageController::class, 'katalog'])->name('katalog');
Route::get('/keranjang', [PageController::class, 'keranjang'])->name('keranjang');
Route::get('/transaksi', [PageController::class, 'transaksi'])->name('transaksi');
Route::post('/checkout/proses', [TransaksiController::class, 'store'])->name('checkout.proses');

Route::post('/billing/bayar/{kode_trx}', [BillingController::class, 'bayar'])->name('billing.bayar');
Route::get('/billing/edit/{kode_trx}', [BillingController::class, 'edit'])->name('billing.edit');

Route::get('/edit-transaksi/{kode_trx}', [PageController::class, 'edit'])->name('billing.edit');
Route::post('/billing/{kode_trx}/bayar', [PageController::class, 'bayar'])->name('billing.bayar');
