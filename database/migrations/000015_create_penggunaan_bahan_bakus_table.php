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
        Schema::create('penggunaan_bahan_baku', function (Blueprint $table) {
            $table->id('id_penggunaan_bahan_baku');
            $table->dateTime('tanggal_penggunaan');
            $table->integer('jumlah_penggunaan');

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
        Schema::dropIfExists('penggunaan_bahan_bakus');
    }
};
