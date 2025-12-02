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
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            
            // Kolom FK ke Admin (Penulis)
            $table->unsignedBigInteger('admin_id');
            
            $table->string('judul_berita', 200);
            $table->string('slug', 255)->unique();
            $table->text('konten');
            $table->string('gambar_thumbnail', 255)->nullable();
            
            // Kolom Waktu Sesuai ERD (Menggantikan timestamps())
            $table->timestamp('tanggal_dibuat')->useCurrent();
            $table->timestamp('tanggal_update')->nullable();

            // Foreign Key
            $table->foreign('admin_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};