<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth" x-data="{ theme: localStorage.getItem('theme') || (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light') }" x-init="$watch('theme', val => { localStorage.setItem('theme', val); document.documentElement.classList.toggle('dark', val === 'dark'); }); $nextTick(() => document.documentElement.classList.toggle('dark', theme === 'dark'))">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ $title ?? config('app.name', 'Fastra Shop') }}</title>
        <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,600;9..40,700&family=JetBrains+Mono:wght@400;500&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>[x-cloak]{display:none!important}</style>
    </head>
    <body class="min-h-screen flex items-center justify-center" style="background: var(--bg-primary);">
        <div class="w-full max-w-md mx-auto px-4 py-8">
            <div class="text-center mb-8">
                <a href="{{ url('/') }}" class="inline-block transition-transform hover:scale-105">
                    <img src="{{ asset('images/logo.png') }}" alt="Fastra Shop" class="h-10 mx-auto">
                </a>
            </div>

            <div class="nb-card-static p-8" style="border-color: var(--border); box-shadow: 6px 6px 0 var(--border);">
                {{ $slot }}
            </div>

            <p class="text-center mt-6 text-sm" style="color: var(--text-secondary);">
                @if(request()->routeIs('login'))
                    Belum punya akun? <a href="{{ route('register') }}" class="font-bold hover:underline" style="color: var(--accent);">Daftar</a>
                @else
                    Sudah punya akun? <a href="{{ route('login') }}" class="font-bold hover:underline" style="color: var(--accent);">Masuk</a>
                @endif
            </p>

            <p class="text-center mt-4 text-xs" style="color: var(--text-secondary);">&copy; {{ date('Y') }} Fastra Shop</p>
        </div>
    </body>
</html>
