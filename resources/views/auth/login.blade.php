<x-guest-layout>
    <div class="text-center mb-6">
        <h1 class="font-display font-black text-2xl" style="color: var(--text-primary);">Masuk ke Akun</h1>
        <p class="text-sm mt-1" style="color: var(--text-secondary);">Selamat datang kembali di Fastra Shop</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <div>
            <label for="email" class="block text-sm font-display font-bold mb-1.5" style="color: var(--text-primary);">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" class="nb-input" required autofocus autocomplete="username" placeholder="email@contoh.com">
            @error('email')<p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="password" class="block text-sm font-display font-bold mb-1.5" style="color: var(--text-primary);">Password</label>
            <input id="password" type="password" name="password" class="nb-input" required autocomplete="current-password" placeholder="Masukkan password">
            @error('password')<p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p>@enderror
        </div>

        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center gap-2 cursor-pointer">
                <input id="remember_me" type="checkbox" name="remember" class="w-4 h-4 rounded border-2 border-black dark:border-white accent-[#00E5FF]">
                <span class="text-sm font-medium" style="color: var(--text-secondary);">Ingat saya</span>
            </label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-sm font-bold hover:underline" style="color: var(--accent);">Lupa password?</a>
            @endif
        </div>

        <button type="submit" class="nb-btn-primary w-full py-3 text-base">
            Masuk
        </button>
    </form>
</x-guest-layout>
