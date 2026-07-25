<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Game;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = \App\Models\User::count();
        $totalGames = Game::count();
        $totalTransactions = Transaction::count();
        $revenue = Transaction::where('status', 'paid')->sum('amount');
        $pendingCount = Transaction::where('status', 'awaiting_verification')->count();

        $revenuePerMonth = Transaction::where('status', 'paid')
            ->selectRaw("DATE_FORMAT(paid_at, '%Y-%m') as month, SUM(amount) as total")
            ->groupBy('month')
            ->orderBy('month')
            ->limit(12)
            ->pluck('total', 'month');

        $topGames = Transaction::where('status', 'paid')
            ->selectRaw("games.name as game_name, COUNT(*) as count, SUM(transactions.amount) as total")
            ->join('games', 'transactions.game_id', '=', 'games.id')
            ->groupBy('games.name')
            ->orderByDesc('count')
            ->limit(5)
            ->get();

        $recentTransactions = Transaction::with('game', 'denomination')
            ->where('status', 'awaiting_verification')
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers', 'totalGames', 'totalTransactions', 'revenue',
            'pendingCount', 'revenuePerMonth', 'topGames', 'recentTransactions'
        ));
    }
}
