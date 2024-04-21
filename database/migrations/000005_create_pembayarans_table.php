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
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id('id_pembayaran');
            $table->string('jenis_pembayaran');
            $table->string('bukti_pembayaran')->nullable();
            $table->dateTime('tanggal_pembayaran');
            $table->dateTime('tanggal_pembayaran_valid')->nullable();
            $table->decimal('total_pembayaran', 15, 2);
            $table->decimal('tip', 15, 2);

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
        Schema::dropIfExists('pembayarans');
    }
};
