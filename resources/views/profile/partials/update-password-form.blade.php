<section>
    <header style="border-left: 5px solid var(--color-primary); padding-left: 15px; margin-bottom: 30px;">
        <h2 style="font-size: 1.8em; color: var(--color-primary); margin: 0;">
            <i class="fas fa-lock" style="margin-right: 5px;"></i> Perbarui Kata Sandi
        </h2>

        <p style="margin-top: 5px; font-size: 0.9em; color: #6c757d;">
            Pastikan akun Anda menggunakan kata sandi yang panjang dan acak agar tetap aman.
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" style="margin-top: 25px;">
        @csrf
        @method('put')

        {{-- Input Current Password --}}
        <div style="margin-bottom: 20px;">
            <label for="current_password" style="display: block; color: var(--color-dark-gray); font-weight: bold; margin-bottom: 8px;">
                <i class="fas fa-key" style="color: var(--color-accent); margin-right: 5px;"></i> Kata Sandi Saat Ini
            </label>
            <input id="current_password" name="current_password" type="password" autocomplete="current-password"
                   style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box; font-size: 1em;">
            @error('current_password', 'updatePassword')
                <p style="color: #dc3545; font-size: 0.9em; margin-top: 5px;">{{ $message }}</p>
            @enderror
        </div>

        {{-- Input New Password --}}
        <div style="margin-bottom: 20px;">
            <label for="password" style="display: block; color: var(--color-dark-gray); font-weight: bold; margin-bottom: 8px;">
                <i class="fas fa-unlock-alt" style="color: var(--color-accent); margin-right: 5px;"></i> Kata Sandi Baru
            </label>
            <input id="password" name="password" type="password" autocomplete="new-password"
                   style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box; font-size: 1em;">
            @error('password', 'updatePassword')
                <p style="color: #dc3545; font-size: 0.9em; margin-top: 5px;">{{ $message }}</p>
            @enderror
        </div>

        {{-- Input Confirm Password --}}
        <div style="margin-bottom: 20px;">
            <label for="password_confirmation" style="display: block; color: var(--color-dark-gray); font-weight: bold; margin-bottom: 8px;">
                <i class="fas fa-check" style="color: var(--color-accent); margin-right: 5px;"></i> Konfirmasi Kata Sandi
            </label>
            <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password"
                   style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box; font-size: 1em;">
            @error('password_confirmation', 'updatePassword')
                <p style="color: #dc3545; font-size: 0.9em; margin-top: 5px;">{{ $message }}</p>
            @enderror
        </div>

        {{-- Tombol Simpan --}}
        <div style="display: flex; align-items: center; gap: 15px; margin-top: 30px;">
            <button type="submit" 
                    style="padding: 12px 25px; background-color: var(--color-primary); color: white; border: none; border-radius: 5px; font-weight: bold; cursor: pointer; font-size: 1.1em; transition: background-color 0.3s;"
                    onmouseover="this.style.backgroundColor='var(--color-accent)'" 
                    onmouseout="this.style.backgroundColor='var(--color-primary)'">
                <i class="fas fa-save" style="margin-right: 8px;"></i> SIMPAN
            </button>

            @if (session('status') === 'password-updated')
                <p style="font-size: 0.9em; color: #28a745; font-weight: bold;">
                    <i class="fas fa-check-circle" style="margin-right: 5px;"></i> Berhasil disimpan!
                </p>
            @endif
        </div>
    </form>
</section>