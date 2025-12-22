<x-guest-layout>
    <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; width: 100%; text-align: center;">
        
        <div style="margin-bottom: 2rem; width: 100%;">
            <a href="/" style="display: inline-block;">
                <img src="{{ asset('assets/logo-manayasa.png') }}" 
                     alt="Villa Manayasa Logo" 
                     style="width: 120px; height: auto; margin: 0 auto; display: block;">
            </a>
            <h1 style="margin-top: 1rem; font-size: 1.5rem; font-weight: bold; color: #065f46; letter-spacing: 0.1em; text-transform: uppercase;">
                VILLA MANAYASA
            </h1>
        </div>

        @if (session('status'))
            <div style="margin-bottom: 1rem; color: #059669; font-size: 0.875rem;">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" style="width: 100%; display: flex; flex-direction: column; align-items: center;">
            @csrf

            <div style="width: 100%; max-width: 320px; margin-bottom: 1.5rem;">
                <label for="email" style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #374151;">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus 
                       style="width: 100%; text-align: center; padding: 0.7rem; border: 1px solid #d1d5db; border-radius: 0.5rem; outline: none; box-sizing: border-box;"
                       onfocus="this.style.borderColor='#10b981'" onblur="this.style.borderColor='#d1d5db'">
                @error('email')
                    <p style="color: #dc2626; font-size: 0.75rem; margin-top: 0.5rem;">{{ $message }}</p>
                @enderror
            </div>

            <div style="width: 100%; max-width: 320px; margin-bottom: 1.5rem;">
                <label for="password" style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #374151;">Password</label>
                <input id="password" type="password" name="password" required autocomplete="current-password"
                       style="width: 100%; text-align: center; padding: 0.7rem; border: 1px solid #d1d5db; border-radius: 0.5rem; outline: none; box-sizing: border-box;"
                       onfocus="this.style.borderColor='#10b981'" onblur="this.style.borderColor='#d1d5db'">
                @error('password')
                    <p style="color: #dc2626; font-size: 0.75rem; margin-top: 0.5rem;">{{ $message }}</p>
                @enderror
            </div>

            <div style="margin-bottom: 1.5rem; display: flex; align-items: center; justify-content: center;">
                <label for="remember_me" style="display: inline-flex; align-items: center; cursor: pointer;">
                    <input id="remember_me" type="checkbox" name="remember" style="border-radius: 0.25rem; color: #059669; border-color: #d1d5db; cursor: pointer;">
                    <span style="margin-left: 0.5rem; font-size: 0.875rem; color: #4b5563;">Ingat Saya</span>
                </label>
            </div>

            <div style="width: 100%; max-width: 320px; display: flex; flex-direction: column; align-items: center; gap: 1rem;">
                <button type="submit" 
                        style="width: 100%; background-color: #047857; color: white; font-weight: bold; padding: 0.8rem; border-radius: 0.75rem; border: none; cursor: pointer; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
                    LOG IN
                </button>

                <div style="display: flex; flex-direction: column; align-items: center; gap: 0.5rem;">
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" style="font-size: 0.875rem; font-weight: bold; color: #047857; text-decoration: underline;">
                            Daftar Sekarang
                        </a>
                    @endif

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" style="font-size: 0.75rem; color: #6b7280; text-decoration: underline;">
                            Lupa password?
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>
</x-guest-layout>