<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Menampilkan Dashboard Admin (Beranda)
     */
    public function index()
    {
        // Data Mockup Statistik
        $stats = [
            'total_pengaduan' => 3,
            'menunggu' => 1,
            'diproses' => 1,
            'selesai' => 1,
            'total_pengguna' => 2,
            'total_berita' => 3
        ];

        // Data Mockup Pengaduan Terbaru
        $recents = [
            [
                'title' => 'Tabrak Lari',
                'user' => 'budi123',
                'date' => '13 Nov 2024',
                'status_class' => 'bg-pink-500',
                'status_label' => 'Menunggu'
            ],
            [
                'title' => 'Sampah Menumpuk di TPS',
                'user' => 'siti456',
                'date' => '14 Nov 2024',
                'status_class' => 'bg-slate-500',
                'status_label' => 'Diproses'
            ]
        ];

        return view('admin.dashboard', [
            'page' => 'dashboard',
            'stats' => $stats,
            'recents' => $recents
        ]);
    }

    /**
     * Menampilkan Halaman Kelola Laporan
     */
    public function reports()
    {
        // Data Dummy Laporan Lengkap
        $reports = [
            [
                'id' => 1,
                'title' => 'Tabrak Lari',
                'user' => 'budi123',
                'nik' => '3509123456789101',
                'location' => 'Jl. Mastrip',
                'category' => 'Lainnya',
                'description' => 'Ada kejadian tabrak lari oleh plat P 5678 IO',
                'status' => 'menunggu',
                'status_class' => 'bg-pink-500',
                'status_label' => 'MENUNGGU',
                'response' => null
            ],
            [
                'id' => 2,
                'title' => 'Sampah Menumpuk di TPS',
                'user' => 'siti456',
                'nik' => '3509234567890123',
                'location' => 'TPS Kelurahan Kaliwates',
                'category' => 'Kebersihan',
                'description' => 'Sampah di TPS sudah menumpuk tinggi dan menimbulkan bau tidak sedap.',
                'status' => 'diproses',
                'status_class' => 'bg-slate-500',
                'status_label' => 'DIPROSES',
                'prioritas' => 'Tinggi',
                'response' => [
                    'opd' => 'Belum ditugaskan',
                    'text' => 'Tim kebersihan akan segera menangani masalah ini.'
                ]
            ],
            [
                'id' => 3,
                'title' => 'Jalan Rusak di Jl. Merdeka',
                'user' => 'budi123',
                'nik' => '3509123456789101',
                'location' => 'Jl. Merdeka No. 45',
                'category' => 'Infrastruktur',
                'description' => 'Jalan di depan pasar mengalami kerusakan parah dengan banyak lubang.',
                'status' => 'selesai',
                'status_class' => 'bg-green-500', // Menggunakan warna hijau/primary
                'status_label' => 'VERIFIED',
                'response' => [
                    'opd' => 'Dinas PU',
                    'text' => 'Perbaikan jalan telah selesai dilakukan pada tanggal 22 November 2024.'
                ]
            ]
        ];

        return view('admin.dashboard', [
            'page' => 'laporan',
            'reports' => $reports
        ]);
    }

    /**
     * Menampilkan Halaman Kelola Pengguna
     */
    public function users()
    {
        // Data Dummy Pengguna
        $users = [
            [
                'initial' => 'BS',
                'name' => 'Budi Santoso',
                'username' => '@budi123',
                'email' => 'budi@example.com',
                'joined' => '10 Nov 2024',
                'complaint_count' => 2
            ],
            [
                'initial' => 'SN',
                'name' => 'Siti Nurhaliza',
                'username' => '@siti456',
                'email' => 'siti@example.com',
                'joined' => '12 Nov 2024',
                'complaint_count' => 1
            ]
        ];

        return view('admin.dashboard', [
            'page' => 'pengguna',
            'users' => $users
        ]);
    }

    /**
     * Menampilkan Halaman Kelola Berita
     */
    public function news()
    {
        return view('admin.dashboard', [
            'page' => 'berita'
        ]);
    }
}
