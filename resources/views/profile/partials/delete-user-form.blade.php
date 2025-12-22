<section>
    <header style="border-left: 5px solid #dc3545; padding-left: 15px; margin-bottom: 30px;">
        <h2 style="font-size: 1.8em; color: #dc3545; margin: 0;">
            <i class="fas fa-trash-alt" style="margin-right: 5px;"></i> Hapus Akun
        </h2>

        <p style="margin-top: 5px; font-size: 0.9em; color: #6c757d;">
            Setelah akun Anda dihapus, semua sumber daya dan data akan dihapus secara permanen. Harap unduh data apa pun yang ingin Anda simpan.
        </p>
    </header>

    {{-- Tombol untuk memicu modal/dialog konfirmasi --}}
    <button type="button" 
            style="padding: 12px 25px; background-color: #dc3545; color: white; border: none; border-radius: 5px; font-weight: bold; cursor: pointer; margin-top: 20px; font-size: 1.1em; transition: background-color 0.3s;"
            onmouseover="this.style.backgroundColor='#c82333'" 
            onmouseout="this.style.backgroundColor='#dc3545'"
            onclick="document.getElementById('confirm-user-deletion').style.display='block'">
        <i class="fas fa-exclamation-triangle" style="margin-right: 8px;"></i> HAPUS AKUN SECARA PERMANEN
    </button>
    
    {{-- MODAL/DIALOG KONFIRMASI (Simulasi sederhana dengan style inline) --}}
    <div id="confirm-user-deletion" style="display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.6);">
        <div style="background-color: white; margin: 10% auto; padding: 30px; border: 1px solid #dc3545; width: 90%; max-width: 450px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.5);">
            <h3 style="font-size: 1.5em; color: #dc3545; margin-bottom: 15px;">
                <i class="fas fa-skull-crossbones" style="margin-right: 8px;"></i> Konfirmasi Hapus Akun
            </h3>
            <p style="margin-bottom: 25px; color: #333;">
                Anda YAKIN? Masukkan kata sandi Anda di bawah ini untuk mengonfirmasi bahwa Anda ingin menghapus akun Anda secara permanen.
            </p>

            <form method="post" action="{{ route('profile.destroy') }}" style="margin-top: 15px;">
                @csrf
                @method('delete')
                
                <div style="margin-bottom: 20px;">
                    <label for="password_delete" style="display: block; color: var(--color-primary); font-weight: bold; margin-bottom: 8px;">Kata Sandi</label>
                    <input id="password_delete" name="password" type="password" placeholder="Masukkan Kata Sandi Anda"
                           style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box; font-size: 1em;">
                    @error('password', 'userDeletion')
                        <p style="color: #dc3545; font-size: 0.9em; margin-top: 5px;">{{ $message }}</p>
                    @enderror
                </div>
                
                <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px;">
                    <button type="button" 
                            onclick="document.getElementById('confirm-user-deletion').style.display='none'"
                            style="padding: 10px 18px; background-color: #6c757d; color: white; border: none; border-radius: 5px; cursor: pointer; font-weight: bold; transition: background-color 0.3s;">
                        Batal
                    </button>
                    <button type="submit" 
                            style="padding: 10px 18px; background-color: #dc3545; color: white; border: none; border-radius: 5px; cursor: pointer; font-weight: bold; transition: background-color 0.3s;">
                        Ya, Hapus Akun
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>