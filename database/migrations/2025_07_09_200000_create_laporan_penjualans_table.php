<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('laporan_penjualans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('umkm_id');
            $table->string('file');
            $table->string('keterangan')->nullable();
            $table->enum('status', ['menunggu', 'terverifikasi', 'ditolak'])->default('menunggu');
            $table->timestamps();

            $table->foreign('umkm_id')->references('id')->on('umkms')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan_penjualans');
    }
};
