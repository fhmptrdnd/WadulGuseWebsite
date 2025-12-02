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
            // Foreign Key ke tabel 'kategori_opd'
            $table->foreign('opd_id')->references('opd_id')->on('kategori_opd')->onDelete('set null');
            
            // Foreign Key ke tabel 'users' (ditangani_oleh)
            $table->foreign('ditangani_oleh')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reports', function (Blueprint $table) {
            $table->dropForeign(['reports_opd_id_foreign']); 
            $table->dropForeign(['reports_ditangani_oleh_foreign']);
        });
    }
};
