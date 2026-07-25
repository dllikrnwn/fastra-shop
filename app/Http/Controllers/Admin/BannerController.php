<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::ordered()->get();
        return view('admin.banners.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.banners.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:4096',
            'link' => 'nullable|string|max:500',
            'bg_color' => 'required|in:accent,yellow,green,pink,purple,orange',
            'sort_order' => 'integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['image'] = $request->file('image')->store('banners', 'public');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        $validated['is_active'] = $request->boolean('is_active', true);

        Banner::create($validated);

        return redirect()->route('admin.banners.index')->with('success', 'Banner berhasil ditambahkan');
    }

    public function edit(Banner $banner)
    {
        return view('admin.banners.edit', compact('banner'));
    }

    public function update(Request $request, Banner $banner)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'link' => 'nullable|string|max:500',
            'bg_color' => 'required|in:accent,yellow,green,pink,purple,orange',
            'sort_order' => 'integer|min:0',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($banner->image) {
                Storage::disk('public')->delete($banner->image);
            }
            $validated['image'] = $request->file('image')->store('banners', 'public');
        }

        $validated['sort_order'] = $validated['sort_order'] ?? $banner->sort_order;
        $validated['is_active'] = $request->boolean('is_active', false);

        $banner->update($validated);

        return redirect()->route('admin.banners.index')->with('success', 'Banner berhasil diperbarui');
    }

    public function destroy(Banner $banner)
    {
        if ($banner->image) {
            Storage::disk('public')->delete($banner->image);
        }
        $banner->delete();

        return redirect()->route('admin.banners.index')->with('success', 'Banner berhasil dihapus');
    }
}
