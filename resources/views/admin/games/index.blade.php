@extends('layouts.admin')
@section('title', 'Kelola Game — Admin')

@section('slot')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex items-center gap-3 mb-8">
        <a href="{{ route('admin.dashboard') }}" class="nb-btn-ghost inline-flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" /></svg>
            Kembali
        </a>
        <div>
            <h1 class="section-title">Kelola Game</h1>
            <p class="section-subtitle mt-1">Total {{ $games->total() }} game</p>
        </div>
        <a href="{{ route('admin.games.create') }}" class="nb-btn-primary ml-auto">+ Tambah</a>
    </div>

    <div class="nb-card-static overflow-hidden">
        <div class="p-4" style="border-bottom: 2px solid var(--border);">
            <form method="GET" class="flex flex-wrap items-center gap-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari game..." class="nb-input py-2 text-sm flex-1 sm:max-w-sm">
                <button type="submit" class="nb-btn-secondary text-sm px-4 py-2">Cari</button>
                @if(request('search'))<a href="{{ route('admin.games.index') }}" class="nb-btn-ghost text-sm px-3 py-2">Reset</a>@endif
            </form>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm min-w-[640px]">
                <thead>
                    <tr style="border-bottom: 2px solid var(--border);">
                        <th class="text-left px-4 py-3 font-display font-bold" style="color: var(--text-secondary);">Game</th>
                        <th class="text-left px-4 py-3 font-display font-bold" style="color: var(--text-secondary);">Kategori</th>
                        <th class="text-center px-4 py-3 font-display font-bold" style="color: var(--text-secondary);">Harga</th>
                        <th class="text-center px-4 py-3 font-display font-bold" style="color: var(--text-secondary);">Featured</th>
                        <th class="text-center px-4 py-3 font-display font-bold" style="color: var(--text-secondary);">Aktif</th>
                        <th class="text-right px-4 py-3 font-display font-bold" style="color: var(--text-secondary);">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($games as $game)
                    <tr style="border-bottom: 1px solid var(--border);">
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg overflow-hidden border-2 flex items-center justify-center shrink-0" style="border-color: var(--border); background: var(--bg-secondary);">
                                    @if($game->image) <img src="{{ asset('storage/' . $game->image) }}" alt="" class="w-full h-full object-contain">
                                    @else <span class="font-display font-bold text-xs" style="color: var(--text-secondary);">{{ substr($game->name, 0, 2) }}</span>
                                    @endif
                                </div>
                                <div>
                                    <p class="font-display font-bold" style="color: var(--text-primary);">{{ $game->name }}</p>
                                    <p class="text-xs font-mono" style="color: var(--text-secondary);">{{ $game->slug }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3" style="color: var(--text-secondary);">{{ $game->category->name ?? '-' }}</td>
                        <td class="px-4 py-3 text-center" style="color: var(--text-secondary);">{{ $game->denominations->count() }} nominal</td>
                        <td class="px-4 py-3 text-center">
                            @if($game->is_featured) <span class="text-xs font-bold px-2 py-0.5 rounded-lg" style="background: var(--accent); color: #000; border: 2px solid var(--border);">YES</span> @else <span style="color: var(--text-secondary);">-</span> @endif
                        </td>
                        <td class="px-4 py-3 text-center">
                            @if($game->is_active) <span class="text-xs font-bold px-2 py-0.5 rounded-lg" style="background: var(--neo-green); color: #000; border: 2px solid var(--border);">ON</span> @else <span class="text-xs font-bold px-2 py-0.5 rounded-lg" style="background: var(--neo-pink); color: #000; border: 2px solid var(--border);">OFF</span> @endif
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center justify-end gap-1">
                                <a href="{{ route('admin.games.edit', $game) }}" class="nb-btn-ghost px-2 py-1.5 text-xs">Edit</a>
                                <form method="POST" action="{{ route('admin.games.destroy', $game) }}" onsubmit="return confirm('Hapus game ini? Game yang punya transaksi akan dinonaktifkan, bukan dihapus.')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="nb-btn-ghost px-2 py-1.5 text-xs" style="color: #FF4444;">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-12 text-center" style="color: var(--text-secondary);">Tidak ada game</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4" style="border-top: 2px solid var(--border);">{{ $games->links() }}</div>
    </div>
</div>
@endsection