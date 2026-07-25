<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminCategoryRequest;
use App\Models\GameCategory;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = GameCategory::withCount('games')->ordered()->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(AdminCategoryRequest $request)
    {
        GameCategory::create($request->validated());

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil ditambahkan');
    }

    public function edit(GameCategory $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(AdminCategoryRequest $request, GameCategory $category)
    {
        $category->update($request->validated());

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil diperbarui');
    }

    public function destroy(GameCategory $category)
    {
        if ($category->games()->exists()) {
            return redirect()->route('admin.categories.index')->with('error', 'Kategori tidak bisa dihapus karena masih memiliki game');
        }

        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil dihapus');
    }
}
