<?php

use Illuminate\Support\Facades\DB;

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Dapatkan daftar tabel di database
$tables = DB::select('SHOW TABLES');

echo "Daftar tabel di database:\n";
foreach ($tables as $table) {
    foreach ($table as $key => $value) {
        echo "- $value\n";
    }
}

// Periksa apakah tabel laporan_penjualan ada
$tableExists = DB::getSchemaBuilder()->hasTable('laporan_penjualan');
echo "\nTabel 'laporan_penjualan' " . ($tableExists ? 'ada' : 'tidak ada') . " di database.\n";

// Periksa struktur tabel laporan_penjualan jika ada
if ($tableExists) {
    echo "\nStruktur tabel 'laporan_penjualan':\n";
    $columns = DB::select('DESCRIBE laporan_penjualan');
    foreach ($columns as $column) {
        echo "- {$column->Field}: {$column->Type}\n";
    }
}
