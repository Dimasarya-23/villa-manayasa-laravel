<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Menampilkan daftar semua pengguna dengan fitur pencarian dan filter.
     */
    public function index(Request $request)
    {
        // Mendapatkan nilai pencarian dan filter dari request
        $search = $request->input('search');
        $roleFilter = $request->input('role_filter');

        // Membangun query dasar
        $query = User::query();

        // Menerapkan filter pencarian nama atau email
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Menerapkan filter peran (role)
        if ($roleFilter) {
            $query->where('role', $roleFilter);
        }

        // Mengambil data pengguna dengan pagination
        // Mengurutkan berdasarkan tanggal pembuatan terbaru
        $users = $query->orderBy('created_at', 'desc')->paginate(10); 

        // Catatan: Jika Anda ingin menggunakan 'status' seperti di Blade, 
        // Anda harus menambahkan kolom 'status' ke model User Anda.
        // Untuk saat ini, kita akan mengabaikan filter status di Controller.

        // Memanggil View 'user.index' yang seharusnya merujuk ke resources/views/user/index.blade.php
        return view('user.index', compact('users')); 
    }

    /**
     * Menampilkan form untuk mengedit user.
     * Kita hanya akan mengizinkan edit role.
     */
    public function edit(User $user)
    {
        // View edit user
        return view('user.edit', compact('user'));
    }

    /**
     * Menyimpan perubahan pada user.
     */
    public function update(Request $request, User $user)
    {
        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            // Pastikan email unik, kecuali untuk user yang sedang diedit
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            // Role harus salah satu dari yang diizinkan
            'role' => ['required', 'string', Rule::in(['Admin', 'Staff', 'Guest'])], 
        ]);

        // Update data user
        $user->update($validated);

        return redirect()->route('user.index')->with('success', 'Data pengguna ' . $user->name . ' berhasil diperbarui.');
    }

    /**
     * Menghapus user.
     */
    public function destroy(User $user)
    {
        // Cek apakah admin mencoba menghapus dirinya sendiri
        if (Auth::id() === $user->id) {
            return redirect()->route('user.index')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        try {
            $user->delete();
            return redirect()->route('user.index')->with('success', 'Pengguna ' . $user->name . ' berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('user.index')->with('error', 'Gagal menghapus pengguna.');
        }
    }
}