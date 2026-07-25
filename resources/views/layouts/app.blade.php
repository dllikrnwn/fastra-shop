<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth" x-data="{ theme: localStorage.getItem('theme') || (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light') }" x-init="$watch('theme', val => { localStorage.setItem('theme', val); document.documentElement.classList.toggle('dark', val === 'dark'); }); $nextTick(() => document.documentElement.classList.toggle('dark', theme === 'dark'))">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="{{ $description ?? 'Fastra Shop — Topup Game Cepat, Aman, dan Terpercaya' }}">

        <meta property="og:title" content="{{ $title ?? 'Fastra Shop' }}">
        <meta property="og:description" content="{{ $description ?? 'Topup game favoritmu dengan cepat dan aman.' }}">
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta name="twitter:card" content="summary_large_image">

        <title>{{ $title ?? config('app.name', 'Fastra Shop') }}</title>

        <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,400&family=JetBrains+Mono:wght@400;500;600;700&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>[x-cloak]{display:none!important}</style>
        @yield('head')
    </head>
    <body class="min-h-screen">
        <div class="min-h-screen flex flex-col">

            {{-- NAVBAR --}}
            <header class="sticky top-0 z-50 border-b-[3px]" style="border-color: var(--border); background: var(--bg-primary);">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between h-16 md:h-18">
                        <a href="{{ route('home') }}" class="shrink-0 transition-transform hover:scale-105">
                            <x-application-logo class="h-8 md:h-9" />
                        </a>

                        <nav class="hidden md:flex items-center gap-1">
                            <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'nav-link-active' : '' }}">Beranda</a>
                            <a href="{{ route('games.index') }}" class="nav-link {{ request()->routeIs('games.*') ? 'nav-link-active' : '' }}">Semua Game</a>
                            <a href="{{ route('transactions.track') }}" class="nav-link {{ request()->routeIs('transactions.track') || request()->routeIs('transactions.lookup') ? 'nav-link-active' : '' }}">Lacak</a>
                        </nav>

                        <div class="flex items-center gap-2">
                            {{-- Theme Toggle --}}
                            <button @click="theme = theme === 'dark' ? 'light' : 'dark'" class="nb-btn-ghost p-2" aria-label="Toggle tema">
                                <svg x-show="theme === 'dark'" x-cloak class="w-5 h-5 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                <svg x-show="theme === 'light'" x-cloak class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                                </svg>
                            </button>

                            @auth
                                @if(Auth::user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}" class="nb-btn-secondary text-xs px-3 py-1.5 hidden sm:inline-flex">Admin</a>
                                @endif
                                <x-dropdown align="right" width="48">
                                    <x-slot name="trigger">
                                        <button class="nb-card-static flex items-center gap-2 px-3 py-2 text-sm font-display font-bold transition-transform hover:scale-105" style="box-shadow: 2px 2px 0 var(--border);">
                                            <div class="w-7 h-7 rounded-lg flex items-center justify-center" style="background: var(--accent); color: #000;"><span class="font-display font-bold text-xs">{{ substr(Auth::user()->name, 0, 1) }}</span></div>
                                            <span class="hidden sm:inline">{{ Auth::user()->name }}</span>
                                        </button>
                                    </x-slot>
                                    <x-slot name="content">
                                        <x-dropdown-link :href="route('profile.edit')">Profile</x-dropdown-link>
                                        <x-dropdown-link :href="route('transactions.index')">Transaksi</x-dropdown-link>
                                        <div class="border-t-2 border-black dark:border-white my-1"></div>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">Keluar</x-dropdown-link>
                                        </form>
                                    </x-slot>
                                </x-dropdown>
                            @else
                                <a href="{{ route('login') }}" class="nb-btn-ghost hidden sm:inline-flex">Masuk</a>
                                <a href="{{ route('register') }}" class="nb-btn-primary text-xs px-5 py-2">Daftar</a>
                            @endauth

                            <button @click="$dispatch('toggle-mobile-menu')" class="md:hidden nb-btn-ghost p-2">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" /></svg>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Mobile Menu --}}
                <div x-data="{ open: false }" @toggle-mobile-menu.window="open = !open" class="md:hidden">
                    <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-40 bg-black/50" @click="open = false"></div>
                    <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full" class="fixed top-0 right-0 z-50 h-full w-72" style="background: var(--bg-primary); border-left: 3px solid var(--border);">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-8">
                                <x-application-logo class="h-7" />
                                <button @click="open = false" class="nb-btn-ghost p-1.5"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg></button>
                            </div>
                            <div class="space-y-1">
                                <a href="{{ route('home') }}" class="block px-4 py-3 rounded-lg text-sm font-display font-bold" style="color: var(--text-primary)">Beranda</a>
                                <a href="{{ route('games.index') }}" class="block px-4 py-3 rounded-lg text-sm font-display font-bold" style="color: var(--text-secondary)">Semua Game</a>
                                <a href="{{ route('transactions.track') }}" class="block px-4 py-3 rounded-lg text-sm font-display font-bold" style="color: var(--text-secondary)">Lacak Transaksi</a>
                                @auth
                                    @if(Auth::user()->isAdmin())
                                        <a href="{{ route('admin.dashboard') }}" class="block px-4 py-3 rounded-lg text-sm font-display font-bold" style="color: var(--text-secondary)">Admin Panel</a>
                                    @endif
                                    <div class="border-t-2" style="border-color: var(--border); margin: 8px 0;"></div>
                                    <a href="{{ route('profile.edit') }}" class="block px-4 py-3 rounded-lg text-sm font-display font-bold" style="color: var(--text-secondary)">Profile</a>
                                    <a href="{{ route('transactions.index') }}" class="block px-4 py-3 rounded-lg text-sm font-display font-bold" style="color: var(--text-secondary)">Transaksi</a>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full text-left px-4 py-3 rounded-lg text-sm font-display font-bold" style="color: #FF4444;">Keluar</button>
                                    </form>
                                @else
                                    <div class="border-t-2" style="border-color: var(--border); margin: 8px 0;"></div>
                                    <a href="{{ route('login') }}" class="block px-4 py-3 rounded-lg text-sm font-display font-bold" style="color: var(--text-secondary)">Masuk</a>
                                    <a href="{{ route('register') }}" class="block px-4 py-3 mt-2 text-center rounded-lg text-sm font-display font-bold" style="background: var(--accent); color: #000; border: 3px solid var(--border);">Daftar</a>
                                @endauth
                        </div>
                    </div>
                </div>
            </header>

            {{-- PAGE CONTENT --}}
            <main class="flex-1 page-enter">
                @yield('slot')
            </main>

            {{-- FOOTER --}}
            <footer class="border-t-[3px]" style="border-color: var(--border); background: var(--bg-primary);">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-16">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div class="md:col-span-2">
                            <x-application-logo class="h-8 mb-4" />
                            <p class="text-sm max-w-sm leading-relaxed" style="color: var(--text-secondary);">Platform topup game terpercaya. Transaksi cepat, aman, dan harga terjangkau.</p>
                            <div class="flex items-center gap-3 mt-5">
                                <a href="https://www.instagram.com/fastra.code?igsh=MWFrYWVnOWtjemIxcQ==" target="_blank" rel="noopener" class="nb-card-static w-10 h-10 flex items-center justify-center text-sm font-bold" style="box-shadow: 2px 2px 0 var(--border);">IG</a>
                                <a href="https://wa.me/628815381632" target="_blank" rel="noopener" class="nb-card-static w-10 h-10 flex items-center justify-center text-sm font-bold" style="box-shadow: 2px 2px 0 var(--border);">WA</a>
                            </div>
                        </div>
                        <div>
                            <h4 class="font-display font-bold mb-4" style="color: var(--text-primary);">Links</h4>
                            <ul class="space-y-2">
                                <li><a href="{{ route('games.index') }}" style="color: var(--text-secondary);" class="text-sm hover:underline">Semua Game</a></li>
                                <li><a href="{{ route('transactions.track') }}" style="color: var(--text-secondary);" class="text-sm hover:underline">Lacak Transaksi</a></li>
                                <li><a href="{{ route('login') }}" style="color: var(--text-secondary);" class="text-sm hover:underline">Masuk</a></li>
                                <li><a href="{{ route('register') }}" style="color: var(--text-secondary);" class="text-sm hover:underline">Daftar</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="border-t-2 pt-6 mt-10 flex flex-col sm:flex-row items-center justify-between gap-4" style="border-color: var(--border);">
                        <p class="text-xs" style="color: var(--text-secondary);">&copy; {{ date('Y') }} Fastra Shop.</p>
                        <div class="flex items-center gap-1 text-xs" style="color: var(--text-secondary);">
                            🔒 Transaksi Aman & Terenkripsi
                        </div>
                    </div>
                </div>
            </footer>
        </div>

        {{-- Scroll to Top --}}
        <button x-data="{ visible: false }" @scroll.window="visible = window.scrollY > 400" x-show="visible" x-cloak @click="window.scrollTo({top:0,behavior:'smooth'})" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" class="scroll-top-btn" aria-label="Scroll to top">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5" /></svg>
        </button>

        {{-- Toasts --}}
        @if (session('success'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3500)" x-show="show" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-4" class="nb-card-static fixed bottom-6 right-6 z-50 max-w-sm p-5" style="border-color: var(--accent); box-shadow: 3px 3px 0 var(--accent-shadow);">
                <div class="flex items-center gap-3">
                    <span class="font-bold text-lg">🎉</span>
                    <p class="text-sm font-bold">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3500)" x-show="show" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-4" class="nb-card-static fixed bottom-6 right-6 z-50 max-w-sm p-5" style="border-color: #FF4444; box-shadow: 3px 3px 0 #FF4444;">
                <div class="flex items-center gap-3">
                    <span class="font-bold text-lg">⚠️</span>
                    <p class="text-sm font-bold">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        @yield('scripts')
    </body>
</html>
