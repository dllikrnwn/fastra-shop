@extends('layouts.app')
@section('title', 'Pembayaran — Fastra Shop')

@section('slot')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-16" x-data="paymentPage()">
    <div class="flex items-center gap-3 mb-8">
        <a href="{{ route('transactions.show', $transaction->invoice) }}" class="nb-btn-ghost inline-flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" /></svg>
            Kembali
        </a>
    </div>

    <div class="nb-card-static p-6 mb-6" style="border-color: var(--accent); box-shadow: 4px 4px 0 var(--accent-shadow);">
        <h2 class="font-display font-bold text-lg mb-4" style="color: var(--text-primary);">Ringkasan Pesanan</h2>
        <div class="space-y-2.5 text-sm">
            <div class="flex justify-between">
                <span style="color: var(--text-secondary);">Game</span>
                <span class="font-display font-bold" style="color: var(--text-primary);">{{ $transaction->game->name ?? '-' }} — {{ $transaction->denomination->name ?? '-' }}</span>
            </div>
            @if($transaction->game_nickname)
            <div class="flex justify-between">
                <span style="color: var(--text-secondary);">ID Game</span>
                <span class="font-mono font-bold" style="color: var(--accent);">{{ $transaction->game_nickname }}</span>
            </div>
            @endif
            <div class="flex justify-between">
                <span style="color: var(--text-secondary);">Invoice</span>
                <span class="font-mono text-xs" style="color: var(--text-primary);">{{ $transaction->invoice }}</span>
            </div>
            <div class="border-t-2 pt-2.5 flex justify-between items-center" style="border-color: var(--border);">
                <span class="font-display font-bold" style="color: var(--text-primary);">Total Bayar</span>
                <span class="font-mono font-black text-2xl" style="color: var(--accent);">{{ $transaction->formatted_amount }}</span>
            </div>
        </div>
    </div>

    <div class="nb-card-static p-6 mb-6">

        {{-- QRIS --}}
        @if($transaction->payment_method === 'qris')
            <h2 class="font-display font-bold text-lg mb-4" style="color: var(--text-primary);">Bayar via QRIS</h2>
            @if(payment_setting('qris_image') && \Illuminate\Support\Facades\Storage::disk('public')->exists(payment_setting('qris_image')))
            <div class="flex justify-center mb-4">
                <div class="bg-white p-3 sm:p-4 rounded-xl border-[3px]" style="border-color: var(--border);">
                    <img src="{{ asset('storage-files/' . payment_setting('qris_image')) }}" alt="QRIS" class="w-44 h-44 sm:w-56 sm:h-56 object-contain">
                </div>
            </div>
            @else
            <div class="p-8 text-center" style="border: 3px dashed var(--border); border-radius: 12px;">
                <p class="font-display font-bold" style="color: var(--text-secondary);">QRIS belum dikonfigurasi admin</p>
            </div>
            @endif
            <div class="text-center">
                <p class="text-sm" style="color: var(--text-secondary);">Scan QRIS di atas menggunakan aplikasi bank atau e-wallet</p>
                <p class="text-sm font-display font-bold mt-1" style="color: var(--text-primary);">Nominal: <span class="font-mono" style="color: var(--accent);">{{ $transaction->formatted_amount }}</span></p>
            </div>
        @endif

        {{-- Bank Transfer --}}
        @if($transaction->payment_method === 'bank_transfer')
            <h2 class="font-display font-bold text-lg mb-4" style="color: var(--text-primary);">Transfer ke {{ payment_setting('bank_name') }}</h2>
            <div class="p-5" style="border: 3px solid var(--border); border-radius: 12px; background: var(--bg-secondary);">
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-sm" style="color: var(--text-secondary);">Bank</span>
                        <span class="font-display font-bold text-lg" style="color: var(--text-primary);">{{ payment_setting('bank_name') }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm" style="color: var(--text-secondary);">No Rekening</span>
                        <div class="flex items-center gap-2">
                            <span class="font-mono font-black text-lg" style="color: var(--accent);">{{ payment_setting('bank_account') }}</span>
                            <button @click="copyToClipboard('{{ payment_setting('bank_account') }}', $event)" class="text-xs px-3 py-1.5 rounded-lg font-bold" style="background: var(--accent); color: #000; border: 2px solid var(--border);">Salin</button>
                        </div>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm" style="color: var(--text-secondary);">a.n.</span>
                        <span class="font-display font-bold" style="color: var(--text-primary);">{{ payment_setting('bank_holder') }}</span>
                    </div>
                </div>
            </div>
            <div class="text-center mt-4">
                <p class="text-sm" style="color: var(--text-secondary);">Transfer tepat: <span class="font-mono font-black text-lg" style="color: var(--accent);">{{ $transaction->formatted_amount }}</span></p>
            </div>
        @endif

        {{-- E-Wallet --}}
        @if(str_starts_with($transaction->payment_method, 'e_wallet'))
            @php $prov = str_replace('e_wallet_', '', $transaction->payment_method); $ew = ewallet_data($prov); @endphp
            <h2 class="font-display font-bold text-lg mb-4" style="color: var(--text-primary);">Bayar via {{ $ew['name'] ?? 'E-Wallet' }}</h2>
            <div class="p-5" style="border: 3px solid var(--border); border-radius: 12px; background: var(--bg-secondary);">
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-sm" style="color: var(--text-secondary);">Layanan</span>
                        <span class="font-display font-bold" style="color: var(--text-primary);">{{ $ew['name'] ?? '-' }}</span>
                    </div>
                    @if(!empty($ew['number']))
                    <div class="flex justify-between items-center">
                        <span class="text-sm" style="color: var(--text-secondary);">No HP</span>
                        <div class="flex items-center gap-2">
                            <span class="font-mono font-bold" style="color: var(--accent);">{{ $ew['number'] }}</span>
                            <button @click="copyToClipboard('{{ $ew['number'] }}', $event)" class="text-xs px-3 py-1.5 rounded-lg font-bold" style="background: var(--accent); color: #000; border: 2px solid var(--border);">Salin</button>
                        </div>
                    </div>
                    @if(!empty($ew['holder']))
                    <div class="flex justify-between items-center">
                        <span class="text-sm" style="color: var(--text-secondary);">a.n.</span>
                        <span class="font-display font-bold" style="color: var(--text-primary);">{{ $ew['holder'] }}</span>
                    </div>
                    @endif
                    @endif
                </div>
            </div>
            <div class="text-center mt-4">
                <p class="text-sm" style="color: var(--text-secondary);">Transfer tepat: <span class="font-mono font-black text-lg" style="color: var(--accent);">{{ $transaction->formatted_amount }}</span></p>
            </div>
        @endif

        <div class="mt-6 text-center">
            <button @click="confirmPayment()" :disabled="confirming" class="nb-btn-primary text-base px-10 py-4">
                <span x-show="!confirming">✅ Saya Sudah Bayar</span>
                <span x-show="confirming" x-cloak>Memproses...</span>
            </button>
        </div>
    </div>

    {{-- Popup --}}
    <div x-show="showPopup" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-50 flex items-center justify-center p-4" @click.self="closePopup()">
        <div class="fixed inset-0 bg-black/60"></div>
        <div class="relative nb-card-static p-8 max-w-sm w-full text-center" style="border-color: var(--accent); box-shadow: 6px 6px 0 var(--accent-shadow);">
            <div class="w-16 h-16 rounded-xl font-display font-black text-4xl flex items-center justify-center mx-auto mb-4" style="background: var(--neo-green); color: #000; border: 3px solid var(--border);">🎉</div>
            <h2 class="font-display font-black text-xl mb-2" style="color: var(--text-primary);">Pembayaran Berhasil!</h2>
            <p class="text-sm mb-1 font-mono" style="color: var(--text-secondary);">{{ $transaction->invoice }}</p>
            <p class="text-sm mb-5" style="color: var(--text-secondary);">Notifikasi sudah terkirim ke admin via WhatsApp</p>
            <a :href="invoiceUrl" class="nb-btn-primary w-full">Lihat Detail Transaksi</a>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function paymentPage() {
        return {
            confirming: false,
            showPopup: false,
            invoiceUrl: '',
            copyToClipboard(text, event) {
                navigator.clipboard.writeText(text);
                const btn = event.target;
                const orig = btn.textContent;
                btn.textContent = '✓ Tersalin';
                setTimeout(() => btn.textContent = orig, 2000);
            },
            async confirmPayment() {
                if (this.confirming) return;
                this.confirming = true;
                try {
                    const res = await fetch('{{ route("payment.confirm", $transaction) }}', {
                        method: 'POST',
                        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Accept': 'application/json', 'Content-Type': 'application/json' },
                    });
                    const data = await res.json();
                    if (data.success) {
                        this.showPopup = true;
                        this.invoiceUrl = data.invoice_url;
                        window.open(data.wa_url, '_blank');
                    }
                } catch (e) { alert('Error. Silakan coba lagi.'); }
                finally { this.confirming = false; }
            },
            closePopup() { this.showPopup = false; }
        };
    }
</script>
@endsection
