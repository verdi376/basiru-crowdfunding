<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdminCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-admin-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->ask('Masukkan nama admin');
        $email = $this->ask('Masukkan email admin');
        $password = $this->secret('Masukkan password');

        // Cek apakah email sudah dipakai
        if (User::where('email', $email)->exists()) {
            $this->error("Email '$email' sudah terdaftar.");
            return;
        }

        // Simpan ke database
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'role' => 'admin',
        ]);

        $this->info("Admin berhasil dibuat dengan email: {$user->email}");
        $this->info("Password: {$password}");
    }
}
