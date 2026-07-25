<x-guest-layout>
    <div class="text-center mb-6">
        <h1 class="font-display font-black text-2xl" style="color: var(--text-primary);">Daftar Akun Baru</h1>
        <p class="text-sm mt-1" style="color: var(--text-secondary);">Gabung dan mulai topup game favoritmu</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <div>
            <label for="name" class="block text-sm font-display font-bold mb-1.5" style="color: var(--text-primary);">Nama Lengkap</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" class="nb-input" required autofocus autocomplete="name" placeholder="Nama kamu">
            @error('name')<p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="email" class="block text-sm font-display font-bold mb-1.5" style="color: var(--text-primary);">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" class="nb-input" required autocomplete="username" placeholder="email@contoh.com">
            @error('email')<p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="password" class="block text-sm font-display font-bold mb-1.5" style="color: var(--text-primary);">Password</label>
            <input id="password" type="password" name="password" class="nb-input" required autocomplete="new-password" placeholder="Minimal 8 karakter">
            @error('password')<p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-display font-bold mb-1.5" style="color: var(--text-primary);">Konfirmasi Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" class="nb-input" required autocomplete="new-password" placeholder="Ulangi password">
        </div>

        <button type="submit" class="nb-btn-primary w-full py-3 text-base">
            Daftar Sekarang
        </button>
    </form>
</x-guest-layout>
