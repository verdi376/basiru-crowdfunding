<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Ubah tipe kolom role menjadi ENUM
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'umkm', 'investor', 'pengguna') NOT NULL DEFAULT 'pengguna'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Kembalikan ke tipe string default
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('pengguna')->change();
        });
    }
};
