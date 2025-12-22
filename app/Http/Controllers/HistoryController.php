<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // PENTING: Untuk mendapatkan ID user yang sedang login
use App\Models\Booking; // <<< PERBAIKAN: Menggunakan Model Booking (sesuai yang ada di Models Anda)

class HistoryController extends Controller
{
    /**
     * Menampilkan daftar riwayat pemesanan untuk pengguna yang sedang login.
     */
    public function index()
    {
        // 1. Ambil ID pengguna yang sedang login
        $userId = Auth::id();
        
        // 2. Ambil semua reservasi yang dibuat oleh pengguna ini.
        // Sekarang menggunakan Model Booking
        $histories = Booking::where('user_id', $userId)
                                ->orderBy('check_in_date', 'desc') // Urutkan dari yang terbaru
                                ->get();

        // 3. Kirim data riwayat pemesanan ke View (history.blade.php)
        return view('history', [
            'histories' => $histories,
            'title' => 'Riwayat Pemesanan',
        ]);
    }
}