@extends('layouts.app')

@section('title', 'Riwayat Transaksi — Fastra Shop')

@section('slot')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-16">
    <h1 class="section-title mb-8">Riwayat Transaksi</h1>

    @forelse($transactions as $transaction)
    <a href="{{ route('transactions.show', $transaction->invoice) }}" class="block nb-card-static rounded-2xl p-5 mb-4 hover:border-accent/20 transition-colors group">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-accent/5 to-gray-100 dark:to-surface-dark-elevated flex items-center justify-center shrink-0 overflow-hidden">
                @if($transaction->game->image)
                    <img src="{{ asset('storage/' . $transaction->game->image) }}" alt="{{ $transaction->game->name }}" class="w-full h-full object-contain">
                @else
                    <div class="text-xl font-display font-bold text-gray-300 dark:text-gray-600">{{ substr($transaction->game->name, 0, 2) }}</div>
                @endif
            </div>
            <div class="flex-1 min-w-0">
                <p class="font-display font-semibold text-gray-900 dark:text-white group-hover:text-accent transition-colors truncate">{{ $transaction->game->name }}</p>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">{{ $transaction->denomination->name }} &middot; {{ $transaction->invoice }}</p>
            </div>
            <div class="text-right shrink-0">
                <p class="font-mono font-semibold text-sm text-gray-900 dark:text-white">{{ $transaction->formatted_amount }}</p>
                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium mt-1
                    @if($transaction->status === 'paid') bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-400
                    @elseif($transaction->status === 'pending') bg-amber-100 text-amber-700 dark:bg-amber-500/20 dark:text-amber-400
                    @elseif($transaction->status === 'failed') bg-red-100 text-red-700 dark:bg-red-500/20 dark:text-red-400
                    @else bg-gray-100 text-gray-600 dark:bg-gray-500/20 dark:text-gray-400 @endif">
                    {{ ucfirst($transaction->status) }}
                </span>
            </div>
        </div>
    </a>
    @empty
    <div class="text-center py-16 nb-card-static rounded-2xl">
        <svg class="w-12 h-12 text-gray-300 dark:text-gray-600 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>
        <p class="text-gray-500 dark:text-gray-400 font-medium">Belum ada transaksi</p>
        <a href="{{ route('games.index') }}" class="nb-btn-primary mt-4 inline-flex text-sm">Mulai Belanja</a>
    </div>
    @endforelse

    <div class="mt-8">
        {{ $transactions->links() }}
    </div>
</div>
@endsection
