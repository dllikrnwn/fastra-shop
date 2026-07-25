@extends('layouts.admin')
@section('title', 'Kelola Harga — Admin')

@section('slot')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex items-center gap-3 mb-8">
        <a href="{{ route('admin.dashboard') }}" class="nb-btn-ghost inline-flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" /></svg>
            Kembali
        </a>
        <div>
            <h1 class="section-title">Kelola Harga</h1>
            <p class="section-subtitle mt-1">Nominal & harga per game</p>
        </div>
        <a href="{{ route('admin.denominations.create') }}" class="nb-btn-primary ml-auto">+ Tambah Harga</a>
    </div>

    <div class="nb-card-static overflow-hidden">
        <div class="p-4" style="border-bottom: 2px solid var(--border);">
            <form method="GET" class="flex items-center gap-2">
                <select name="game_id" class="nb-input py-2 text-sm flex-1 max-w-sm">
                    <option value="">Semua Game</option>
                    @foreach($games as $g)
                    <option value="{{ $g->id }}" {{ request('game_id') == $g->id ? 'selected' : '' }}>{{ $g->name }}</option>
                    @endforeach
                </select>
                <button type="submit" class="nb-btn-secondary text-sm px-4 py-2">Filter</button>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr style="border-bottom: 2px solid var(--border);">
                        <th class="text-left px-4 py-3 font-display font-bold" style="color: var(--text-secondary);">Game</th>
                        <th class="text-left px-4 py-3 font-display font-bold" style="color: var(--text-secondary);">Nama</th>
                        <th class="text-left px-4 py-3 font-display font-bold" style="color: var(--text-secondary);">Nominal</th>
                        <th class="text-right px-4 py-3 font-display font-bold" style="color: var(--text-secondary);">Harga</th>
                        <th class="text-center px-4 py-3 font-display font-bold" style="color: var(--text-secondary);">Aktif</th>
                        <th class="text-right px-4 py-3 font-display font-bold" style="color: var(--text-secondary);">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y" style="border-color: var(--border);">
                    @forelse($denominations as $d)
                    <tr style="border-bottom: 1px solid var(--border);">
                        <td class="px-4 py-3 font-display font-bold" style="color: var(--text-primary);">{{ $d->game->name ?? '-' }}</td>
                        <td class="px-4 py-3 text-gray-600 dark:text-gray-400">{{ $d->name }}</td>
                        <td class="px-4 py-3 text-gray-600 dark:text-gray-400">{{ $d->nominal }}</td>
                        <td class="px-4 py-3 text-right font-mono font-semibold" style="color: var(--accent);">{{ $d->formatted_price }}</td>
                        <td class="px-4 py-3 text-center">
                            @if($d->is_active)
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold" style="background: var(--neo-green); color: #000; border: 2px solid var(--border);">Aktif</span>
                            @else
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold" style="background: var(--neo-pink); color: #000; border: 2px solid var(--border);">Nonaktif</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center justify-end gap-1">
                                <a href="{{ route('admin.denominations.edit', $d) }}" class="nb-btn-ghost px-2 py-1.5 text-xs">Edit</a>
                                <form method="POST" action="{{ route('admin.denominations.destroy', $d) }}" onsubmit="return confirm('Yakin hapus nominal ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="nb-btn-ghost px-2 py-1.5 text-xs text-red-500 hover:bg-red-50 dark:hover:bg-red-500/10">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-12 text-center" style="color: var(--text-secondary);">Tidak ada data harga</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4" style="border-top: 2px solid var(--border);">{{ $denominations->links() }}</div>
    </div>
</div>
@endsection