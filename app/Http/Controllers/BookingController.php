<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kamar;
use App\Models\Booking; // Pastikan model Booking dan Kamar memiliki relasi yang benar
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
// IMPORT BARU: Event Real-Time
use App\Events\BookingUpdated; 

class BookingController extends Controller
{
    /**
     * Menampilkan daftar kamar yang tersedia atau form pencarian.
     */
    public function showRooms(Request $request) 
    {
        $checkIn = $request->input('check_in_date');
        $checkOut = $request->input('check_out_date');

        $query = Kamar::query();
        
        if ($checkIn && $checkOut) {
            
            $checkInCarbon = Carbon::parse($checkIn)->toDateString();
            $checkOutCarbon = Carbon::parse($checkOut)->toDateString();
            
            // 1. Cari ID Kamar yang SUDAH Terisi (logic overlap)
            $bookedRoomIds = Booking::where(function ($q) use ($checkInCarbon, $checkOutCarbon) {
                // Logika Overlap: kamar terisi jika check_out pemesanan lama > check_in pemesanan baru 
                // DAN check_in pemesanan lama < check_out pemesanan baru
                $q->where('check_out_date', '>', $checkInCarbon)
                    ->where('check_in_date', '<', $checkOutCarbon);
            })
            // Filter status: hanya pemesanan yang aktif/belum dibatalkan
            ->whereIn('status', ['Confirmed', 'Pending Payment']) 
            ->pluck('kamar_id')
            ->unique()
            ->toArray();

            // 2. Filter Kamar: Hanya tampilkan kamar yang ID-nya TIDAK ada di daftar kamar terisi
            $query->whereNotIn('id', $bookedRoomIds);
        }
        
        $rooms = $query->where('status', 'Available')
                             ->orderBy('id', 'asc')
                             ->get();

        return view('rooms', compact('rooms'));
    }

    /**
     * Menampilkan form final untuk pemesanan (setelah kamar dipilih).
     * Mempersiapkan data ringkasan perjalanan.
     */
    public function createBooking(Kamar $kamar, Request $request)
    {
        $checkInDate = $request->query('check_in');
        $checkOutDate = $request->query('check_out');
        
        $totalNights = 0;
        $totalPrice = 0;
        if ($checkInDate && $checkOutDate) {
               $checkInCarbon = Carbon::parse($checkInDate);
               $checkOutCarbon = Carbon::parse($checkOutDate);
               
               // Pastikan totalNights tidak negatif meskipun user memilih tanggal terbalik
               $totalNights = abs($checkOutCarbon->diffInDays($checkInCarbon)); 
               
               // Hitung total harga
               $totalPrice = $totalNights * $kamar->harga_per_malam;
        }

        // Mengirim data kamar, tanggal, total malam, dan total harga ke view
        return view('booking.create_booking', compact('kamar', 'checkInDate', 'checkOutDate', 'totalNights', 'totalPrice'));
    }

