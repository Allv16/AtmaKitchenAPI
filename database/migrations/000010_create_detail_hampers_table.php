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
        Schema::create('detail_hampers', function (Blueprint $table) {
            $table->id('id_detail_hampers');

            $table->foreignId('id_hampers')->references('id_produk')->on('produk');
            $table->foreignId('id_produk')->references('id_produk')->on('produk');
            $table->foreignId('id_kemasan')->reference('id_bahan_baku')->on('bahan_baku');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_hampers');
    }
};
