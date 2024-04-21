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
        Schema::create('pembelian_bahan_baku', function (Blueprint $table) {
            $table->id('id_pembelian_bahan_baku');
            $table->dateTime('tanggal_pembelian');
            $table->integer('jumlah_pembelian');
            $table->float('harga_beli');

            $table->foreignId('id_bahan_baku')->references('id_bahan_baku')->on('bahan_baku');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembelian_bahan_bakus');
    }
};
