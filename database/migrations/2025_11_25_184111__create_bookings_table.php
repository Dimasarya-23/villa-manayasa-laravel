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
        // Membuat tabel 'bookings'
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            // foreignId ke tabel 'kamars'. Ini penting untuk menghubungkan booking dengan kamar mana
            $table->foreignId('kamar_id')->constrained('kamars')->onDelete('cascade');
            $table->string('guest_name');
            $table->date('check_in_date');
            $table->date('check_out_date');
            $table->string('source')->nullable()->comment('Sumber booking: WhatsApp, Booking.com, dll.'); 
            $table->decimal('total_price', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};