<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\GameCategory;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function index(Request $request)
    {
        $query = Game::active()->with('category', 'denominations');

        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }

        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $sort = $request->get('sort', 'default');
        switch ($sort) {
            case 'newest': $query->latest(); break;
            case 'name_asc': $query->orderBy('name'); break;
            case 'name_desc': $query->orderBy('name', 'desc'); break;
            default: $query->ordered();
        }

        $games = $query->paginate(12)->withQueryString();
        $categories = GameCategory::active()->ordered()->get();

        return view('games.index', compact('games', 'categories'));
    }

    public function show($slug)
    {
        $game = Game::active()->where('slug', $slug)
            ->with(['category', 'denominations' => fn($q) => $q->active()->ordered()])
            ->firstOrFail();

        return view('games.show', compact('game'));
    }
}
