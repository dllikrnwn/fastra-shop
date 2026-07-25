@extends('layouts.app')

@section('title', 'Dashboard — Fastra Shop')

@section('slot')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-16">
    {{-- Welcome --}}
    <div class="flex items-center gap-4 mb-10 reveal">
        <div class="w-14 h-14 rounded-full bg-accent/10 flex items-center justify-center shrink-0">
            @if($user->avatar)
                <img src="{{ asset('storage-files/' . $user->avatar) }}" alt="" class="w-full h-full rounded-full object-cover">
            @else
                <span class="text-2xl font-display font-bold text-accent">{{ substr($user->name, 0, 1) }}</span>
            @endif
        </div>
        <div>
            <h1 class="text-2xl md:text-3xl font-display font-bold text-gray-900 dark:text-white">Halo, {{ $user->name }}! 👋</h1>
            <p class="text-gray-500 dark:text-gray-400 text-sm">Selamat datang kembali di Fastra Shop</p>
        </div>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-10 reveal reveal-stagger">
        <div class="nb-card-static rounded-2xl p-5">
            <p class="text-sm text-gray-500 dark:text-gray-400">Total Transaksi</p>
            <p class="font-display text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ $totalTransactions }}</p>
        </div>
        <div class="nb-card-static rounded-2xl p-5">
            <p class="text-sm text-gray-500 dark:text-gray-400">Total Pengeluaran</p>
            <p class="font-display text-2xl font-bold text-accent mt-2">Rp {{ number_format($totalSpent, 0, ',', '.') }}</p>
        </div>
        <div class="nb-card-static rounded-2xl p-5">
            <p class="text-sm text-gray-500 dark:text-gray-400">Member Sejak</p>
            <p class="font-display text-lg font-bold text-gray-900 dark:text-white mt-2">{{ $user->created_at->format('d F Y') }}</p>
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-10 reveal reveal-stagger">
        <a href="{{ route('games.index') }}" class="nb-card-static rounded-2xl p-5 hover:border-accent/20 transition-all group">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-accent/10 flex items-center justify-center">
                    <svg class="w-5 h-5 text-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 16.875h3.375m0 0h3.375m-3.375 0V13.5m0 3.375v3.375M6 10.5h2.25a2.25 2.25 0 002.25-2.25V6a2.25 2.25 0 00-2.25-2.25H6A2.25 2.25 0 003.75 6v2.25A2.25 2.25 0 006 10.5zm0 9.75h2.25A2.25 2.25 0 0010.5 18v-2.25a2.25 2.25 0 00-2.25-2.25H6a2.25 2.25 0 00-2.25 2.25V18A2.25 2.25 0 006 20.25zm9.75-9.75H18a2.25 2.25 0 002.25-2.25V6A2.25 2.25 0 0018 3.75h-2.25A2.25 2.25 0 0013.5 6v2.25a2.25 2.25 0 002.25 2.25z" /></svg>
                </div>
                <div>
                    <p class="font-display font-semibold text-gray-900 dark:text-white group-hover:text-accent transition-colors">Topup Game</p>
                    <p class="text-xs text-gray-500">Mulai topup sekarang</p>
                </div>
            </div>
        </a>
        <a href="{{ route('transactions.index') }}" class="nb-card-static rounded-2xl p-5 hover:border-accent/20 transition-all group">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-amber-500/10 flex items-center justify-center">
                    <svg class="w-5 h-5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>
                </div>
                <div>
                    <p class="font-display font-semibold text-gray-900 dark:text-white group-hover:text-accent transition-colors">Riwayat Transaksi</p>
                    <p class="text-xs text-gray-500">Lihat semua transaksi</p>
                </div>
            </div>
        </a>
        <a href="{{ route('profile.edit') }}" class="nb-card-static rounded-2xl p-5 hover:border-accent/20 transition-all group">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-emerald-500/10 flex items-center justify-center">
                    <svg class="w-5 h-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" /></svg>
                </div>
                <div>
                    <p class="font-display font-semibold text-gray-900 dark:text-white group-hover:text-accent transition-colors">Edit Profile</p>
                    <p class="text-xs text-gray-500">Update data diri & avatar</p>
                </div>
            </div>
        </a>
    </div>

    {{-- Featured Games --}}
    <div class="mb-10 reveal">
        <div class="flex items-center justify-between mb-5">
            <h2 class="font-display font-bold text-xl text-gray-900 dark:text-white">Topup Populer</h2>
            <a href="{{ route('games.index') }}" class="nb-btn-ghost text-sm">Lihat Semua</a>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
            @foreach($featuredGames as $game)
            <a href="{{ route('games.show', $game->slug) }}" class="nb-card-static hover:border-accent/20 transition-all group">
                <div class="nb-card-static p-3">
                    <div class="aspect-square bg-gradient-to-br from-accent/5 to-gray-100 dark:to-surface-dark-elevated flex items-center justify-center rounded-lg overflow-hidden">
                        @if($game->image) <img loading="lazy" src="{{ asset('storage-files/' . $game->image) }}" alt="" class="w-full h-full object-contain transition-transform group-hover:scale-110">
                        @else <span class="text-2xl font-display font-bold text-gray-300">{{ substr($game->name, 0, 2) }}</span>
                        @endif
                    </div>
                    <p class="mt-2 font-display font-semibold text-xs text-gray-900 dark:text-white group-hover:text-accent transition-colors truncate">{{ $game->name }}</p>
                </div>
            </a>
            @endforeach
        </div>
    </div>

    {{-- Recent Transactions --}}
    <div class="reveal">
        <div class="flex items-center justify-between mb-5">
            <h2 class="font-display font-bold text-xl text-gray-900 dark:text-white">Transaksi Terbaru</h2>
            <a href="{{ route('transactions.index') }}" class="nb-btn-ghost text-sm">Lihat Semua</a>
        </div>

        <div class="space-y-3">
            @forelse($recentTransactions as $tx)
            <a href="{{ route('transactions.show', $tx->invoice) }}" class="nb-card-static rounded-xl px-4 py-3 flex items-center gap-3 hover:border-accent/20 transition-all group">
                <div class="w-10 h-10 rounded-lg bg-accent/5 flex items-center justify-center shrink-0 overflow-hidden">
                    @if($tx->game->image) <img src="{{ asset('storage-files/' . $tx->game->image) }}" alt="" class="w-full h-full object-contain">@endif
                </div>
                <div class="flex-1 min-w-0">
                    <p class="font-display font-semibold text-sm text-gray-900 dark:text-white truncate">{{ $tx->game->name }}</p>
                    <p class="text-xs text-gray-500">{{ $tx->denomination->name }} &middot; {{ $tx->created_at->diffForHumans() }}</p>
                </div>
                <div class="text-right">
                    <p class="font-mono text-sm font-semibold text-accent">{{ $tx->formatted_amount }}</p>
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                        @if($tx->status === 'paid') bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-400
                        @elseif($tx->status === 'pending') bg-amber-100 text-amber-700 dark:bg-amber-500/20 dark:text-amber-400
                        @else bg-gray-100 text-gray-600 dark:bg-gray-500/20 dark:text-gray-400 @endif">
                        {{ ucfirst($tx->status) }}
                    </span>
                </div>
            </a>
            @empty
            <div class="text-center py-10 nb-card-static rounded-xl">
                <p class="text-gray-400 dark:text-gray-500">Belum ada transaksi</p>
                <a href="{{ route('games.index') }}" class="nb-btn-primary mt-3 inline-flex text-sm">Mulai Topup</a>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