    /**
     * Menyimpan pemesanan baru ke database (logika ini AKAN menggunakan Firestore).
     */
    public function storeBooking(Request $request)
    {
        // PENTING: Metode ini HARUS dilindungi oleh middleware('auth') di route-nya!
        
        // 1. Validasi Data Input (Ditambahkan 'email' dan 'phone_number')
        $request->validate([
            'kamar_id' => 'required|exists:kamars,id',
            'guest_name' => 'required|string|max:255', 
            'email' => 'required|email|max:255', // BARU
            'phone_number' => 'required|string|max:20', // BARU
            'check_in_date' => 'required|date|after_or_equal:today',
            'check_out_date' => 'required|date|after:check_in_date',
        ]);

        $checkIn = Carbon::parse($request->check_in_date);
        $checkOut = Carbon::parse($request->check_out_date);
        $kamar = Kamar::findOrFail($request->kamar_id);
        
        // Hitung ulang totalNights dan totalPrice
        $totalNights = $checkOut->diffInDays($checkIn);
        $totalPrice = $totalNights * $kamar->harga_per_malam;
        
        // Tentukan jumlah yang harus dibayar sekarang (DP atau Full)
        $paymentRequired = $totalPrice; // Default: Bayar Penuh
        $paymentType = 'Bayar Penuh';
        
        // Logika DP: WAJIB DP 50% jika pemesanan lebih dari 2 malam
        if ($totalNights > 2) {
            $paymentRequired = $totalPrice * 0.50; // DP 50%
            $paymentType = 'Deposit (50%)';
        }

        // 2. Pengecekan Ketersediaan Ulang (Race Condition Check)
        $isStillAvailable = Booking::where('kamar_id', $request->kamar_id)
            ->where(function ($q) use ($checkIn, $checkOut) {
                $q->where('check_out_date', '>', $checkIn)
                    ->where('check_in_date', '<', $checkOut);
            })
            ->whereIn('status', ['Confirmed', 'Pending Payment'])
            ->doesntExist();

        if (!$isStillAvailable) {
            return redirect()->back()->with('error', 'Maaf, kamar ini baru saja dibooking oleh tamu lain. Silakan pilih kamar atau tanggal lain.')->withInput();
        }

        // 3. Buat Record Booking BARU
        // Menggunakan Eloquent sementara agar alur redirect berjalan:
        $booking = Booking::create([
            // PERBAIKAN KRITIS DI SINI:
            'user_id' => Auth::id(), // WAJIB menggunakan ID pengguna yang sedang login.
            
            'kamar_id' => $request->kamar_id,
            'guest_name' => $request->guest_name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'check_in_date' => $checkIn,
            'check_out_date' => $checkOut,
            'total_price' => $totalPrice, 
            'status' => 'Pending Payment', 
            'preparation_status' => 'Pending',
        ]);
        $bookingId = $booking->id;
        
        // PENTING: Pemicu Event Real-Time setelah booking berhasil dibuat/diperbarui!
        BookingUpdated::dispatch($booking);


        // 4. Redirect ke Halaman Instruksi Pembayaran (Dashboard Tamu)
        return redirect()->route('booking.payment_info', [
            'bookingId' => $bookingId // Pastikan ID ini ada
        ])->with([
            'success' => 'Pemesanan berhasil disimpan! Silakan selesaikan pembayaran.',
            'paymentRequired' => $paymentRequired,
            'paymentType' => $paymentType,
            'totalPrice' => $totalPrice,
            'totalNights' => $totalNights
        ]);
    }

    /**
     * Tampilkan halaman instruksi pembayaran dan detail booking.
     * Halaman ini berfungsi sebagai Dashboard Tamu untuk booking yang baru dibuat.
     */
    public function showPaymentInfo($bookingId)
    {
        // PERHATIAN: Di sini juga harus ada logic GET DOC FIRESTORE
        $booking = Booking::with('kamar')->findOrFail($bookingId);
        
        // Pengecekan kepemilikan data (Best Practice Security)
        if ($booking->user_id !== Auth::id()) {
            return redirect()->route('home')->with('error', 'Akses ditolak. Detail pemesanan ini bukan milik Anda.');
        }
        
        $checkInCarbon = Carbon::parse($booking->check_in_date);
        $checkOutCarbon = Carbon::parse($booking->check_out_date);
        $totalNights = $checkOutCarbon->diffInDays($checkInCarbon);

        // Hitung ulang pembayaran yang dibutuhkan
        $amountDue = $booking->total_price;
        $paymentType = 'Bayar Penuh';
        
        if ($totalNights > 2) {
            $amountDue = $booking->total_price * 0.50;
            $paymentType = 'Deposit (50%)';
        }

        // Tampilkan halaman dengan detail instruksi pembayaran
        return view('booking.payment_info', [
            'booking' => $booking,
            'dpAmount' => $amountDue, 
            'paymentType' => $paymentType,
            'totalNights' => $totalNights
        ]);
    }
    
    /**
     * Menampilkan Riwayat Pemesanan pengguna yang sedang login.
     *
     * @return \Illuminate\View\View
     */
    public function showHistory()
    {
        // 1. Pastikan user sudah login
        if (!Auth::check()) {
            // Redirect ke login jika belum login
            return redirect()->route('login')->with('error', 'Anda perlu login untuk melihat riwayat pemesanan.');
        }

        // 2. Ambil semua pemesanan milik user yang sedang login.
        // PENTING: Gunakan with('kamar') untuk memuat data kamar terkait (eager loading)
        // Ini memastikan kita bisa mengakses nama/tipe kamar di view.
        $histories = Booking::where('user_id', Auth::id())
                            ->with('kamar') // Asumsi relasi di model Booking bernama 'kamar'
                            ->orderBy('created_at', 'desc')
                            ->get();

        // 3. Kirim data ke view
        return view('views.history', compact('histories'));
    }
}