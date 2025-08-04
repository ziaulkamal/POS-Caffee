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
        Schema::create('katalog_menus', function (Blueprint $table) {
            $table->id();
            $table->enum('kategori', ['panas', 'dingin']);
            $table->string('nama_menu');
            $table->double('harga', 8, 2);
            $table->text('gambar')->nullable();
            $table->enum('status', ['tersedia', 'habis'])->default('tersedia');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('katalog_menus');
    }
};
