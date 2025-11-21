<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('reports', function (Blueprint $table) {
            // 1. Tambah kolom detail laporan
            $table->decimal('latitude', 10, 8)->nullable()->after('location');
            $table->decimal('longitude', 11, 8)->nullable()->after('latitude');

            // Ganti tipe data kolom 'status' (dari string biasa menjadi enum di migrasi reports lama)
            $table->string('status')->default('pending')->change();

            $table->enum('prioritas', ['rendah', 'sedang', 'tinggi'])->default('sedang')->after('is_active');

            // 2. Tambah kolom relasi ke OPD dan prioritas serta penanganan
            $table->unsignedBigInteger('ditangani_oleh')->nullable()->after('prioritas');
            $table->unsignedBigInteger('opd_id')->nullable()->after('ditangani_oleh');

            // 3. Rename kolom (feedback -> keterangan_admin)
            // $table->renameColumn('feedback', 'keterangan_admin');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reports', function (Blueprint $table) {
            // Drop kolom baru
            $table->dropColumn(['latitude', 'longitude', 'prioritas', 'opd_id', 'ditangani_oleh']);

            // Kembalikan nama kolom
            $table->renameColumn('keterangan_admin', 'feedback');

            // Kembalikan status ke tipe string
            $table->string('status')->default('pending')->change();
        });
    }
};
