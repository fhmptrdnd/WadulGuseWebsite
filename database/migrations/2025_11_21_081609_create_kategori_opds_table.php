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
        Schema::create('kategori_opd', function (Blueprint $table) {
            $table->id('opd_id'); 
            $table->string('nama_opd');
            $table->text('deskripsi')->nullable();
            $table->string('email_kontak')->nullable();
            $table->string('nomor_telepon')->nullable();
            $table->string('kategori_tanggungan'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kategori_opd');
    }
};
