@extends('layouts.app')

@section('title', 'Fastra Shop — Topup Game Cepat & Aman')

@section('head')
<style>
    .hero-bg {
        background: var(--bg-primary);
        position: relative;
        overflow: hidden;
    }
    .hero-bg::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -20%;
        width: 150%;
        height: 200%;
        background: repeating-linear-gradient(90deg, transparent, transparent 40px, var(--border) 40px, var(--border) 41px);
        opacity: 0.05;
        transform: rotate(-3deg);
    }
    .hero-bg::after {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 50%;
        height: 100%;
        background: linear-gradient(135deg, transparent 40%, rgba(0,229,255,0.06) 100%);
    }
</style>
@endsection

@section('slot')
{{-- HERO --}}
<section class="hero-bg relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 pb-20 md:pt-24 md:pb-28 relative z-10">
        <div class="flex flex-col lg:flex-row items-center gap-10">
            <div class="flex-1 text-center lg:text-left">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 font-display font-bold text-xs tracking-widest uppercase mb-6 nb-card-static animate-in" style="box-shadow: 2px 2px 0 var(--accent-shadow);">
                    Topup Game Terpercaya
                </div>
                <h1 class="font-display font-black text-5xl md:text-6xl lg:text-7xl leading-[0.95] tracking-tight mb-6 animate-in-delay-1" style="color: var(--text-primary);">
                    Topup Game<br>
                    <span style="color: var(--accent);">Cepat &</span><br>
                    <span style="color: var(--accent);">Aman</span>
                </h1>
                <p class="text-base md:text-lg max-w-lg lg:mx-0 mx-auto leading-relaxed mb-8 animate-in-delay-2" style="color: var(--text-secondary);">
                    Nikmati kemudahan topup game favoritmu dengan proses cepat, harga terbaik, dan pembayaran yang aman.
                </p>
                <div class="flex flex-col sm:flex-row items-center gap-3 justify-center lg:justify-start animate-in-delay-3">
                    <a href="#games" class="nb-btn-primary text-base px-8 py-4">
                        Lihat Game →
                    </a>
                    <a href="#how-it-works" class="nb-btn-secondary">
                        Cara Beli
                    </a>
                </div>

                {{-- Search --}}
                <div class="mt-6 animate-in-delay-3" x-data="{ q: '' }">
                    <form action="{{ route('games.index') }}" method="GET" class="flex items-center gap-2 max-w-md lg:mx-0 mx-auto">
                        <div class="relative flex-1">
                            <input type="text" name="search" x-model="q" placeholder="Cari game..." class="nb-input py-2.5 pl-3 pr-9 text-sm" minlength="2">
                            <svg class="w-4 h-4 absolute right-3 top-1/2 -translate-y-1/2" style="color: var(--text-secondary);" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" /></svg>
                        </div>
                        <button type="submit" class="nb-btn-ghost p-2.5 shrink-0" :disabled="q.length < 2">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" /></svg>
                        </button>
                    </form>
                </div>
            </div>
            <div class="flex-1 flex justify-center">
                <div class="relative">
                    <div class="nb-card-static w-64 h-64 md:w-80 md:h-80 flex items-center justify-center relative" style="transform: rotate(3deg);">
                        <img src="{{ asset('images/logo.png') }}" alt="Fastra Shop Logo" class="w-40 h-40 md:w-52 md:h-52 object-contain animate-float">
                        <div class="absolute -top-4 -right-4 nb-card-static px-3 py-1.5 text-xs font-display font-bold flex items-center gap-1" style="background: var(--neo-yellow); color: #000; box-shadow: 2px 2px 0 var(--border);">
                            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="currentColor"><path d="M13.5 2.25c.388 0 .742.22.905.584l3.25 7.5a.75.75 0 01-.155.858l-9 9A.75.75 0 017.5 19l1.5-7.5H6.75a.75.75 0 01-.658-1.094l4.5-9A.75.75 0 0111.25.75h2.25z"/></svg>
                            FLASH TOPUP
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- BANNER PROMO --}}
@if($banners->isNotEmpty())
<section class="py-6" x-data="bannerSlider()">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="relative nb-card-static overflow-hidden transition-all duration-200 hover:scale-[1.01] hover:-translate-y-0.5" style="border-color: var(--border); box-shadow: 3px 3px 0 var(--border);">
            <div class="flex transition-transform duration-500" :style="'transform: translateX(-' + (current * 100) + '%)'">
                @foreach($banners as $banner)
                <a href="{{ $banner->link ?: '#' }}" class="w-full shrink-0">
                    <div class="overflow-hidden" style="aspect-ratio: 3/1;">
                        <img src="{{ asset('storage/' . $banner->image) }}" alt="{{ $banner->title }}" class="w-full h-full object-cover transition-transform duration-500 hover:scale-105">
                    </div>
                </a>
                @endforeach
            </div>
            @if($banners->count() > 1)
            <button @click="prev()" class="absolute left-3 top-1/2 -translate-y-1/2 w-10 h-10 flex items-center justify-center font-bold text-lg" style="background: var(--bg-secondary); border: 2px solid var(--border); border-radius: 8px;">←</button>
            <button @click="next()" class="absolute right-3 top-1/2 -translate-y-1/2 w-10 h-10 flex items-center justify-center font-bold text-lg" style="background: var(--bg-secondary); border: 2px solid var(--border); border-radius: 8px;">→</button>
            <div class="absolute bottom-3 left-1/2 -translate-x-1/2 flex gap-2">
                @foreach($banners as $i => $b)
                <button @click="current = {{ $i }}" class="w-3 h-3 rounded-full transition-all" :style="current === {{ $i }} ? 'background: var(--accent); border: 2px solid var(--border);' : 'background: rgba(255,255,255,0.5);'"></button>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</section>
