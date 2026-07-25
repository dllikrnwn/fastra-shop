@extends('layouts.app')
@section('title', $game->name . ' — Fastra Shop')

@section('slot')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-16">
    <a href="{{ route('games.index') }}" class="nb-btn-ghost inline-flex items-center gap-2 mb-6">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" /></svg>
        Kembali ke Semua Game
    </a>

    <div class="flex flex-col md:flex-row gap-8 mb-12">
        <div class="w-full md:w-72 shrink-0">
            <div class="nb-card-static overflow-hidden" style="border-color: var(--accent); box-shadow: 4px 4px 0 var(--accent-shadow);">
                <div class="aspect-square flex items-center justify-center p-8" style="background: var(--bg-secondary);">
                    @if($game->image)
                        <img src="{{ asset('storage-files/' . $game->image) }}" alt="{{ $game->name }}" class="w-full h-full object-contain">
                    @else
                        <div class="text-7xl font-display font-black" style="color: var(--text-secondary);">{{ substr($game->name, 0, 2) }}</div>
                    @endif
                </div>
            </div>
        </div>
        <div class="flex-1">
            <div class="inline-flex px-3 py-1 rounded-lg text-xs font-display font-bold mb-4" style="background: var(--accent); color: #000; border: 2px solid var(--border);">
                {{ $game->category->name ?? 'Game' }}
            </div>
            <h1 class="font-display font-black text-3xl md:text-4xl leading-tight" style="color: var(--text-primary);">{{ $game->name }}</h1>
            @if($game->description)
            <p class="mt-4 leading-relaxed" style="color: var(--text-secondary);">{{ $game->description }}</p>
            @endif
        </div>
    </div>

    <div x-data="customAmount()">
        <h2 class="font-display font-bold text-xl mb-6" style="color: var(--text-primary);">Pilih Nominal</h2>

        {{-- Denominations Grid --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3 mb-8">
            @forelse($game->denominations as $d)
            <a href="{{ route('checkout', [$game, $d]) }}" class="nb-card p-4 text-center hover:-translate-y-1 transition-all group">
                <p class="font-display font-bold text-sm" style="color: var(--text-primary);">{{ $d->name }}</p>
                <p class="font-mono font-bold text-lg mt-1" style="color: var(--accent);">{{ $d->formatted_price }}</p>
            </a>
            @empty
            <p class="col-span-full text-center py-8" style="color: var(--text-secondary);">Belum ada nominal</p>
            @endforelse
        </div>

        {{-- Custom Amount (hanya untuk game yang punya has_custom_amount) --}}
        @if($game->has_custom_amount)
        <div class="nb-card-static p-6" style="border-color: var(--accent); box-shadow: 4px 4px 0 var(--accent-shadow);">
            <div class="flex items-center gap-3 mb-5">
                <div class="w-8 h-8 flex items-center justify-center font-bold text-sm rounded-lg" style="background: var(--accent); color: #000; border: 2px solid var(--border);">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                </div>
                <h3 class="font-display font-bold text-lg" style="color: var(--text-primary);">Atau Isi Sendiri</h3>
            </div>

            <div class="flex flex-col sm:flex-row items-start sm:items-end gap-4">
                <div class="flex-1 w-full">
                    <label class="block text-sm font-display font-bold mb-1.5" style="color: var(--text-primary);">Masukkan jumlah</label>
                    <input type="number" x-model="qty" min="1" placeholder="Contoh: 120" class="nb-input" @input="calculatePrice()">
                    <p class="text-xs mt-1" style="color: var(--text-secondary);">Masukkan jumlah {{ $game->denominations->first()?->nominal ?? 'unit' }}</p>
                </div>
                <div class="text-right shrink-0 w-full sm:w-auto">
                    <p class="text-xs font-display font-bold" style="color: var(--text-secondary);">Total Harga</p>
                    <p class="font-mono font-black text-2xl" style="color: var(--accent);" x-text="totalFormatted">Rp 0</p>
                </div>
            </div>

            <div class="mt-6">
                <a :href="checkoutUrl" class="nb-btn-primary inline-flex w-full sm:w-auto justify-center" :class="qty < 1 ? 'opacity-50 pointer-events-none' : ''">
                    <span x-text="'Beli ' + (qty || 0) + ' → Checkout'">Beli → Checkout</span>
                </a>
            </div>
        </div>
        @endif
    </div>
</div>

{{-- Guide Game Pass Roblox --}}
@if($game->slug === 'robux')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 pb-12" x-data="{ showGuide: false }">
    <div class="nb-card-static p-6">
        <button @click="showGuide = !showGuide" class="w-full flex items-center justify-between gap-3 text-left">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg flex items-center justify-center font-bold text-sm shrink-0" style="background: var(--accent); color: #000; border: 2px solid var(--border);">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" /></svg>
                </div>
                <div>
                    <p class="font-display font-bold text-lg" style="color: var(--text-primary);">Cara Kirim Robux via Game Pass</p>
                    <p class="text-sm" style="color: var(--text-secondary);" x-show="!showGuide">Klik untuk lihat panduan lengkap →</p>
                </div>
            </div>
            <svg class="w-5 h-5 shrink-0 transition-transform" :class="showGuide ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" /></svg>
        </button>

        <div x-show="showGuide" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="mt-6 space-y-6">

            {{-- Video Tutorial --}}
            @if($game->guide_video && \Illuminate\Support\Facades\Storage::disk('public')->exists($game->guide_video))
            <div>
                <p class="font-display font-bold text-sm mb-3" style="color: var(--text-primary);">🎬 Video Tutorial</p>
                <div class="rounded-xl overflow-hidden border-[3px]" style="border-color: var(--border);">
                    <video controls class="w-full max-h-[400px] bg-black">
                        <source src="{{ asset('storage-files/' . $game->guide_video) }}" type="video/mp4">
                        Browser tidak mendukung video.
                    </video>
                </div>
            </div>
            @endif

            {{-- 14 Steps --}}
            <div>
                <p class="font-display font-bold text-sm mb-3" style="color: var(--text-primary);">📝 Panduan Lengkap</p>
                <div class="space-y-3">
                    @php $steps = [
                        'Di aplikasi Roblox-mu, klik menu <strong>Lainnya / More</strong>',
                        'Lalu, klik menu <strong>Buat / Create</strong>',
                        'Scroll ke bawah, lalu klik <strong>Place</strong> kamu',
                        'Klik tombol <strong>garis tiga</strong> (☰) di kiri atas halaman',
                        'Scroll ke bawah dan klik <strong>Passes</strong> di bawah kategori Monetization',
                        'Di halaman Passes, klik <strong>Create A Pass</strong>',
                        'Masukkan nama (bisa apa aja), lalu klik <strong>Create Pass</strong>',
                        'Pass akan muncul di halaman Passes. Klik pass yang tadi kamu buat',
                        'Klik lagi tombol <strong>garis tiga</strong> (☰) di kiri atas halaman',
                        'Setelah itu, klik <strong>Sales</strong>',
                        'Di halaman Sales, aktifkan <strong>Item for Sale</strong>',
                        'Isi Default Price dengan harga sesuai nominal yang kamu beli',
                        'PENTING: Non-aktifkan dulu <strong>Managed Pricing</strong>',
                        'Terakhir, klik <strong>Save Changes</strong>',
                    ]; @endphp
                    @foreach($steps as $i => $step)
                    <div class="flex items-start gap-3">
                        <div class="w-7 h-7 rounded-lg flex items-center justify-center shrink-0 text-xs font-black" style="background: var(--accent); color: #000; border: 2px solid var(--border);">{{ $i + 1 }}</div>
                        <p class="text-sm pt-1 leading-relaxed" style="color: var(--text-primary);">{!! $step !!}</p>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Note --}}
            <div class="p-4 rounded-xl" style="background: var(--bg-primary); border: 2px solid var(--border);">
                <p class="text-xs font-bold" style="color: var(--accent);">📌 Catatan:</p>
                <ul class="text-xs mt-2 space-y-1" style="color: var(--text-secondary);">
                    <li>• Pastikan username Roblox kamu benar</li>
                    <li>• Harga Game Pass harus sesuai dengan nominal yang kamu beli</li>
                    <li>• Robux tidak langsung masuk karena proses Game Pass memakan waktu 3-7 hari</li>
                    <li>• Setelah bayar, kirim link Game Pass ke WhatsApp admin untuk diproses</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endif

