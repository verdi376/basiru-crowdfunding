<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('umkms', function (Blueprint $table) {
            $table->string('status_distribusi')->default('belum')->after('persentase_admin');
        });
    }
    public function down()
    {
        Schema::table('umkms', function (Blueprint $table) {
            $table->dropColumn('status_distribusi');
        });
    }
};
