<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Pastikan tabel 'bookings' ada sebelum mencoba menambah kolom.
        if (Schema::hasTable('bookings')) {
            Schema::table('bookings', function (Blueprint $table) {
                // Tambahkan kolom 'preparation_status' setelah kolom 'status'
                // Default value diatur ke 'Pending'
                $table->string('preparation_status')->default('Pending')->after('status');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('bookings')) {
            Schema::table('bookings', function (Blueprint $table) {
                // Hapus kolom saat rollback
                $table->dropColumn('preparation_status');
            });
        }
    }
};