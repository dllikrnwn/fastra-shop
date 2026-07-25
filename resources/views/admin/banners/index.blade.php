@extends('layouts.admin')
@section('title', 'Kelola Banner — Admin')

@section('slot')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex items-center gap-3 mb-8">
        <a href="{{ route('admin.dashboard') }}" class="nb-btn-ghost inline-flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" /></svg>
            Kembali
        </a>
        <div>
            <h1 class="section-title">Kelola Banner</h1>
            <p class="section-subtitle mt-1">Banner promo yang tampil di homepage</p>
        </div>
        <a href="{{ route('admin.banners.create') }}" class="nb-btn-primary ml-auto">+ Tambah</a>
    </div>

    <div class="nb-card-static overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm min-w-[600px]">
                <thead>
                    <tr style="border-bottom: 2px solid var(--border);">
                        <th class="text-left px-4 py-3 font-display font-bold" style="color: var(--text-secondary);">Banner</th>
                        <th class="text-left px-4 py-3 font-display font-bold" style="color: var(--text-secondary);">Warna</th>
                        <th class="text-left px-4 py-3 font-display font-bold" style="color: var(--text-secondary);">Link</th>
                        <th class="text-center px-4 py-3 font-display font-bold" style="color: var(--text-secondary);">Urutan</th>
                        <th class="text-center px-4 py-3 font-display font-bold" style="color: var(--text-secondary);">Aktif</th>
                        <th class="text-right px-4 py-3 font-display font-bold" style="color: var(--text-secondary);">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($banners as $banner)
                    <tr style="border-bottom: 1px solid var(--border);">
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                <img src="{{ asset('storage-files/' . $banner->image) }}" alt="{{ $banner->title }}" class="w-20 h-10 object-cover rounded-lg border-2" style="border-color: var(--border);">
                                <div>
                                    <p class="font-display font-bold" style="color: var(--text-primary);">{{ $banner->title }}</p>
                                    @if($banner->subtitle)<p class="text-xs" style="color: var(--text-secondary);">{{ $banner->subtitle }}</p>@endif
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3"><span class="inline-block w-6 h-6 rounded-lg" style="background: var(--neo-{{ $banner->bg_color }}); border: 2px solid var(--border);"></span></td>
                        <td class="px-4 py-3 text-xs font-mono" style="color: var(--text-secondary);">{{ $banner->link ?? '-' }}</td>
                        <td class="px-4 py-3 text-center" style="color: var(--text-secondary);">{{ $banner->sort_order }}</td>
                        <td class="px-4 py-3 text-center">
                            @if($banner->is_active) <span class="text-xs font-bold px-2 py-0.5 rounded-lg" style="background: var(--neo-green); color: #000; border: 2px solid var(--border);">ON</span>
                            @else <span class="text-xs font-bold px-2 py-0.5 rounded-lg" style="background: var(--neo-pink); color: #000; border: 2px solid var(--border);">OFF</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center justify-end gap-1">
                                <a href="{{ route('admin.banners.edit', $banner) }}" class="nb-btn-ghost px-2 py-1.5 text-xs">Edit</a>
                                <form method="POST" action="{{ route('admin.banners.destroy', $banner) }}" onsubmit="return confirm('Hapus banner ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="nb-btn-ghost px-2 py-1.5 text-xs" style="color: #FF4444;">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="px-4 py-12 text-center" style="color: var(--text-secondary);">Belum ada banner</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
