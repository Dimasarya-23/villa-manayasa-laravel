<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kamar extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terkait dengan model (opsional jika nama tabel adalah 'kamars').
     * @var string
     */
    protected $table = 'kamars';

    /**
     * Wajib: Daftar kolom yang boleh diisi (Mass Assignable).
     * Harus mencakup SEMUA field yang ada di form input.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        // PERBAIKAN: Nomor kamar wajib diaktifkan agar bisa di-save/update
        'nomor_kamar', 
        'tipe_kamar',
        'harga_per_malam', 
        'kapasitas_tamu',  
        'status',
        'deskripsi', 
    ];

    /**
     * Atribut yang harus di-cast ke tipe bawaan.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'harga_per_malam' => 'integer', 
        'kapasitas_tamu' => 'integer', // Opsional, tapi baik untuk konsistensi
    ];

    /**
     * Relasi ke model Booking (One-to-Many).
     * Kamar memiliki banyak Pemesanan.
     */
    public function bookings()
    {
        // Diasumsikan Anda memiliki Model Booking.php
        return $this->hasMany(Booking::class);
    }
}