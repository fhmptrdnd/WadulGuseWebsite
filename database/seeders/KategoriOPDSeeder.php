<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; 
class KategoriOpdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('kategori_opd')->insert([
            [
                'nama_opd' => 'Dinas Pekerjaan Umum',
                'deskripsi' => 'Menangani laporan terkait infrastruktur jalan, drainase, dan bangunan publik.',
                'email_kontak' => 'pu@jemberkab.go.id',
                'nomor_telepon' => '0331445566',
                'kategori_tanggungan' => 'Infrastruktur',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_opd' => 'Dinas Lingkungan Hidup',
                'deskripsi' => 'Menangani laporan terkait kebersihan, sampah, dan pencemaran lingkungan.',
                'email_kontak' => 'dlh@jemberkab.go.id',
                'nomor_telepon' => '0331778899',
                'kategori_tanggungan' => 'Lingkungan, Kebersihan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_opd' => 'Satpol PP',
                'deskripsi' => 'Menangani laporan terkait ketertiban umum dan keamanan non-kriminal.',
                'email_kontak' => 'satpol@jemberkab.go.id',
                'nomor_telepon' => '0331112233',
                'kategori_tanggungan' => 'Keamanan, Ketertiban',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}