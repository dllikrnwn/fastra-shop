<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\GameCategory;
use App\Models\Banner;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredGames = Game::active()->featured()->with('category')->ordered()->limit(6)->get();
        $categories = GameCategory::active()->ordered()->get();
        $latestGames = Game::active()->with('category', 'denominations')->ordered()->limit(12)->get();
        $banners = Banner::active()->ordered()->limit(5)->get();

        return view('home', compact('featuredGames', 'categories', 'latestGames', 'banners'));
    }
}
