<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            [ 'email' => 'admin123@gmail.com' ],
            [
                'name' => 'Admin',
                'email' => 'admin123@gmail.com',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'saldo' => 0,
            ]
        );
    }
}
