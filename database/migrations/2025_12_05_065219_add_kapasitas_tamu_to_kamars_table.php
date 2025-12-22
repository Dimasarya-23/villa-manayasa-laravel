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
        Schema::table('kamars', function (Blueprint $table) {
            // Tambahkan kolom 'kapasitas_tamu' sebagai integer, setelah harga_per_malam
            $table->integer('kapasitas_tamu')->after('harga_per_malam');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kamars', function (Blueprint $table) {
            // Hapus kolom 'kapasitas_tamu' jika migrasi di-rollback.
            $table->dropColumn('kapasitas_tamu');
        });
    }
};