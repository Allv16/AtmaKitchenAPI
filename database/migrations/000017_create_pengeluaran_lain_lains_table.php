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
        Schema::create('pengeluaran_lain_lain', function (Blueprint $table) {
            $table->id('id_pengeluaran_lain_lain');
            $table->string('nama_pengeluaran');
            $table->dateTime('tanggal_pengeluaran');
            $table->double('total_pengeluaran');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengeluaran_lain_lains');
    }
};
