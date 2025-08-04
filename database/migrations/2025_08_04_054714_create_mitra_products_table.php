<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mitra_products', function (Blueprint $table) {
            $table->id();
            $table->string('nama_produk');
            $table->enum('kategori', ['makanan', 'minuman']);
            $table->double('harga', 8, 2);
            $table->integer('kuantitas')->default(0);
            $table->text('gambar')->nullable();
            $table->enum('status', ['tersedia', 'habis'])->default('tersedia');
            $table->integer('terjual')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mitra_products');
    }
};
