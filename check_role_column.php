<?php

use Illuminate\Support\Facades\DB;

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Periksa struktur kolom role
$columns = DB::select("SHOW COLUMNS FROM users WHERE Field = 'role'");

if (count($columns) > 0) {
    $column = $columns[0];
    echo "Kolom 'role' ditemukan. Tipe: " . $column->Type . "\n";
    echo "Boleh NULL: " . ($column->Null === 'YES' ? 'Ya' : 'Tidak') . "\n";
    echo "Nilai default: " . ($column->Default ?? 'NULL') . "\n";
    
    // Perbarui kolom role menjadi ENUM
    try {
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'umkm', 'investor', 'pengguna') NOT NULL DEFAULT 'pengguna'");
        echo "Kolom 'role' berhasil diubah menjadi ENUM.\n";
    } catch (Exception $e) {
        echo "Gagal mengubah kolom 'role': " . $e->getMessage() . "\n";
    }
} else {
    echo "Kolom 'role' tidak ditemukan dalam tabel 'users'.\n";
}

// Periksa nilai-nilai unik di kolom role
$roles = DB::table('users')->select('role')->distinct()->get();
echo "\nNilai unik di kolom 'role':\n";
foreach ($roles as $role) {
    echo "- " . ($role->role ?? 'NULL') . "\n";
}
