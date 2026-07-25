<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminGameRequest;
use App\Models\Game;
use App\Models\GameCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class GameController extends Controller
{
    public function index(Request $request)
    {
        $query = Game::with('category');

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $games = $query->ordered()->paginate(15)->withQueryString();

        return view('admin.games.index', compact('games'));
    }

    public function create()
    {
        $categories = GameCategory::ordered()->get();
        return view('admin.games.create', compact('categories'));
    }

    public function store(AdminGameRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('games', 'public');
        }

        if ($request->hasFile('guide_video')) {
            $data['guide_video'] = $request->file('guide_video')->store('videos', 'public');
        }

        Game::create($data);

        return redirect()->route('admin.games.index')->with('success', 'Game berhasil ditambahkan');
    }

    public function edit(Game $game)
    {
        $categories = GameCategory::ordered()->get();
        return view('admin.games.edit', compact('game', 'categories'));
    }

    public function update(AdminGameRequest $request, Game $game)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($game->image) {
                Storage::disk('public')->delete($game->image);
            }
            $data['image'] = $request->file('image')->store('games', 'public');
        }

        if ($request->hasFile('guide_video')) {
            if ($game->guide_video) {
                Storage::disk('public')->delete($game->guide_video);
            }
            $data['guide_video'] = $request->file('guide_video')->store('videos', 'public');
        }

        $game->update($data);

        return redirect()->route('admin.games.index')->with('success', 'Game berhasil diperbarui');
    }

    public function destroy(Game $game)
    {
        $hasTransactions = $game->denominations()->whereHas('transactions')->exists();

        if ($hasTransactions) {
            $game->update(['is_active' => false]);
            $game->denominations()->update(['is_active' => false]);
            return redirect()->route('admin.games.index')->with('success', 'Game dinonaktifkan karena masih memiliki transaksi');
        }

        if ($game->image) {
            Storage::disk('public')->delete($game->image);
        }
        if ($game->guide_video) {
            Storage::disk('public')->delete($game->guide_video);
        }
        $game->denominations()->delete();
        $game->delete();

        return redirect()->route('admin.games.index')->with('success', 'Game berhasil dihapus');
    }
}
