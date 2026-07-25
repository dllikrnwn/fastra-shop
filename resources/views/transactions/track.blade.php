@extends('layouts.app')

@section('title', 'Lacak Transaksi — Fastra Shop')

@section('slot')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-20">
    @if(!isset($transaction))
    {{-- Form --}}
    <div class="text-center mb-10">
        <div class="w-16 h-16 rounded-xl flex items-center justify-center mx-auto mb-4" style="background: var(--accent); color: #000; border: 3px solid var(--border); box-shadow: 3px 3px 0 var(--border);">
            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" /></svg>
        </div>
        <h1 class="section-title mb-2">Lacak Transaksi</h1>
        <p class="section-subtitle">Masukkan nomor invoice untuk cek status</p>
    </div>

    <form method="POST" action="{{ route('transactions.lookup') }}" class="space-y-4">
        @csrf
        <div class="flex flex-col sm:flex-row gap-3">
            <input type="text" name="invoice" value="{{ old('invoice') }}" class="nb-input flex-1" required placeholder="Contoh: FST-CUHQOUNV-20260724">
            <button type="submit" class="nb-btn-primary">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" /></svg>
                Lacak
            </button>
        </div>
    </form>
    @else
    {{-- Hasil --}}
    <a href="{{ route('home') }}" class="nb-btn-ghost inline-flex items-center gap-2 mb-6">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" /></svg>
        Kembali
    </a>

    <div class="nb-card-static p-6 mb-6 text-center">
        @if($transaction->status === 'paid')
            <div class="w-16 h-16 rounded-xl flex items-center justify-center mx-auto mb-4" style="background: var(--neo-green); color: #000; border: 3px solid var(--border);">
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
            </div>
            <p class="font-display font-black text-xl" style="color: var(--neo-green);">✅ LUNAS</p>
        @elseif($transaction->status === 'awaiting_verification')
            <div class="w-16 h-16 rounded-xl flex items-center justify-center mx-auto mb-4" style="background: var(--accent); color: #000; border: 3px solid var(--border);">
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
            <p class="font-display font-black text-xl" style="color: var(--accent);">⏳ Menunggu Verifikasi</p>
        @elseif($transaction->status === 'pending')
            <div class="w-16 h-16 rounded-xl flex items-center justify-center mx-auto mb-4" style="background: var(--neo-yellow); color: #000; border: 3px solid var(--border);">
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
            <p class="font-display font-black text-xl" style="color: var(--neo-yellow);">⏳ Menunggu Pembayaran</p>
        @elseif($transaction->status === 'failed')
            <div class="w-16 h-16 rounded-xl flex items-center justify-center mx-auto mb-4" style="background: var(--neo-pink); color: #000; border: 3px solid var(--border);">
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
            </div>
            <p class="font-display font-black text-xl" style="color: var(--neo-pink);">✕ Gagal</p>
        @else
            <div class="w-16 h-16 rounded-xl flex items-center justify-center mx-auto mb-4" style="background: var(--bg-primary); color: #000; border: 3px solid var(--border);">
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
            <p class="font-display font-black text-xl" style="color: var(--text-secondary);">⏳ Kedaluwarsa</p>
        @endif
    </div>

    <div class="nb-card-static p-6 mb-6">
        <div class="space-y-3 text-sm">
            <div class="flex justify-between"><span style="color: var(--text-secondary);">Invoice</span><span class="font-mono font-bold" style="color: var(--text-primary);">{{ $transaction->invoice }}</span></div>
            <div class="flex justify-between"><span style="color: var(--text-secondary);">Game</span><span class="font-medium" style="color: var(--text-primary);">{{ $transaction->game->name ?? '-' }}</span></div>
            <div class="flex justify-between"><span style="color: var(--text-secondary);">Nominal</span><span class="font-medium" style="color: var(--text-primary);">{{ $transaction->denomination->name ?? ($transaction->custom_quantity ? $transaction->custom_quantity . ' unit' : '-') }}</span></div>
            @if($transaction->game_nickname)
            <div class="flex justify-between"><span style="color: var(--text-secondary);">ID Game</span><span class="font-mono font-bold" style="color: var(--accent);">{{ $transaction->game_nickname }}</span></div>
            @endif
            <div class="flex justify-between"><span style="color: var(--text-secondary);">Pembeli</span><span class="font-medium" style="color: var(--text-primary);">{{ $transaction->buyer_name }}</span></div>
            <div class="flex justify-between"><span style="color: var(--text-secondary);">Tanggal</span><span class="font-medium" style="color: var(--text-primary);">{{ $transaction->created_at->format('d M Y, H:i') }} WIB</span></div>
            <div class="border-t-2 pt-3 flex justify-between" style="border-color: var(--border);">
                <span class="font-display font-bold" style="color: var(--text-primary);">Total</span>
                <span class="font-mono font-black text-xl" style="color: var(--accent);">{{ $transaction->formatted_amount }}</span>
            </div>
        </div>
    </div>

    <div class="flex gap-3">
        <a href="{{ route('transactions.receipt', $transaction->invoice) }}" class="nb-btn-secondary flex-1">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" /></svg>
            Cetak Bukti
        </a>
        <a href="{{ route('transactions.lookup') }}" class="nb-btn-primary flex-1">Lacak Lainnya</a>
    </div>
    @endif
</div>
@endsection
