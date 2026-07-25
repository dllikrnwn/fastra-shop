@extends('layouts.app')

@section('title', 'Pembayaran — Fastra Shop')

@section('head')
<script src="{{ config('services.midtrans.is_production') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
@endsection

@section('slot')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-16 text-center">
    <div class="nb-card-static rounded-3xl p-10">
        <div class="w-16 h-16 rounded-full bg-amber-100 dark:bg-amber-500/20 flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-amber-600 dark:text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" /></svg>
        </div>
        <h1 class="font-display text-2xl font-bold text-gray-900 dark:text-white mb-2">Selesaikan Pembayaran</h1>
        <p class="text-gray-500 dark:text-gray-400 text-sm mb-6">Klik tombol di bawah untuk membuka halaman pembayaran</p>

        <div class="max-w-xs mx-auto space-y-3 mb-8">
            <div class="flex justify-between text-sm"><span class="text-gray-500">Invoice</span><span class="font-mono font-medium text-gray-900 dark:text-white">{{ $transaction->invoice }}</span></div>
            <div class="flex justify-between text-sm"><span class="text-gray-500">Total</span><span class="font-mono font-bold text-lg text-accent">{{ $transaction->formatted_amount }}</span></div>
        </div>

        <button id="pay-button" class="nb-btn-primary text-base px-10 py-4 rounded-xl shadow-glow-sm hover:shadow-glow">
            Bayar Sekarang
        </button>

        <a href="{{ route('transactions.show', $transaction->invoice) }}" class="block mt-4 text-sm text-gray-500 dark:text-gray-400 hover:text-accent transition-colors">
            Nanti saja, lihat detail transaksi
        </a>
    </div>
</div>
@endsection

@section('scripts')
<script>
    var SNAP_TOKEN = '{{ $snapToken }}';
    var PAY_FINISH = '{{ route("payment.finish") }}';
    var PAY_UNFINISH = '{{ route("payment.unfinish") }}';
    var PAY_ERROR = '{{ route("payment.error") }}';

    document.getElementById('pay-button').onclick = function() {
        var btn = this;

        if (typeof snap === 'undefined') {
            alert('Payment gateway belum siap. Silakan refresh halaman ini.');
            return;
        }

        btn.disabled = true;
        btn.textContent = 'Memproses...';

        snap.pay(SNAP_TOKEN, {
            onSuccess: function(result) {
                window.location.href = PAY_FINISH + '?order_id=' + result.order_id;
            },
            onPending: function(result) {
                window.location.href = PAY_UNFINISH + '?order_id=' + result.order_id;
            },
            onError: function(result) {
                window.location.href = PAY_ERROR + '?order_id=' + result.order_id;
            },
            onClose: function() {
                btn.disabled = false;
                btn.textContent = 'Bayar Sekarang';
            }
        });
    };
</script>
@endsection
