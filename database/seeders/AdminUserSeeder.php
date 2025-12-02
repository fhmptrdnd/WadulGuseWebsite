<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (User::where('username', 'adminwadul1')->exists()) {
            return;
        }

        User::create([
            'name' => 'Admin Utama',
            'username' => 'adminwadul1',
            'email' => 'rhespatyrio@gmail.com',
            'password' => Hash::make('Admin123'),
            'nik' => '3509001122334455',
            'nomor_telepon' => '081234567890',
            'alamat' => 'Pemkab Jember',
            'role' => 'admin',
            'is_active' => true,
        ]);

        $this->command->info('Akun Admin Utama telah berhasil ditambahkan!');
    }
}
