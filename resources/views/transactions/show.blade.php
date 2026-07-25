@extends('layouts.app')

@section('title', 'Detail Transaksi — Fastra Shop')

@section('slot')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-16">
    <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 mb-8">
        <a href="{{ route('home') }}" class="hover:text-accent transition-colors">Beranda</a>
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" /></svg>
        <span class="text-gray-900 dark:text-white font-medium">{{ $transaction->invoice }}</span>
    </div>

    <div class="nb-card-static rounded-3xl p-8 mb-6 text-center">
        @if($transaction->status === 'paid')
            <div class="w-16 h-16 rounded-full bg-emerald-100 dark:bg-emerald-500/20 flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
            </div>
            <h2 class="font-display text-2xl font-bold text-emerald-600 dark:text-emerald-400">Pembayaran Berhasil</h2>
            <p class="text-gray-500 dark:text-gray-400 text-sm mt-2">Topup akan segera diproses</p>
        @elseif($transaction->status === 'awaiting_verification')
            <div class="w-16 h-16 rounded-full bg-cyan-100 dark:bg-cyan-500/20 flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-cyan-600 dark:text-cyan-400 animate-glow-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
            <h2 class="font-display text-2xl font-bold text-cyan-600 dark:text-cyan-400">Menunggu Verifikasi</h2>
            <p class="text-gray-500 dark:text-gray-400 text-sm mt-2">Admin sedang memverifikasi pembayaran kamu</p>
        @elseif($transaction->status === 'pending')
            <div class="w-16 h-16 rounded-full bg-amber-100 dark:bg-amber-500/20 flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-amber-600 dark:text-amber-400 animate-glow-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
            <h2 class="font-display text-2xl font-bold text-amber-600 dark:text-amber-400">Menunggu Pembayaran</h2>
            <p class="text-gray-500 dark:text-gray-400 text-sm mt-2">Silakan lakukan pembayaran</p>
        @elseif($transaction->status === 'failed')
            <div class="w-16 h-16 rounded-full bg-red-100 dark:bg-red-500/20 flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
            </div>
            <h2 class="font-display text-2xl font-bold text-red-600 dark:text-red-400">Pembayaran Gagal</h2>
            <p class="text-gray-500 dark:text-gray-400 text-sm mt-2">Silakan coba transaksi baru</p>
        @else
            <div class="w-16 h-16 rounded-full bg-gray-100 dark:bg-gray-500/20 flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-gray-500 dark:text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
            <h2 class="font-display text-2xl font-bold text-gray-600 dark:text-gray-400">Transaksi Kedaluwarsa</h2>
        @endif
    </div>

    <div class="nb-card-static rounded-2xl p-6 mb-6">
        <h2 class="font-display font-semibold text-gray-900 dark:text-white mb-5">Detail Transaksi</h2>
        <div class="space-y-3.5 text-sm">
            <div class="flex justify-between items-center">
                <span class="text-gray-500 dark:text-gray-400">Invoice</span>
                <span class="font-mono font-medium text-gray-900 dark:text-white">{{ $transaction->invoice }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-gray-500 dark:text-gray-400">Game</span>
                <span class="font-medium text-gray-900 dark:text-white">{{ $transaction->game->name ?? '-' }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-gray-500 dark:text-gray-400">Nominal</span>
                <span class="font-medium text-gray-900 dark:text-white">{{ $transaction->denomination->name ?? '-' }}</span>
            </div>
            @if($transaction->game_nickname)
            <div class="flex justify-between items-center">
                <span class="text-gray-500 dark:text-gray-400">ID Game</span>
                <span class="font-mono font-bold text-gray-900 dark:text-white bg-accent/10 px-2 py-1 rounded-lg">{{ $transaction->game_nickname }}</span>
            </div>
            @endif
            <div class="flex justify-between items-center">
                <span class="text-gray-500 dark:text-gray-400">Pembeli</span>
                <span class="font-medium text-gray-900 dark:text-white">{{ $transaction->buyer_name }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-gray-500 dark:text-gray-400">Email</span>
                <span class="font-medium text-gray-900 dark:text-white">{{ $transaction->buyer_email }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-gray-500 dark:text-gray-400">Metode Bayar</span>
                <span class="font-medium text-gray-900 dark:text-white">{{ ucfirst(str_replace('_', ' ', $transaction->payment_method ?? '-')) }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-gray-500 dark:text-gray-400">Status</span>
                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium
                    @if($transaction->status === 'paid') bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-400
                    @elseif($transaction->status === 'awaiting_verification') bg-cyan-100 text-cyan-700 dark:bg-cyan-500/20 dark:text-cyan-400
                    @elseif($transaction->status === 'pending') bg-amber-100 text-amber-700 dark:bg-amber-500/20 dark:text-amber-400
                    @elseif($transaction->status === 'failed') bg-red-100 text-red-700 dark:bg-red-500/20 dark:text-red-400
                    @else bg-gray-100 text-gray-600 dark:bg-gray-500/20 dark:text-gray-400 @endif">
                    @if($transaction->status === 'awaiting_verification') Menunggu Verifikasi
                    @else {{ ucfirst($transaction->status) }}
                    @endif
                </span>
            </div>
            <div class="border-t border-gray-100 dark:border-surface-dark-border pt-3 flex justify-between items-center">
                <span class="font-display font-semibold text-gray-900 dark:text-white">Total Bayar</span>
                <span class="font-mono font-bold text-xl text-accent">{{ $transaction->formatted_amount }}</span>
            </div>
        </div>
    </div>

    <div class="flex gap-3">
        <a href="{{ route('transactions.track') }}" class="nb-btn-secondary flex-1">Lacak Transaksi</a>
        <a href="{{ route('transactions.receipt', $transaction->invoice) }}" class="nb-btn-ghost flex-1 text-center border-2" style="border-color: var(--border);">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" /></svg>
            Bukti
        </a>
        @if($transaction->status === 'pending')
            <a href="{{ route('payment.manual', $transaction) }}" class="nb-btn-primary flex-1">Bayar Sekarang</a>
        @endif
    </div>
</div>
@endsection
