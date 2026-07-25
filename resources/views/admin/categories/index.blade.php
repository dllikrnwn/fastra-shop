@extends('layouts.admin')
@section('title', 'Kelola Kategori — Admin')

@section('slot')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex items-center gap-3 mb-8">
        <a href="{{ route('admin.dashboard') }}" class="nb-btn-ghost inline-flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" /></svg>
            Kembali
        </a>
        <div>
            <h1 class="section-title">Kelola Kategori</h1>
            <p class="section-subtitle mt-1">{{ $categories->count() }} kategori</p>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="nb-btn-primary ml-auto">+ Tambah Kategori</a>
    </div>

    <div class="nb-card-static overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr style="border-bottom: 2px solid var(--border);">
                        <th class="text-left px-4 py-3 font-display font-bold" style="color: var(--text-secondary);">Nama</th>
                        <th class="text-left px-4 py-3 font-display font-bold" style="color: var(--text-secondary);">Slug</th>
                        <th class="text-center px-4 py-3 font-display font-bold" style="color: var(--text-secondary);">Game</th>
                        <th class="text-center px-4 py-3 font-display font-bold" style="color: var(--text-secondary);">Urutan</th>
                        <th class="text-center px-4 py-3 font-display font-bold" style="color: var(--text-secondary);">Aktif</th>
                        <th class="text-right px-4 py-3 font-display font-bold" style="color: var(--text-secondary);">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y" style="border-color: var(--border);">
                    @forelse($categories as $cat)
                    <tr style="border-bottom: 1px solid var(--border);">
                        <td class="px-4 py-3 font-display font-bold" style="color: var(--text-primary);">{{ $cat->name }}</td>
                        <td class="px-4 py-3 text-gray-600 dark:text-gray-400 font-mono text-xs">{{ $cat->slug }}</td>
                        <td class="px-4 py-3 text-center text-gray-600 dark:text-gray-400">{{ $cat->games_count }}</td>
                        <td class="px-4 py-3 text-center text-gray-600 dark:text-gray-400">{{ $cat->sort_order }}</td>
                        <td class="px-4 py-3 text-center">
                            @if($cat->is_active)
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold" style="background: var(--neo-green); color: #000; border: 2px solid var(--border);">Aktif</span>
                            @else
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold" style="background: var(--neo-pink); color: #000; border: 2px solid var(--border);">Nonaktif</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center justify-end gap-1">
                                <a href="{{ route('admin.categories.edit', $cat) }}" class="nb-btn-ghost px-2 py-1.5 text-xs">Edit</a>
                                <form method="POST" action="{{ route('admin.categories.destroy', $cat) }}" onsubmit="return confirm('Yakin hapus kategori ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="nb-btn-ghost px-2 py-1.5 text-xs text-red-500 hover:bg-red-50 dark:hover:bg-red-500/10">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-12 text-center" style="color: var(--text-secondary);">Belum ada kategori</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
