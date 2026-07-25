@extends('layouts.app')
@section('title', 'Bukti Transaksi — Fastra Shop')

@section('head')
<style>
    @media print {
        body { background: white !important; }
        header, footer, nav, .no-print, .scroll-to-top { display: none !important; }
        .print-receipt {
            max-width: 400px;
            margin: 0 auto;
            box-shadow: none !important;
            border: 1px solid #e5e7eb !important;
            background: white !important;
        }
        .print-receipt .nb-card-static {
            background: white !important;
            border: none !important;
        }
    }
</style>
@endsection

@section('slot')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-16">
    <div class="flex items-center justify-between mb-8 no-print">
        <div class="flex items-center gap-3">
            <a href="{{ route('transactions.show', $transaction->invoice) }}" class="nb-btn-ghost p-2">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" /></svg>
            </a>
            <h1 class="section-title">Bukti Transaksi</h1>
        </div>
        <button onclick="window.print()" class="nb-btn-primary">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" /></svg>
            Cetak
        </button>
    </div>

    {{-- Receipt Card --}}
    <div class="print-receipt nb-card-static rounded-3xl p-8 shadow-lg">
        {{-- Header --}}
        <div class="text-center pb-6 mb-6 border-b border-gray-100 dark:border-surface-dark-border">
            <x-application-logo class="h-8 mx-auto mb-2" />
            <p class="text-xs text-gray-500 dark:text-gray-400">Bukti Transaksi Topup</p>
        </div>

        {{-- Status Badge --}}
        <div class="text-center mb-6">
            @if($transaction->status === 'paid')
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-emerald-100 dark:bg-emerald-500/20 border border-emerald-200 dark:border-emerald-500/30">
                    <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                    <span class="font-display font-bold text-emerald-700 dark:text-emerald-400 text-sm">LUNAS</span>
                </div>
            @elseif($transaction->status === 'pending')
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-amber-100 dark:bg-amber-500/20 border border-amber-200 dark:border-amber-500/30">
                    <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <span class="font-display font-bold text-amber-700 dark:text-amber-400 text-sm">MENUNGGU PEMBAYARAN</span>
                </div>
            @else
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-red-100 dark:bg-red-500/20 border border-red-200 dark:border-red-500/30">
                    <span class="font-display font-bold text-red-700 dark:text-red-400 text-sm">{{ strtoupper($transaction->status) }}</span>
                </div>
            @endif
        </div>

        {{-- Transaction Info --}}
        <div class="space-y-0 divide-y divide-gray-100 dark:divide-surface-dark-border text-sm">
            <div class="flex justify-between py-3">
                <span class="text-gray-500 dark:text-gray-400">Invoice</span>
                <span class="font-mono font-medium text-gray-900 dark:text-white">{{ $transaction->invoice }}</span>
            </div>
            <div class="flex justify-between py-3">
                <span class="text-gray-500 dark:text-gray-400">Tanggal</span>
                <span class="font-medium text-gray-900 dark:text-white">{{ $transaction->created_at->format('d M Y, H:i') }} WIB</span>
            </div>
            <div class="flex justify-between py-3">
                <span class="text-gray-500 dark:text-gray-400">Game</span>
                <span class="font-medium text-gray-900 dark:text-white">{{ $transaction->game->name ?? '-' }}</span>
            </div>
            <div class="flex justify-between py-3">
                <span class="text-gray-500 dark:text-gray-400">Nominal</span>
                <span class="font-medium text-gray-900 dark:text-white">{{ $transaction->denomination->name ?? '-' }}</span>
            </div>
            <div class="flex justify-between py-3">
                <span class="text-gray-500 dark:text-gray-400">Pembeli</span>
                <span class="font-medium text-gray-900 dark:text-white">{{ $transaction->buyer_name }}</span>
            </div>
            <div class="flex justify-between py-3">
                <span class="text-gray-500 dark:text-gray-400">Email</span>
                <span class="font-medium text-gray-900 dark:text-white">{{ $transaction->buyer_email }}</span>
            </div>
            @if($transaction->buyer_phone)
            <div class="flex justify-between py-3">
                <span class="text-gray-500 dark:text-gray-400">Telepon</span>
                <span class="font-medium text-gray-900 dark:text-white">{{ $transaction->buyer_phone }}</span>
            </div>
            @endif
            <div class="flex justify-between py-3">
                <span class="text-gray-500 dark:text-gray-400">Metode Bayar</span>
                <span class="font-medium text-gray-900 dark:text-white">{{ ucfirst(str_replace('_', ' ', $transaction->payment_method ?? '-')) }}</span>
            </div>
            @if($transaction->paid_at)
            <div class="flex justify-between py-3">
                <span class="text-gray-500 dark:text-gray-400">Dibayar</span>
                <span class="font-medium text-gray-900 dark:text-white">{{ $transaction->paid_at->format('d M Y, H:i') }} WIB</span>
            </div>
            @endif
        </div>

        {{-- Total --}}
        <div class="mt-4 p-4 rounded-xl bg-gray-50 dark:bg-surface-dark-elevated border border-gray-200 dark:border-surface-dark-border">
            <div class="flex justify-between items-center">
                <span class="font-display font-semibold text-gray-900 dark:text-white">Total Bayar</span>
                <span class="font-mono font-bold text-2xl text-accent">{{ $transaction->formatted_amount }}</span>
            </div>
        </div>

        {{-- Footer --}}
        <div class="mt-6 pt-6 border-t border-gray-100 dark:border-surface-dark-border text-center">
            <p class="text-xs text-gray-400 dark:text-gray-500 mb-2">Transaksi ini diproses oleh Fastra Shop</p>
            <p class="text-xs text-gray-400 dark:text-gray-500">Terima kasih atas pembelianmu!</p>
        </div>
    </div>

    {{-- Actions --}}
    <div class="flex gap-3 mt-6 no-print">
        <a href="{{ route('transactions.show', $transaction->invoice) }}" class="nb-btn-secondary flex-1">Kembali</a>
        @if($transaction->status === 'pending')
            <a href="{{ route('payment.pay', $transaction) }}" class="nb-btn-primary flex-1">Bayar Sekarang</a>
        @endif
    </div>
</div>
@endsection
