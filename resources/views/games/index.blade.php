@extends('layouts.app')
@section('title', 'Semua Game — Fastra Shop')

@section('slot')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-16">
    <div class="mb-10">
        <h1 class="section-title">Semua Game</h1>
        <p class="section-subtitle mt-2">Pilih game favoritmu dan topup sekarang</p>
    </div>

    <div class="mb-8 pb-6 space-y-4" style="border-bottom: 3px solid var(--border);" x-data="gameFilter()">
        <div class="flex flex-wrap items-center gap-2">
            <a href="{{ route('games.index') }}" class="px-4 py-2 rounded-lg text-sm font-display font-bold transition-all active:scale-95" style="background: var(--accent); color: #000; border: 3px solid var(--border); box-shadow: 2px 2px 0 var(--border);">Semua</a>
            @foreach($categories as $category)
            <a href="{{ route('games.index', ['category' => $category->id] + (request()->has('search') ? ['search' => request('search')] : [])) }}" class="px-4 py-2 rounded-lg text-sm font-display font-bold transition-all active:scale-95" style="background: var(--bg-secondary); color: var(--text-primary); border: 3px solid var(--border); box-shadow: 2px 2px 0 var(--border);">
                {{ $category->name }}
            </a>
            @endforeach
        </div>
        <div class="flex flex-wrap items-center gap-3">
            <div class="relative flex-1 max-w-sm">
                <input type="text" placeholder="Cari game..." x-model="searchQuery" @input.debounce.400ms="filterGames()" class="nb-input py-2 px-3 pr-8 text-sm">
                <svg class="w-4 h-4 absolute right-3 top-1/2 -translate-y-1/2" style="color: var(--text-secondary);" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" /></svg>
            </div>
            <select x-model="sortBy" @change="filterGames()" class="nb-input py-2 text-sm w-44">
                <option value="default">Urutkan: Default</option>
                <option value="newest">Terbaru</option>
                <option value="name_asc">A → Z</option>
                <option value="name_desc">Z → A</option>
                <option value="price_asc">Termurah</option>
                <option value="price_desc">Termahal</option>
            </select>
        </div>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
        @forelse($games as $game)
        <a href="{{ route('games.show', $game->slug) }}" class="group">
            <div class="game-card">
                <div class="aspect-square flex items-center justify-center p-4 overflow-hidden" style="background: var(--bg-secondary);">
                    @if($game->image)
                        <img loading="lazy" src="{{ asset('storage-files/' . $game->image) }}" alt="{{ $game->name }}" class="w-full h-full object-contain transition-transform duration-300 group-hover:scale-110">
                    @else
                        <div class="text-4xl font-display font-black" style="color: var(--text-secondary);">{{ substr($game->name, 0, 2) }}</div>
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
        <div class="col-span-full text-center py-16 nb-card-static" style="border-color: var(--border);">
            <p class="font-display font-bold text-lg" style="color: var(--text-secondary);">Tidak ada game ditemukan</p>
            <p class="text-sm mt-1" style="color: var(--text-secondary);">Coba ubah filter atau kata kunci pencarian</p>
        </div>
        @endforelse
    </div>

    <div class="mt-10">{{ $games->links() }}</div>
</div>
@endsection

@section('scripts')
<script>
    function gameFilter() {
        return {
            searchQuery: '{{ request('search') }}',
            sortBy: '{{ request('sort', 'default') }}',
            filterGames() {
                const url = new URL(window.location);
                if (this.searchQuery) url.searchParams.set('search', this.searchQuery);
                else url.searchParams.delete('search');
                if (this.sortBy !== 'default') url.searchParams.set('sort', this.sortBy);
                else url.searchParams.delete('sort');
                window.location = url.toString();
            }
        };
    }
</script>
@endsection
