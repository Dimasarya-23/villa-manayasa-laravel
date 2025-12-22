<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations (Menambahkan kolom).
     */
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Tambahkan kolom user_id sebagai foreign key yang mengacu ke tabel users
            // Menggunakan nullable() agar data booking lama yang belum punya user_id tidak error
            $table->foreignId('user_id')->nullable()->constrained()->after('id'); 
        });
    }

    /**
     * Reverse the migrations (Menghapus kolom).
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Hapus foreign key constraint dan kolomnya saat rollback
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};