@endif

{{-- CATEGORIES --}}
<section class="py-6 border-b-[3px]" style="border-color: var(--border);">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-wrap items-center justify-center gap-2 reveal reveal-stagger">
            <a href="{{ route('games.index') }}" class="px-5 py-2.5 rounded-lg text-sm font-display font-bold transition-all active:scale-95" style="background: var(--accent); color: #000; border: 3px solid var(--border); box-shadow: 3px 3px 0 var(--border);">
                Semua Game
            </a>
            @foreach($categories as $category)
            <a href="{{ route('games.index', ['category' => $category->id]) }}" class="px-5 py-2.5 rounded-lg text-sm font-display font-bold transition-all active:scale-95" style="background: var(--bg-secondary); color: var(--text-primary); border: 3px solid var(--border); box-shadow: 3px 3px 0 var(--border);">
                {{ $category->name }}
            </a>
            @endforeach
        </div>
    </div>
</section>

{{-- FEATURED GAMES --}}
<section id="games" class="py-16 md:py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-end justify-between mb-10 reveal">
            <div>
                <h2 class="section-title">Game Populer</h2>
                <p class="section-subtitle mt-2">Paling laris di Fastra Shop</p>
            </div>
            <a href="{{ route('games.index') }}" class="nb-btn-ghost hidden sm:inline-flex">Lihat Semua →</a>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-3 lg:grid-cols-6 gap-4 reveal reveal-stagger">
            @forelse($featuredGames as $game)
            <a href="{{ route('games.show', $game->slug) }}" class="group">
                <div class="game-card">
                    <div class="aspect-square flex items-center justify-center p-4 overflow-hidden" style="background: var(--bg-secondary);">
                        @if($game->image)
                            <img loading="lazy" src="{{ asset('storage/' . $game->image) }}" alt="{{ $game->name }}" class="w-full h-full object-contain transition-transform duration-300 group-hover:scale-110">
                        @else
                            <div class="text-5xl font-display font-black" style="color: var(--text-secondary);">{{ substr($game->name, 0, 2) }}</div>
                        @endif
                    </div>
                </div>
                <div class="mt-3 px-1">
                    <p class="font-display font-bold text-sm" style="color: var(--text-primary);">{{ $game->name }}</p>
                    @if($game->denominations->isNotEmpty())
                    <p class="text-xs font-mono font-bold mt-0.5" style="color: var(--accent);">Mulai {{ $game->denominations->sortBy('price')->first()->formatted_price }}</p>
                    @endif
                </div>
            </a>
            @empty
            <div class="col-span-full text-center py-12 nb-card-static" style="border-color: var(--border);">
                <p class="font-display font-bold" style="color: var(--text-secondary);">Belum ada game tersedia</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

