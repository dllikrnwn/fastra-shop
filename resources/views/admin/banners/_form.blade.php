<div>
    <label class="block text-sm font-display font-bold mb-1.5" style="color: var(--text-primary);">Judul Banner <span style="color: #FF4444;">*</span></label>
    <input type="text" name="title" value="{{ old('title', $banner->title ?? '') }}" class="nb-input" required placeholder="Contoh: PROMO MINGGU INI!">
</div>
<div>
    <label class="block text-sm font-display font-bold mb-1.5" style="color: var(--text-primary);">Sub Judul</label>
    <input type="text" name="subtitle" value="{{ old('subtitle', $banner->subtitle ?? '') }}" class="nb-input" placeholder="Contoh: Diskon 20% semua game">
</div>
<div>
    <label class="block text-sm font-display font-bold mb-1.5" style="color: var(--text-primary);">Gambar Banner <span style="color: #FF4444;">{{ isset($banner) && $banner->image ? '' : '*' }}</span></label>
    @if(isset($banner) && $banner->image)
    <div class="mb-3"><img src="{{ asset('storage/' . $banner->image) }}" alt="" class="w-full h-24 object-cover rounded-lg border-[3px]" style="border-color: var(--border);"></div>
    @endif
    <input type="file" name="image" accept="image/*" class="nb-input file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-[2px] file:border-black file:text-sm file:font-bold file:cursor-pointer" {{ isset($banner) ? '' : 'required' }}>
    <p class="text-xs mt-1" style="color: var(--text-secondary);">Format: JPG, PNG, WebP. Maks 4MB. Rasio 3:1 disarankan.</p>
</div>
<div>
    <label class="block text-sm font-display font-bold mb-1.5" style="color: var(--text-primary);">Link (opsional)</label>
    <input type="text" name="link" value="{{ old('link', $banner->link ?? '') }}" class="nb-input" placeholder="URL tujuan saat banner diklik">
</div>
<div class="grid grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-display font-bold mb-1.5" style="color: var(--text-primary);">Warna Background <span style="color: #FF4444;">*</span></label>
        <select name="bg_color" class="nb-input" required>
            @foreach(['accent' => 'Cyan (#00E5FF)', 'yellow' => 'Yellow (#FFE500)', 'green' => 'Green (#00E676)', 'pink' => 'Pink (#FF6B6B)', 'purple' => 'Purple (#BB86FC)', 'orange' => 'Orange (#FF9100)'] as $k => $v)
            <option value="{{ $k }}" {{ old('bg_color', $banner->bg_color ?? '') == $k ? 'selected' : '' }}>{{ $v }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block text-sm font-display font-bold mb-1.5" style="color: var(--text-primary);">Urutan</label>
        <input type="number" name="sort_order" value="{{ old('sort_order', $banner->sort_order ?? 0) }}" min="0" class="nb-input">
    </div>
</div>
<label class="flex items-center gap-2 cursor-pointer">
    <input type="hidden" name="is_active" value="0">
    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $banner->is_active ?? 1) ? 'checked' : '' }} class="w-4 h-4 accent-[#00E5FF]">
    <span class="text-sm font-bold" style="color: var(--text-primary);">Tampilkan di Homepage</span>
</label>