@endsection

@section('scripts')
<script>
function customAmount() {
    return {
        qty: '',
        total: 0,
        tiers: @json($game->denominations->map(fn($d) => ['qty' => (int) filter_var($d->nominal, FILTER_SANITIZE_NUMBER_INT), 'price' => (int) $d->price])),
        get totalFormatted() {
            return 'Rp ' + this.total.toLocaleString('id-ID');
        },
        get checkoutUrl() {
            if (!this.qty || this.qty < 1) return '#';
            return '{{ route('checkout.custom', [$game, '__qty__']) }}'.replace('__qty__', this.qty);
        },
        calculatePrice() {
            const q = parseInt(this.qty);
            if (!q || q < 1) { this.total = 0; return; }

            // Find matching tier from pricelist
            let best = null;
            for (const tier of this.tiers) {
                if (tier.qty <= q) best = tier;
            }

            if (best) {
                // If exact match, use exact price
                const exact = this.tiers.find(t => t.qty === q);
                if (exact) {
                    this.total = exact.price;
                } else {
                    // For custom qty, use rate from nearest lower tier
                    const rate = Math.round(best.price / best.qty);
                    this.total = q * rate;
                }
            } else {
                this.total = q * 500; // fallback rate
            }
        }
    };
}
</script>
@endsection