{{-- ALL GAMES --}}
<section class="py-16 md:py-24 border-t-[3px]" style="border-color: var(--border);">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-10 reveal">
            <h2 class="section-title">Semua Game</h2>
            <p class="section-subtitle mt-2">Tersedia berbagai pilihan untuk kamu</p>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4 reveal reveal-stagger">
            @forelse($latestGames as $game)
            <a href="{{ route('games.show', $game->slug) }}" class="group">
                <div class="game-card">
                    <div class="aspect-square flex items-center justify-center p-4 overflow-hidden" style="background: var(--bg-secondary);">
                        @if($game->image)
                            <img loading="lazy" src="{{ asset('storage/' . $game->image) }}" alt="{{ $game->name }}" class="w-full h-full object-contain transition-transform duration-300 group-hover:scale-110">
                        @else
                            <div class="text-4xl font-display font-black" style="color: var(--text-secondary);">{{ substr($game->name, 0, 2) }}</div>
                        @endif
                    </div>
                </div>
                <div class="mt-3 px-1">
                    <p class="font-display font-bold text-sm" style="color: var(--text-primary);">{{ $game->name }}</p>
                </div>
            </a>
            @empty
            <div class="col-span-full text-center py-12 nb-card-static" style="border-color: var(--border);">
                <p class="font-display font-bold" style="color: var(--text-secondary);">Belum ada game tersedia</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

{{-- HOW IT WORKS --}}
<section id="how-it-works" class="py-16 md:py-24 border-t-[3px] border-b-[3px]" style="border-color: var(--border); background: var(--bg-secondary);">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-lg mx-auto mb-14 reveal">
            <h2 class="section-title">Cara Beli</h2>
            <p class="section-subtitle mt-2">3 langkah, langsung masuk</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 reveal reveal-stagger">
            <div class="nb-card-static p-8 text-center relative">
                <div class="w-16 h-16 font-display font-black text-2xl flex items-center justify-center mb-4" style="background: var(--accent); color: #000; border: 3px solid var(--border); box-shadow: 3px 3px 0 var(--border);">1</div>
                <h3 class="font-display font-bold text-lg mb-2" style="color: var(--text-primary);">Pilih Game</h3>
                <p class="text-sm leading-relaxed" style="color: var(--text-secondary);">Cari game favoritmu dari daftar game yang tersedia</p>
            </div>
            <div class="nb-card-static p-8 text-center relative">
                <div class="w-16 h-16 font-display font-black text-2xl flex items-center justify-center mb-4" style="background: var(--neo-yellow); color: #000; border: 3px solid var(--border); box-shadow: 3px 3px 0 var(--border);">2</div>
                <h3 class="font-display font-bold text-lg mb-2" style="color: var(--text-primary);">Pilih Nominal</h3>
                <p class="text-sm leading-relaxed" style="color: var(--text-secondary);">Pilih nominal topup yang sesuai dengan kebutuhanmu</p>
            </div>
            <div class="nb-card-static p-8 text-center relative">
                <div class="w-16 h-16 font-display font-black text-2xl flex items-center justify-center mb-4" style="background: var(--neo-green); color: #000; border: 3px solid var(--border); box-shadow: 3px 3px 0 var(--border);">3</div>
                <h3 class="font-display font-bold text-lg mb-2" style="color: var(--text-primary);">Bayar & Nikmati</h3>
                <p class="text-sm leading-relaxed" style="color: var(--text-secondary);">Bayar dengan metode favoritmu, saldo langsung masuk</p>
            </div>
        </div>
    </div>
</section>

@section('scripts')
<script>
function bannerSlider() {
    return {
        current: 0,
        total: {{ $banners->count() ?? 0 }},
        next() { this.current = (this.current + 1) % this.total; },
        prev() { this.current = (this.current - 1 + this.total) % this.total; },
        init() { if (this.total > 1) { setInterval(() => this.next(), 5000); } }
    };
}
</script>
@endsection
@endsection
