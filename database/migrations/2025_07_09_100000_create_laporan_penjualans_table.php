<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporan_penjualans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('umkm_id')->constrained()->onDelete('cascade');
            $table->string('file_path');
            $table->enum('status', ['pending', 'diterima', 'ditolak'])->default('pending');
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan_penjualans');
    }
};
