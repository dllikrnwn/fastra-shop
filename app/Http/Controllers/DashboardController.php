<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Game;
use App\Models\GameCategory;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $recentTransactions = Transaction::where('user_id', $user->id)
            ->with('game', 'denomination')
            ->latest()
            ->limit(5)
            ->get();

        $totalSpent = Transaction::where('user_id', $user->id)
            ->where('status', 'paid')
            ->sum('amount');

        $totalTransactions = Transaction::where('user_id', $user->id)->count();

        $featuredGames = Game::active()->featured()->with('category')->ordered()->limit(4)->get();

        return view('dashboard', compact('user', 'recentTransactions', 'totalSpent', 'totalTransactions', 'featuredGames'));
    }
}
