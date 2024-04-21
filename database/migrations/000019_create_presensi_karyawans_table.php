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
        Schema::create('presensi_karyawan', function (Blueprint $table) {
            $table->id('id_presensi_karyawan');
            $table->date('tanggal_absen');

            $table->foreignId('id_karyawan')->references('id_karyawan')->on('karyawan');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presensi_karyawans');
    }
};
