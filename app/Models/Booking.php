<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    
    // Pastikan fillable sesuai dengan kolom di tabel
    protected $fillable = [
        'user_id', 
        'kamar_id', 
        'guest_name', 
        'check_in_date', 
        'check_out_date', 
        'source', 
        'total_price',
        'status', // <<< DITAMBAHKAN: Wajib untuk status pembayaran
        'preparation_status', // <<< DITAMBAHKAN: Wajib untuk Task Controller
    ];
    
    // Konversi kolom tanggal menjadi objek Carbon secara otomatis
    protected $casts = [
        'check_in_date' => 'date',
        'check_out_date' => 'date',
    ];

    /**
     * Relasi ke model Kamar.
     */
    public function kamar()
    {
        return $this->belongsTo(Kamar::class);
    }

    /**
     * Relasi ke model User (pemilik booking).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}