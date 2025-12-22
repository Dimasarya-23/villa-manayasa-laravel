<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KamarController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\BookingController; 
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes (Landing Page - Accessible by Everyone)
|--------------------------------------------------------------------------
*/

// Landing Page
Route::get('/', function () {
    return view('welcome');
})->name('home');

// About Page
Route::get('/about', function () {
    return view('about');
})->name('about');

// Contact Page
Route::get('/contact', function () {
    return view('contact');
})->name('contact');

// =========================================================================
// RUTE KAMAR (DIPINDAH KE PUBLIK AGAR POSTMAN BERHASIL)
// =========================================================================
Route::resource('kamar', KamarController::class);
// =========================================================================


/*
|--------------------------------------------------------------------------
| Authenticated Routes (Harus Login - Akses Tamu & Admin)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware('verified')->name('dashboard');
        
    // Rute Riwayat Pemesanan Tamu
    Route::get('/history', [HistoryController::class, 'index'])->name('history'); 

    // Profile Management Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update'); 
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('password.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // =========================================================================
    // RUTE PEMESANAN BARU - Akses oleh Guest/User (TAMU)
    // =========================================================================
    // 1. Menampilkan semua kamar yang tersedia
    Route::get('/rooms', [BookingController::class, 'showRooms'])->name('rooms.index');

    // 2. Menampilkan form booking setelah kamar dipilih
    Route::get('/booking/{kamar}', [BookingController::class, 'createBooking'])
        ->name('booking.create')
        ->where('kamar', '[0-9]+'); 

    // 3. Menyimpan data booking ke database
    Route::post('/booking/store', [BookingController::class, 'storeBooking'])->name('booking.store');
    
    // 4. Menampilkan instruksi pembayaran
    Route::get('/booking/payment/{bookingId}', [BookingController::class, 'showPaymentInfo'])
        ->name('booking.payment_info')
        ->where('bookingId', '[0-9]+'); 
    // =========================================================================
    
    // =========================================================================
    // RUTE TUGAS CEPAT - Akses oleh Staff dan Admin
    // =========================================================================
    Route::get('/tasks/incoming-bookings', [TaskController::class, 'incomingBookings'])
        ->name('tasks.incoming');
        
    Route::post('/api/bookings/{booking}/status', [TaskController::class, 'updatePreparationStatus'])
        ->name('bookings.update-status');
    // =========================================================================

});


/*
|--------------------------------------------------------------------------
| Admin Routes (Hanya bisa diakses oleh user dengan role 'admin')
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'isAdmin'])->group(function () {
    
    // Rute Kamar asli di sini saya matikan karena sudah ada di atas (Public)
    // Route::resource('kamar', KamarController::class);
    
    // =========================================================================
    // MANAJEMEN USER (CRUD) - ADMIN ONLY
    // =========================================================================
    Route::resource('management/users', UserController::class)
        ->names('user')
        ->except(['create', 'store', 'show']);
});

// require auth harus selalu di bawah rute utama
require __DIR__.'/auth.php';