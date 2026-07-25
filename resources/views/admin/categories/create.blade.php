@extends('layouts.admin')
@section('title', 'Tambah Kategori — Admin')

@section('slot')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex items-center gap-3 mb-8">
        <a href="{{ route('admin.categories.index') }}" class="nb-btn-ghost p-2">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" /></svg>
        </a>
        <h1 class="section-title">Tambah Kategori</h1>
    </div>

    <form method="POST" action="{{ route('admin.categories.store') }}" class="space-y-5">
        @csrf
        <div class="nb-card-static p-6 space-y-5">
            <div>
                <label class="block text-sm font-display font-bold mb-1.5" style="color: var(--text-primary);">Nama Kategori <span style="color: #FF4444;">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" class="nb-input" required placeholder="Contoh: Mobile">
                @error('name')<p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-display font-bold mb-1.5" style="color: var(--text-primary);">Icon</label>
                <input type="text" name="icon" value="{{ old('icon') }}" class="nb-input" placeholder="Contoh: smartphone">
                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Nama icon (opsional).</p>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-display font-bold mb-1.5" style="color: var(--text-primary);">Urutan</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" min="0" class="nb-input">
                </div>
                <div class="flex items-end pb-1">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', 1) ? 'checked' : '' }} class="w-4 h-4 rounded border-gray-300 dark:border-gray-600 text-accent focus:ring-accent/20">
                        <span class="text-sm font-bold" style="color: var(--text-primary);">Aktif</span>
                    </label>
                </div>
            </div>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.categories.index') }}" class="nb-btn-secondary flex-1">Batal</a>
            <button type="submit" class="nb-btn-primary flex-1">Simpan Kategori</button>
        </div>
    </form>
</div>
@endsection