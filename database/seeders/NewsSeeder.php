<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User; // ADDED: Untuk mencari admin ID
use Illuminate\Support\Str; // ADDED: Untuk membuat slug

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Dapatkan ID admin yang sudah ada
        // Asumsi admin sudah dibuat oleh AdminUserSeeder
        $admin = User::where('role', 'admin')->first();

        if (!$admin) {
            $this->command->warn('Admin user tidak ditemukan. Lewati NewsSeeder.');
            return;
        }

        // 2. Masukkan data berita ke tabel 'news'
        DB::table('news')->insert([
            [
                'admin_id' => $admin->id,
                'judul_berita' => 'Pemberitahuan Perbaikan Jalan Utama',
                // Membuat slug unik (penting untuk routing)
                'slug' => Str::slug('Pemberitahuan Perbaikan Jalan Utama') . '-' . time(),
                'konten' => 'Dinas Pekerjaan Umum akan melaksanakan perbaikan besar di Jalan Ahmad Yani mulai minggu depan. Mohon maaf atas ketidaknyamanan yang ditimbulkan.',
                'gambar_thumbnail' => null, 
                'tanggal_dibuat' => now(),
                'tanggal_update' => now(),
            ],
            [
                'admin_id' => $admin->id,
                'judul_berita' => 'Aksi Bersih Sampah Massal di Pantai',
                'slug' => Str::slug('Aksi Bersih Sampah Massal di Pantai') . '-' . (time() - 3600),
                'konten' => 'Warga Wadul Guse berpartisipasi dalam kegiatan bersih-bersih pantai sebagai bentuk kepedulian terhadap lingkungan.',
                'gambar_thumbnail' => null,
                'tanggal_dibuat' => now()->subDays(2),
                'tanggal_update' => now()->subDays(2),
            ],
        ]);
        
        $this->command->info('Data Berita dasar berhasil ditambahkan!');
    }
}