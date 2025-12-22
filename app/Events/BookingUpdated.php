<?php

namespace App\Events;

use App\Models\Booking; // Sesuaikan dengan model Booking Anda
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class BookingUpdated implements ShouldBroadcast
{
    use Dispatchable, SerializesModels;

    /**
     * Instans booking yang diperbarui.
     *
     * @var \App\Models\Booking
     */
    public $booking;
    
    /**
     * Nama event yang akan disiarkan di sisi klien/JavaScript.
     *
     * @var string
     */
    public $broadcastAs = 'reservation.updated';

    /**
     * Buat instance event baru.
     *
     * @param \App\Models\Booking $booking
     * @return void
     */
    public function __construct(Booking $booking)
    {
        // Muat data relasi 'kamar' agar tersedia saat di-broadcast
        $this->booking = $booking->load('kamar'); 
    }

    /**
     * Dapatkan saluran (channels) tempat event harus disiarkan.
     * * Kami menggunakan PrivateChannel untuk memastikan hanya user yang bersangkutan 
     * yang menerima update, berdasarkan user_id dari booking.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        // Channel: 'user.{user_id}'
        return new PrivateChannel('user.' . $this->booking->user_id);
    }
}