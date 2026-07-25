@extends('layouts.admin')
@section('title', 'Detail Transaksi — Admin')

@section('slot')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex items-center gap-3 mb-8">
        <a href="{{ route('admin.transactions.index') }}" class="nb-btn-ghost p-2">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" /></svg>
        </a>
        <h1 class="section-title">Detail Transaksi</h1>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="nb-card-static p-6">
                <h2 class="font-display font-semibold text-gray-900 dark:text-white mb-5">Informasi Transaksi</h2>
                <div class="space-y-3.5 text-sm">
                    <div class="flex justify-between items-center">
                        <span style="color: var(--text-secondary);">Invoice</span>
                        <span class="font-mono font-medium" style="color: var(--text-primary);">{{ $transaction->invoice }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span style="color: var(--text-secondary);">User</span>
                        <span class="font-medium" style="color: var(--text-primary);">{{ $transaction->user?->name ?? 'Guest' }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span style="color: var(--text-secondary);">Game</span>
                        <span class="font-medium" style="color: var(--text-primary);">{{ $transaction->game->name ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span style="color: var(--text-secondary);">Nominal</span>
                        <span class="font-medium" style="color: var(--text-primary);">{{ $transaction->denomination->name ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span style="color: var(--text-secondary);">Pembeli</span>
                        <span class="font-medium" style="color: var(--text-primary);">{{ $transaction->buyer_name }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span style="color: var(--text-secondary);">Email</span>
                        <span class="font-medium" style="color: var(--text-primary);">{{ $transaction->buyer_email }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span style="color: var(--text-secondary);">Telepon</span>
                        <span class="font-medium" style="color: var(--text-primary);">{{ $transaction->buyer_phone ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span style="color: var(--text-secondary);">Metode</span>
                        <span class="font-medium" style="color: var(--text-primary);">{{ ucfirst(str_replace('_', ' ', $transaction->payment_method)) }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span style="color: var(--text-secondary);">Payment ID</span>
                        <span class="font-mono text-xs" style="color: var(--text-primary);">{{ $transaction->payment_id ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span style="color: var(--text-secondary);">Dibuat</span>
                        <span class="font-medium" style="color: var(--text-primary);">{{ $transaction->created_at->format('d M Y, H:i') }} WIB</span>
                    </div>
                    @if($transaction->paid_at)
                    <div class="flex justify-between items-center">
                        <span style="color: var(--text-secondary);">Dibayar</span>
                        <span class="font-medium" style="color: var(--text-primary);">{{ $transaction->paid_at->format('d M Y, H:i') }} WIB</span>
                    </div>
                    @endif
                    <div class="border-t pt-3 flex justify-between items-center" style="border-color: var(--border);">
                        <span class="font-display font-semibold" style="color: var(--text-primary);">Total</span>
                        <span class="font-mono font-bold text-xl text-accent">{{ $transaction->formatted_amount }}</span>
                    </div>
                </div>
            </div>

            @if($transaction->status === 'pending' || $transaction->status === 'awaiting_verification')
            <div class="nb-card-static p-6" style="border-color: var(--accent); box-shadow: 4px 4px 0 var(--accent-shadow);">
                <h2 class="font-display font-semibold text-gray-900 dark:text-white mb-5">Verifikasi Pembayaran</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Cek rekening kamu, apakah ada transfer masuk sebesar <span class="font-mono font-semibold text-accent">{{ $transaction->formatted_amount }}</span>?</p>
                <div class="flex gap-3">
                    <form method="POST" action="{{ route('admin.transactions.status', $transaction) }}" onsubmit="return confirm('Approve transaksi ini? Pastikan pembayaran sudah masuk di rekening.')">
                        @csrf @method('PATCH')
                        <input type="hidden" name="status" value="paid">
                        <button type="submit" class="nb-btn-primary bg-emerald-500 hover:bg-emerald-600 shadow-none">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                            Approve
                        </button>
                    </form>
                    <form method="POST" action="{{ route('admin.transactions.status', $transaction) }}" onsubmit="return confirm('Reject transaksi ini?')">
                        @csrf @method('PATCH')
                        <input type="hidden" name="status" value="failed">
                        <button type="submit" class="nb-btn-primary bg-red-500 hover:bg-red-600 shadow-none">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                            Reject
                        </button>
                    </form>
                </div>
            </div>
            @endif
        </div>

        <div class="lg:col-span-1">
            <div class="nb-card-static p-6 sticky top-24">
                <h2 class="font-display font-semibold text-gray-900 dark:text-white mb-5">Status</h2>

                <div class="text-center mb-5">
                    @if($transaction->status === 'paid')
                        <div class="w-16 h-16 rounded-full bg-emerald-100 dark:bg-emerald-500/20 flex items-center justify-center mx-auto mb-3">
                            <svg class="w-8 h-8 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                        </div>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-400">Dibayar</span>
                    @elseif($transaction->status === 'awaiting_verification')
                        <div class="w-16 h-16 rounded-full bg-cyan-100 dark:bg-cyan-500/20 flex items-center justify-center mx-auto mb-3">
                            <svg class="w-8 h-8 text-cyan-600 dark:text-cyan-400 animate-glow-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-cyan-100 text-cyan-700 dark:bg-cyan-500/20 dark:text-cyan-400">Menunggu Verifikasi</span>
                    @elseif($transaction->status === 'pending')
                        <div class="w-16 h-16 rounded-full bg-amber-100 dark:bg-amber-500/20 flex items-center justify-center mx-auto mb-3">
                            <svg class="w-8 h-8 text-amber-600 dark:text-amber-400 animate-glow-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-amber-100 text-amber-700 dark:bg-amber-500/20 dark:text-amber-400">Menunggu Bayar</span>
                    @elseif($transaction->status === 'failed')
                        <div class="w-16 h-16 rounded-full bg-red-100 dark:bg-red-500/20 flex items-center justify-center mx-auto mb-3">
                            <svg class="w-8 h-8 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                        </div>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-700 dark:bg-red-500/20 dark:text-red-400">Gagal</span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-600 dark:bg-gray-500/20 dark:text-gray-400">{{ ucfirst($transaction->status) }}</span>
                    @endif
                </div>

                <div class="text-center">
                    <p class="font-mono font-bold text-2xl text-accent">{{ $transaction->formatted_amount }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
