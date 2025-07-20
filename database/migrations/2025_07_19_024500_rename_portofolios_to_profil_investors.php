<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::rename('portofolios', 'profil_investors');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::rename('profil_investors', 'portofolios');
    }
};
