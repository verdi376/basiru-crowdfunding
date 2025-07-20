<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Create UMKM user
$user = new User();
$user->name = 'UMKM Contoh';
$user->email = 'umkm@contoh.com';
$user->password = Hash::make('password');
$user->role = 'umkm';
$user->save();

echo "User UMKM berhasil dibuat!\n";
echo "Email: umkm@contoh.com\n";
echo "Password: password\n";
