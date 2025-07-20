<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Langkah 1: Tambahkan kolom role_temp dengan tipe yang diinginkan
DB::statement("ALTER TABLE users ADD COLUMN role_temp VARCHAR(20) DEFAULT 'pengguna'");

// Langkah 2: Salin nilai dari kolom role ke role_temp dengan pemetaan yang sesuai
DB::statement("UPDATE users SET role_temp = 
    CASE 
        WHEN role = 'admin' THEN 'admin'
        WHEN role = 'user' THEN 'pengguna'
        ELSE 'pengguna'
    END");

// Langkah 3: Hapus kolom role lama
DB::statement("ALTER TABLE users DROP COLUMN role");

// Langkah 4: Ubah nama kolom role_temp menjadi role dengan tipe ENUM yang diinginkan
DB::statement("ALTER TABLE users CHANGE role_temp role ENUM('admin', 'umkm', 'investor', 'pengguna') NOT NULL DEFAULT 'pengguna'");

echo "Kolom 'role' berhasil diubah menjadi ENUM dengan nilai yang diinginkan.\n";

// Tampilkan hasil akhir
$columns = DB::select("SHOW COLUMNS FROM users WHERE Field = 'role'");
$column = $columns[0];
echo "\nStruktur kolom 'role' setelah perubahan:\n";
echo "Tipe: " . $column->Type . "\n";
echo "Boleh NULL: " . ($column->Null === 'YES' ? 'Ya' : 'Tidak') . "\n";
echo "Nilai default: " . ($column->Default ?? 'NULL') . "\n";

// Tampilkan nilai-nilai unik di kolom role
$roles = DB::table('users')->select('role')->distinct()->get();
echo "\nNilai unik di kolom 'role':\n";
foreach ($roles as $role) {
    echo "- " . $role->role . "\n";
}
