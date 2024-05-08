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
        Schema::create('transaksi', function (Blueprint $table) {
            $table->string('id_transaksi');
            $table->primary('id_transaksi');
            $table->dateTime('tanggal_nota_dibuat');
            $table->dateTime('tanggal_diterima')->nullable();
            $table->dateTime('tanggal_diproses')->nullable();
            $table->dateTime('tanggal_ditolak')->nullable();
            $table->dateTime('tanggal_siap')->nullable();
            $table->dateTime('tanggal_ambil')->nullable();
            $table->dateTime('tanggal_selesai')->nullable();
            $table->dateTime('tanggal_diambil')->nullable(); //untuk transaksi pickup
            $table->integer('poin_digunakan')->nullable();
            $table->integer('poin_diperoleh')->nullable();
            $table->double('total');
            $table->string('jenis_pengiriman');
            $table->string('status_transaksi');


            $table->foreignId('id_customer')->references('id_customer')->on('customers');
            $table->foreignId('id_pembayaran')->references('id_pembayaran')->on('pembayaran');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
