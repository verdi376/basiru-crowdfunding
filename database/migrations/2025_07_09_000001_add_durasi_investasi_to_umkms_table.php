<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('umkms', function (Blueprint $table) {
            $table->unsignedInteger('durasi_investasi')->default(10)->after('deskripsi'); // default 10 bulan
            $table->decimal('persentase_admin', 5, 2)->default(5.00)->after('durasi_investasi'); // default 5%
        });
    }

    public function down()
    {
        Schema::table('umkms', function (Blueprint $table) {
            $table->dropColumn(['durasi_investasi', 'persentase_admin']);
        });
    }
};
