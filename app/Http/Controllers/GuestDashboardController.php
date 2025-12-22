<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking; // Pastikan nama model ini benar (Booking.php)
use Carbon\Carbon; 

class GuestDashboardController extends Controller
{
    /**
     * Menampilkan dashboard dengan daftar pemesanan aktif milik user yang sedang login.
     */
    public function index()
    {
        // 1. Pengecekan otentikasi
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // 2. MENDAPATKAN ID USER YANG SEDANG LOGIN (Perbaikan Masalah Kritis #2)
        $userId = Auth::id(); // Mengambil ID user dan menyimpannya di variabel $userId
        
        // dd(Auth::id()); // HAPUS/KOMEN BARIS INI (Perbaikan Masalah Kritis #1)

        // 3. QUERY UNTUK MENGAMBIL SEMUA PEMESANAN AKTIF USER INI
        $activeBookings = Booking::where('user_id', $userId)
                                ->with('kamar') 
                                
                                // Memastikan pemesanan yang ditampilkan masih aktif (check-out belum terlewat)
                                ->where('check_out_date', '>=', Carbon::today()) 
                                
                                // Urutkan berdasarkan tanggal check-in terdekat (yang paling dulu)
                                ->orderBy('check_in_date', 'asc') 
                                
                                ->get(); // <-- Diganti dari ->first() menjadi ->get() untuk mendapatkan daftar

        // 4. Mengirim data ke View
        return view('dashboard-guest', [
            // Variabel disesuaikan agar lebih jelas (list pemesanan aktif)
            'activeBookings' => $activeBookings, 
            'user' => Auth::user(),
        ]);
    }
}