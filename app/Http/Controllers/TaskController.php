<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking; // Pastikan model Booking sudah ada
use App\Models\Kamar; // Jika Anda menggunakan model Kamar terpisah
use Carbon\Carbon;

class TaskController extends Controller
{
    /**
     * Menampilkan daftar pemesanan yang akan datang (3 hari ke depan) untuk persiapan.
     *
     * @return \Illuminate\View\View
     */
    public function incomingBookings()
    {
        // Mendapatkan tanggal hari ini dan batas 3 hari ke depan
        $today = Carbon::today();
        $threeDaysLater = Carbon::today()->addDays(3);

        // Mengambil pemesanan yang Check-in-nya dalam rentang hari ini hingga 3 hari ke depan.
        // Asumsi status pemesanan adalah 'Confirmed' atau sejenisnya.
        // NOTE: Sesuaikan kondisi 'status' dengan status pemesanan Anda yang sebenarnya.
        $incomingBookings = Booking::with('kamar') // Memuat relasi kamar
            ->where('check_in_date', '>=', $today)
            ->where('check_in_date', '<=', $threeDaysLater)
            ->whereIn('status', ['Confirmed', 'Paid', 'Checkin Pending']) // Contoh status yang perlu disiapkan
            ->orderBy('check_in_date', 'asc')
            ->get();

        // Mengirim data ke tampilan Blade
        return view('incoming_bookings', compact('incomingBookings'));
    }

    /**
     * Simulasi atau Implementasi nyata untuk memperbarui status persiapan kamar.
     * Dalam implementasi nyata, ini harus menggunakan Request dan validasi.
     */
    public function updatePreparationStatus(Request $request, $bookingId)
    {
        // Logika untuk mencari booking dan update preparation_status
        $booking = Booking::findOrFail($bookingId);

        // Misalnya, jika tombol mengirim status 'Siap'
        $booking->preparation_status = $request->status;
        $booking->save();

        return response()->json(['message' => 'Status persiapan berhasil diperbarui.']);
    }
}