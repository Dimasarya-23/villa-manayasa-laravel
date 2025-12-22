<?php

use Illuminate\Database\Migrations\Migration; // <-- BARIS INI WAJIB ADA!
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Membuat tabel 'kamars'
        Schema::create('kamars', function (Blueprint $table) {
            $table->id(); 
            $table->string('tipe_kamar', 50)->comment('Nama atau Tipe Kamar'); 
            $table->unsignedInteger('harga_per_malam')->comment('Harga dalam Rupiah'); 
            $table->string('status', 20)->default('Available')->comment('Status ketersediaan kamar'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kamars');
    }
};