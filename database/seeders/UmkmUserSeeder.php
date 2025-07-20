<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UmkmUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan user dengan email ini belum ada
        if (!User::where('email', 'umkm@contoh.com')->exists()) {
            // Buat user UMKM
            $user = User::create([
                'name' => 'UMKM Contoh',
                'email' => 'umkm@contoh.com',
                'password' => Hash::make('password'),
                'role' => 'umkm',
                'email_verified_at' => now(),
            ]);

            $this->command->info('User UMKM berhasil dibuat!');
            $this->command->info('Email: umkm@contoh.com');
            $this->command->info('Password: password');
        } else {
            $this->command->info('User dengan email umkm@contoh.com sudah ada.');
        }
    }
}
