@extends('layouts.app')
@section('title', 'Checkout — Fastra Shop')

@section('slot')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-16">
    <div class="flex items-center gap-3 mb-8">
        <a href="{{ route('games.show', $game->slug) }}" class="nb-btn-ghost inline-flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" /></svg>
            Kembali
        </a>
    </div>

    <h1 class="section-title mb-8">Checkout</h1>

    <form method="POST" action="{{ route('checkout.process', [$game, $denomination]) }}" class="space-y-5">
        @csrf
        @if(isset($quantity) && $quantity)
        <input type="hidden" name="custom_quantity" value="{{ $quantity }}">
        @endif

        {{-- Ringkasan Pesanan --}}
        <div class="nb-card-static p-5 mb-6" style="border-color: var(--accent); box-shadow: 4px 4px 0 var(--accent-shadow);">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-xl overflow-hidden border-[3px] shrink-0 flex items-center justify-center" style="border-color: var(--border); background: var(--bg-secondary);">
                    @if($game->image)
                        <img src="{{ asset('storage/' . $game->image) }}" alt="{{ $game->name }}" class="w-full h-full object-contain">
                    @else
                        <span class="font-display font-black text-xl" style="color: var(--text-secondary);">{{ substr($game->name, 0, 2) }}</span>
                    @endif
                </div>
                <div class="min-w-0">
                    <p class="font-display font-bold text-sm" style="color: var(--text-primary);">{{ $game->name }}</p>
                    <p class="text-xs" style="color: var(--text-secondary);">{{ $denomination->name ?? ($quantity . ' ' . $game->name) }}</p>
                    <p class="font-mono font-bold text-lg mt-1" style="color: var(--accent);">{{ $denomination->formatted_price ?? 'Rp ' . number_format($denomination->price, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        {{-- Form Fields --}}
        <div class="nb-card-static p-6">
            <h2 class="font-display font-bold text-lg mb-4" style="color: var(--text-primary);">Data Pembelian</h2>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-display font-bold mb-1.5" style="color: var(--text-primary);">Game ID / Nickname <span style="color: #FF4444;">*</span></label>
                    <input type="text" name="game_nickname" value="{{ old('game_nickname') }}" class="nb-input" required placeholder="ID atau nickname di dalam game">
                    <p class="text-xs mt-1" style="color: var(--text-secondary);">Pastikan ID/nickname kamu benar agar topup masuk ke akun yang tepat</p>
                    @error('game_nickname')<p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p>@enderror
                </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-display font-bold mb-1.5" style="color: var(--text-primary);">Nama Lengkap <span style="color: #FF4444;">*</span></label>
                            <input type="text" name="buyer_name" value="{{ old('buyer_name', auth()->user()->name ?? '') }}" class="nb-input" required>
                            @error('buyer_name')<p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-display font-bold mb-1.5" style="color: var(--text-primary);">Email <span style="color: #FF4444;">*</span></label>
                            <input type="email" name="buyer_email" value="{{ old('buyer_email', auth()->user()->email ?? '') }}" class="nb-input" required>
                            @error('buyer_email')<p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p>@enderror
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-display font-bold mb-1.5" style="color: var(--text-primary);">No. WhatsApp <span style="color: #FF4444;">*</span></label>
                        <input type="tel" name="buyer_phone" value="{{ old('buyer_phone', auth()->user()->phone ?? '') }}" placeholder="628xxxxxxxxxx" class="nb-input" required>
                    <p class="text-xs mt-1" style="color: var(--text-secondary);">Untuk notifikasi status pesanan</p>
                    @error('buyer_phone')<p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>

        {{-- Payment Method --}}
        <div class="nb-card-static p-6">
            <h2 class="font-display font-bold text-lg mb-5" style="color: var(--text-primary);">Metode Pembayaran</h2>
            <div class="space-y-3" x-data="{ selected: 'qris', ew: '' }">
                @php $ewallets = payment_setting('ewallets', []); @endphp
                <label class="flex items-center gap-4 p-4 rounded-xl cursor-pointer transition-all duration-150" style="border: 3px solid var(--border); box-shadow: 3px 3px 0 var(--border); background: var(--bg-secondary);"
                    :style="selected === 'qris' ? 'border-color: var(--accent); background: rgba(0,229,255,0.08); box-shadow: 4px 4px 0 var(--accent-shadow);' : ''">
                    <input type="radio" name="payment_method" value="qris" x-model="selected" class="hidden">
                    <div class="w-5 h-5 rounded-full border-[3px] flex items-center justify-center shrink-0" :style="selected === 'qris' ? 'border-color: var(--accent)' : 'border-color: var(--border)'">
                        <div x-show="selected === 'qris'" class="w-2.5 h-2.5 rounded-full" style="background: var(--accent);"></div>
                    </div>
                    <div class="flex-1">
                        <p class="font-display font-bold text-sm" style="color: var(--text-primary);">QRIS</p>
                        <p class="text-xs" style="color: var(--text-secondary);">Scan QR dari bank/e-wallet</p>
                    </div>
                </label>

                <label class="flex items-center gap-4 p-4 rounded-xl cursor-pointer transition-all duration-150" style="border: 3px solid var(--border); box-shadow: 3px 3px 0 var(--border); background: var(--bg-secondary);"
                    :style="selected === 'bank_transfer' ? 'border-color: var(--accent); background: rgba(0,229,255,0.08); box-shadow: 4px 4px 0 var(--accent-shadow);' : ''">
                    <input type="radio" name="payment_method" value="bank_transfer" x-model="selected" class="hidden">
                    <div class="w-5 h-5 rounded-full border-[3px] flex items-center justify-center shrink-0" :style="selected === 'bank_transfer' ? 'border-color: var(--accent)' : 'border-color: var(--border)'">
                        <div x-show="selected === 'bank_transfer'" class="w-2.5 h-2.5 rounded-full" style="background: var(--accent);"></div>
                    </div>
                    <div class="flex-1">
                        <p class="font-display font-bold text-sm" style="color: var(--text-primary);">Transfer Bank</p>
                        <p class="text-xs" style="color: var(--text-secondary);">Transfer langsung ke rekening</p>
                    </div>
                </label>

                <label class="flex items-center gap-4 p-4 rounded-xl cursor-pointer transition-all duration-150" style="border: 3px solid var(--border); box-shadow: 3px 3px 0 var(--border); background: var(--bg-secondary);"
                    :style="selected === 'e_wallet' ? 'border-color: var(--accent); background: rgba(0,229,255,0.08); box-shadow: 4px 4px 0 var(--accent-shadow);' : ''">
                    <input type="radio" name="payment_method" value="e_wallet" x-model="selected" class="hidden">
                    <div class="w-5 h-5 rounded-full border-[3px] flex items-center justify-center shrink-0" :style="selected === 'e_wallet' ? 'border-color: var(--accent)' : 'border-color: var(--border)'">
                        <div x-show="selected === 'e_wallet'" class="w-2.5 h-2.5 rounded-full" style="background: var(--accent);"></div>
                    </div>
                    <div class="flex-1">
                        <p class="font-display font-bold text-sm" style="color: var(--text-primary);">E-Wallet</p>
                        <p class="text-xs" style="color: var(--text-secondary);">Pilih penyedia e-wallet</p>
                    </div>
                </label>

                {{-- Dropdown E-Wallet --}}
                <div x-show="selected === 'e_wallet'" x-cloak x-transition class="ml-9">
                    <select name="e_wallet_provider" x-model="ew" class="nb-input py-2.5 text-sm" required>
                        <option value="">— Pilih E-Wallet —</option>
                        @foreach($ewallets as $key => $val)
                        <option value="{{ $key }}">{{ $val['name'] ?? ucfirst($key) }} {{ $val['number'] ? '✓' : '(belum diset)' }}</option>
                        @endforeach
                    </select>
                    @error('e_wallet_provider')<p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p>@enderror
                </div>
            </div>
            @error('payment_method')<p class="text-red-500 text-xs mt-2 font-bold">{{ $message }}</p>@enderror
        </div>

        <button type="submit" class="nb-btn-primary w-full py-4 text-base">
            Lanjut ke Pembayaran →
        </button>
    </form>
</div>
@endsection
