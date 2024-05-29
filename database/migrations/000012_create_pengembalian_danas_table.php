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
        Schema::create('pengembalian_dana', function (Blueprint $table) {
            $table->id('id_pengembalian_dana');
            $table->dateTime('tanggal_pengembalian_diajukan');
            $table->dateTime('tanggal_pengembalian_diterima')->nullable();
            $table->float('jumlah_pengembalian');
            $table->string('nomor_rekening_tujuan');
            $table->string('status_pengembalian');
            $table->foreignId('id_customer')->references('id_customer')->on('customers');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengembalian_danas');
    }
};
