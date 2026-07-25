<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth" x-data="{ theme: localStorage.getItem('theme') || (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light') }" x-init="$watch('theme', val => { localStorage.setItem('theme', val); document.documentElement.classList.toggle('dark', val === 'dark'); }); $nextTick(() => document.documentElement.classList.toggle('dark', theme === 'dark'))">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Admin — Fastra Shop' }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,600;9..40,700&family=JetBrains+Mono:wght@400;500;600&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>[x-cloak]{display:none!important}</style>
    @yield('head')
</head>
<body class="min-h-screen" style="background: var(--bg-primary);">

<div class="flex min-h-screen" x-data="{ sidebarOpen: false }">
    {{-- Mobile overlay --}}
    <div x-show="sidebarOpen" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-40 bg-black/50 md:hidden" @click="sidebarOpen = false"></div>

    {{-- SIDEBAR --}}
    <aside x-init="$nextTick(() => { if (window.innerWidth >= 768) sidebarOpen = true })" x-show="sidebarOpen" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full" class="fixed inset-y-0 left-0 z-50 w-64 md:static md:w-64 md:translate-x-0 md:overflow-y-auto flex flex-col" style="background: var(--bg-secondary); border-right: 3px solid var(--border);">

        <div class="p-6 border-b-[3px] flex items-center justify-between" style="border-color: var(--border);">
            <x-application-logo class="h-8" />
            <button @click="sidebarOpen = false" class="md:hidden nb-btn-ghost p-1">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>

        <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
            @php
                $current = request()->route()->getName();
                $menus = [
                    ['route' => 'admin.dashboard', 'label' => 'Dashboard', 'icon' => '<path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" stroke-linecap="round"/><path d="M9 22V12h6v10" stroke-linecap="round"/>'],
                    ['route' => 'admin.games.index', 'label' => 'Games', 'icon' => '<path d="M11 17l-5-5 5-5" stroke-linecap="round"/><path d="M18 17l-5-5 5-5" stroke-linecap="round"/>'],
                    ['route' => 'admin.categories.index', 'label' => 'Kategori', 'icon' => '<path d="M4 4h7l2 2h7a2 2 0 012 2v9a2 2 0 01-2 2H4a2 2 0 01-2-2V6a2 2 0 012-2z" stroke-linecap="round"/>'],
                    ['route' => 'admin.denominations.index', 'label' => 'Harga', 'icon' => '<path d="M12 1v22" stroke-linecap="round"/><path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6" stroke-linecap="round"/>'],
                    ['route' => 'admin.transactions.index', 'label' => 'Transaksi', 'icon' => '<path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2" stroke-linecap="round"/><rect x="9" y="3" width="6" height="4" rx="1" stroke-linecap="round"/><path d="M9 12h6" stroke-linecap="round"/><path d="M9 16h6" stroke-linecap="round"/>'],
                    ['route' => 'admin.users.index', 'label' => 'User', 'icon' => '<path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" stroke-linecap="round"/><circle cx="9" cy="7" r="4" stroke-linecap="round"/>'],
                    ['route' => 'admin.banners.index', 'label' => 'Banner', 'icon' => '<rect x="3" y="5" width="18" height="14" rx="2" stroke-linecap="round"/><circle cx="8.5" cy="9.5" r="1.5" fill="currentColor"/><path d="M21 15l-5-5L5 21" stroke-linecap="round"/>'],
                    ['route' => 'admin.payment-settings', 'label' => 'Pengaturan', 'icon' => '<path d="M12 15a3 3 0 100-6 3 3 0 000 6z" stroke-linecap="round"/><path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 01-2.83 2.83l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-4 0v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83-2.83l.06-.06A1.65 1.65 0 004.68 15a1.65 1.65 0 00-1.51-1H3a2 2 0 010-4h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 012.83-2.83l.06.06A1.65 1.65 0 009 4.68a1.65 1.65 0 001-1.51V3a2 2 0 014 0v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 2.83l-.06.06A1.65 1.65 0 0019.4 9a1.65 1.65 0 001.51 1H21a2 2 0 010 4h-.09a1.65 1.65 0 00-1.51 1z" stroke-linecap="round"/>'],
                ];
            @endphp
            @foreach($menus as $m)
            @php $active = str_starts_with($current, explode('*', $m['route'])[0] ?: $m['route']); @endphp
            <a href="{{ route($m['route']) }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all sidebar-link {{ $active ? 'active' : '' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">{!! $m['icon'] !!}</svg>
                <span class="font-display font-bold text-sm">{{ $m['label'] }}</span>
            </a>
            @endforeach
        </nav>

        <div class="p-4 border-t-[3px]" style="border-color: var(--border);">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 font-display font-bold text-sm" style="background: var(--accent);color:#000;border:2px solid var(--border);">{{ substr(Auth::user()->name, 0, 1) }}</div>
                <div class="min-w-0">
                    <p class="font-display font-bold text-sm truncate" style="color: var(--text-primary);">{{ Auth::user()->name }}</p>
                    <p class="text-xs" style="color: var(--text-secondary);">Admin</p>
                </div>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('home') }}" class="nb-btn-ghost flex-1 text-center text-xs">Web</a>
                <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit" class="nb-btn-danger flex-1 text-center text-xs">Exit</button></form>
            </div>
        </div>
    </aside>

    {{-- MAIN --}}
    <div class="flex-1 flex flex-col min-w-0">
        <header class="sticky top-0 z-40 border-b-[3px] md:hidden" style="border-color: var(--border); background: var(--bg-primary);">
            <div class="px-4 h-14 flex items-center justify-between">
                <button @click="sidebarOpen = true" class="nb-btn-ghost p-2"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" /></svg></button>
                <x-application-logo class="h-7" />
                <button @click="theme = theme === 'dark' ? 'light' : 'dark'" class="nb-btn-ghost p-2">
                    <svg x-show="theme === 'dark'" x-cloak class="w-5 h-5 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                    <svg x-show="theme === 'light'" x-cloak class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" /></svg>
                </button>
            </div>
        </header>
        <main class="flex-1 p-4 md:p-8 page-enter">
            @yield('slot')
        </main>
    </div>
</div>

<button x-data="{ visible: false }" @scroll.window="visible = window.scrollY > 400" x-show="visible" x-cloak @click="window.scrollTo({top:0,behavior:'smooth'})" x-transition:enter="transition ease-out duration-200" class="scroll-top-btn md:left-64">
    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5" /></svg>
</button>

@if (session('success'))
<div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3500)" x-show="show" x-cloak x-transition:enter="transition ease-out duration-200" class="nb-card-static fixed bottom-6 right-6 z-50 max-w-sm p-4" style="border-color: var(--accent); box-shadow: 3px 3px 0 var(--accent-shadow);">
    <div class="flex items-center gap-3">
        <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0" style="background: var(--neo-green);"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg></div>
        <p class="text-sm font-bold" style="color: var(--text-primary);">{{ session('success') }}</p>
    </div>
</div>
@endif

@yield('scripts')
</body>
</html>
