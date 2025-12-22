<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Kamar; 
use App\Models\Booking; 
use App\Models\User; 
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Menampilkan dashboard utama berdasarkan peran pengguna (Admin/Staff atau Tamu).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Pastikan pengguna sudah login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Logika KHUSUS ADMIN/STAFF
        if ($user->role === 'admin' || $user->role === 'Staff') {
            
            // 1. Menghitung Statistik Kamar ($statsKamar)
            $totalKamar = Kamar::count();
            $kamarAvailable = Kamar::where('status', 'available')->count();
            $kamarOccupied = Kamar::where('status', 'occupied')->count();
            $kamarCleaning = Kamar::where('status', 'cleaning')->count();
            $kamarMaintenance = Kamar::where('status', 'maintenance')->count();

            $statsKamar = [
                'total_units' => $totalKamar,
                'available' => $kamarAvailable,
                'occupied' => $kamarOccupied,
                'cleaning' => $kamarCleaning,
                'maintenance' => $kamarMaintenance,
                'other' => $totalKamar - ($kamarAvailable + $kamarOccupied + $kamarCleaning + $kamarMaintenance),
            ];
            
            // 2. Menghitung Pemesanan Masuk HARI INI
            $today = Carbon::today();
            
            // *** REVISI KRUSIAL DI SINI ***
            // Menambahkan 'Pending Payment' sesuai dengan nilai aktual di database Anda
            $todayBookings = Booking::with('user', 'kamar') 
                ->whereDate('check_in_date', $today)
                // Filter status: Sekarang termasuk 'Pending Payment'
                ->whereIn('status', ['confirmed', 'checked_in', 'pending', 'Pending Payment']) 
                ->orderBy('check_in_date', 'asc')
                ->get();

            // Menghitung jumlah total pemesanan untuk kartu statistik
            $pemesananHariIni = $todayBookings->count();

            // 3. Menghitung Total Akun Staff/Admin ($totalStaffAdmin)
            $totalStaffAdmin = User::whereIn('role', ['admin', 'Staff'])->count(); 

            // Mengembalikan view dashboard untuk Admin/Staff
            return view('dashboard', [
                'statsKamar' => $statsKamar,
                'pemesananHariIni' => $pemesananHariIni, 
                'totalStaffAdmin' => $totalStaffAdmin,
                'todayBookings' => $todayBookings, 
            ]);

        } else {
            // Logika KHUSUS TAMU/USER
            
            $userBookings = Booking::with('kamar')
                ->where('user_id', $user->id)
                ->orderBy('check_in_date', 'desc')
                ->limit(5)
                ->get();
                
            $latestActiveReservation = Booking::where('user_id', $user->id)
                ->with('kamar')
                ->where('check_out_date', '>=', Carbon::today()) 
                ->orderBy('check_in_date', 'asc') 
                ->first();

            return view('dashboard', [
                'userBookings' => $userBookings,
                'latestActiveReservation' => $latestActiveReservation,
            ]);
        }
    }
}