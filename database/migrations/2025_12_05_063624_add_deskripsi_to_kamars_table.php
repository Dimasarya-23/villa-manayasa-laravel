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
            // Tambahkan kolom 'deskripsi' setelah kolom 'status'.
            // Kolom ini disetel sebagai nullable (opsional) sesuai dengan validasi di Controller.
            $table->text('deskripsi')->nullable()->after('status'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kamars', function (Blueprint $table) {
            // Hapus kolom 'deskripsi' jika migrasi di-rollback.
            $table->dropColumn('deskripsi');
        });
    }
};