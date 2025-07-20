<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('dividend_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('investor_id')->constrained('users');
            $table->foreignId('umkm_id')->constrained('umkms');
            $table->decimal('amount', 15, 2);
            $table->string('period'); // Format: YYYY-MM
            $table->enum('status', ['pending', 'paid', 'failed'])->default('pending');
            $table->date('paid_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dividend_payments');
    }
};
