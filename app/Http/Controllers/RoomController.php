<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// Ganti 'Kamar' dengan nama Model yang Anda gunakan untuk tabel kamar
use App\Models\Kamar; 

class RoomController extends Controller
{
    /**
     * Menampilkan daftar semua kamar yang tersedia.
     */
    public function index(Request $request)
    {
        // 1. Ambil input filter dari URL (misalnya, ?check_in=...)
        $checkIn = $request->input('check_in');
        $checkOut = $request->input('check_out');

        // 2. Logika Sederhana: Ambil semua kamar sebagai demo.
        //    DI SINI Anda seharusnya menambahkan logika filtering ketersediaan 
        //    berdasarkan $checkIn dan $checkOut.
        $rooms = Kamar::all(); // Ganti dengan query database yang sesuai

        // 3. Kirim data kamar ke View
        return view('rooms.index', [
            'rooms' => $rooms,
            // Anda juga dapat mengirim variabel filter kembali untuk mengisi kolom tanggal di form
            'check_in_date' => $checkIn,
            'check_out_date' => $checkOut,
        ]);
    }
}