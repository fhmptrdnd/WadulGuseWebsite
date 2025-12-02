<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Fahmi Putra',
                'email' => 'fahmiputradendi@gmail.com',
                'nomor_telepon' => '081359749043',
                'nik' => '3509123456789101',
                'alamat' => 'Jl. Kaca Piring',
                'username' => 'miraen',
                'password' => Hash::make('12345678')
            ]
        ]);
    }
}
