<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash; 
use Illuminate\Validation\ValidationException; 

class ProfileController extends Controller
{
    /**
     * Tampilkan form profil pengguna.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Perbarui informasi profil pengguna (Nama, Email, Foto Profil).
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        // 1. Update Data Dasar (Nama & Email)
        // Perhatikan: $request->validated() diambil dari ProfileUpdateRequest,
        // yang seharusnya hanya mengandung 'name' dan 'email',
        // kecuali Anda menambahkan 'foto_profil' di sana. 
        // Jika 'foto_profil' TIDAK ada di ProfileUpdateRequest, tambahkan validasi manual di sini.
        
        // Asumsi ProfileUpdateRequest hanya memvalidasi name dan email:
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }
        
        // 2. Proses Upload Foto Profil
        // Kita tidak bisa menggunakan $request->validated() untuk file upload
        // jika ProfileUpdateRequest tidak mendukung file, jadi kita cek manual.
        if ($request->hasFile('foto_profil')) {
            $file = $request->file('foto_profil');
            
            // Generate nama file unik
            $filename = 'profile-' . $request->user()->id . '-' . time() . '.' . $file->getClientOriginalExtension();

            // Hapus foto lama jika ada
            if ($request->user()->foto_profil) {
                // Pastikan path foto lama ada di storage sebelum dihapus
                if (Storage::disk('public')->exists($request->user()->foto_profil)) {
                    Storage::disk('public')->delete($request->user()->foto_profil);
                }
            }

            // Simpan file baru ke storage/app/public/profile_photos
            $filePath = $file->storeAs('profile_photos', $filename, 'public');

            // Update kolom foto_profil di database
            $request->user()->foto_profil = $filePath;
        }

        // Simpan perubahan ke database
        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'Profil berhasil diperbarui!');
    }
    
    /**
     * Memproses pembaruan kata sandi.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        // 1. Validasi Input Kata Sandi
        $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'], // 'confirmed' membandingkan dengan 'password_confirmation'
        ]);
        
        $user = Auth::user();

        // 2. Verifikasi Kata Sandi Lama
        if (!Hash::check($request->current_password, $user->password)) {
            // Jika kata sandi lama tidak cocok, lemparkan error validasi
            throw ValidationException::withMessages([
                'current_password' => ['Kata sandi saat ini salah.'],
            ]);
        }

        // 3. Update Kata Sandi
        $user->password = Hash::make($request->password);
        $user->save();

        // 4. Redirect dengan pesan sukses
        return Redirect::route('profile.edit')->with('status', 'password-updated');
    }

    /**
     * Hapus akun pengguna.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        // Hapus foto profil dari storage sebelum akun dihapus
        if ($user->foto_profil) {
            if (Storage::disk('public')->exists($user->foto_profil)) {
                Storage::disk('public')->delete($user->foto_profil);
            }
        }

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}