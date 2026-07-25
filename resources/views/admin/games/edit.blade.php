@extends('layouts.admin')
@section('title', 'Edit Game — Admin')

@section('slot')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex items-center gap-3 mb-8">
        <a href="{{ route('admin.games.index') }}" class="nb-btn-ghost p-2">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" /></svg>
        </a>
        <h1 class="section-title">Edit: {{ $game->name }}</h1>
    </div>

    <form method="POST" action="{{ route('admin.games.update', $game) }}" enctype="multipart/form-data" class="space-y-5">
        @csrf @method('PUT')
        <div class="nb-card-static p-6 space-y-5">
            <div>
                <label class="block text-sm font-display font-bold mb-1.5" style="color: var(--text-primary);">Nama Game *</label>
                <input type="text" name="name" value="{{ old('name', $game->name) }}" class="nb-input" required>
                @error('name')<p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-display font-bold mb-1.5" style="color: var(--text-primary);">Kategori *</label>
                <select name="category_id" class="nb-input" required>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ old('category_id', $game->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
                @error('category_id')<p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-display font-bold mb-1.5" style="color: var(--text-primary);">Gambar</label>
                @if($game->image)
                <div class="mb-3">
                    <img src="{{ asset('storage-files/' . $game->image) }}" alt="" class="w-20 h-20 object-contain rounded-lg border-[3px] p-2" style="border-color: var(--border); background: var(--bg-secondary);">
                </div>
                @endif
                <input type="file" name="image" accept="image/*" class="nb-input file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-[2px] file:border-black file:text-sm file:font-bold file:cursor-pointer">
                <p class="text-xs mt-1" style="color: var(--text-secondary);">Kosongkan jika tidak ingin mengganti gambar.</p>
            </div>
            <div>
                <label class="block text-sm font-display font-bold mb-1.5" style="color: var(--text-primary);">Video Tutorial Game Pass</label>
                @if($game->guide_video)
                <div class="mb-3">
                    <video class="w-full max-w-xs rounded-lg border-[3px]" style="border-color: var(--border);" controls>
                        <source src="{{ asset('storage-files/' . $game->guide_video) }}" type="video/mp4">
                    </video>
                </div>
                @endif
                <input type="file" name="guide_video" accept="video/mp4,video/webm" class="nb-input file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-[2px] file:border-black file:text-sm file:font-bold file:cursor-pointer">
                <p class="text-xs mt-1" style="color: var(--text-secondary);">Format: MP4, WebM. Maks 50MB. Kosongkan jika tidak ingin mengganti.</p>
            </div>
            <div>
                <label class="block text-sm font-display font-bold mb-1.5" style="color: var(--text-primary);">Deskripsi</label>
                <textarea name="description" class="nb-input" rows="3">{{ old('description', $game->description) }}</textarea>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-display font-bold mb-1.5" style="color: var(--text-primary);">Urutan</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', $game->sort_order) }}" min="0" class="nb-input">
                </div>
                <div class="flex items-end gap-6 pb-1">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="hidden" name="is_featured" value="0">
                        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $game->is_featured) ? 'checked' : '' }} class="w-4 h-4 accent-[#00E5FF]">
                        <span class="text-sm font-bold" style="color: var(--text-primary);">Featured</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $game->is_active) ? 'checked' : '' }} class="w-4 h-4 accent-[#00E5FF]">
                        <span class="text-sm font-bold" style="color: var(--text-primary);">Aktif</span>
                    </label>
                </div>
            </div>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.games.index') }}" class="nb-btn-secondary flex-1">Batal</a>
            <button type="submit" class="nb-btn-primary flex-1">Update Game</button>
        </div>
    </form>
</div>
@endsection
