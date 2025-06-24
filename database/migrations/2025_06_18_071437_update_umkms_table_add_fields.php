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
        Schema::table('umkms', function (Blueprint $table) {
            if (!Schema::hasColumn('umkms', 'kategori')) {
                $table->string('kategori')->nullable();
            }
            if (!Schema::hasColumn('umkms', 'lokasi')) {
                $table->string('lokasi')->nullable();
            }
            if (!Schema::hasColumn('umkms', 'kontak')) {
                $table->string('kontak')->nullable();
            }
            if (!Schema::hasColumn('umkms', 'foto')) {
                $table->string('foto')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('umkms', function (Blueprint $table) {
            $table->dropColumn(['kategori', 'lokasi', 'kontak', 'foto']);
        });
    }
};
