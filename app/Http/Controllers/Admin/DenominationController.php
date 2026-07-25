<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminDenominationRequest;
use App\Models\Denomination;
use App\Models\Game;
use Illuminate\Http\Request;

class DenominationController extends Controller
{
    public function index(Request $request)
    {
        $query = Denomination::with('game');

        if ($request->game_id) {
            $query->where('game_id', $request->game_id);
        }

        $denominations = $query->ordered()->paginate(20)->withQueryString();
        $games = Game::ordered()->get();

        return view('admin.denominations.index', compact('denominations', 'games'));
    }

    public function create()
    {
        $games = Game::ordered()->get();
        return view('admin.denominations.create', compact('games'));
    }

    public function store(AdminDenominationRequest $request)
    {
        Denomination::create($request->validated());

        return redirect()->route('admin.denominations.index')->with('success', 'Harga berhasil ditambahkan');
    }

    public function edit(Denomination $denomination)
    {
        $games = Game::ordered()->get();
        $denomination->load('game');
        return view('admin.denominations.edit', compact('denomination', 'games'));
    }

    public function update(AdminDenominationRequest $request, Denomination $denomination)
    {
        $denomination->update($request->validated());

        return redirect()->route('admin.denominations.index')->with('success', 'Harga berhasil diperbarui');
    }

    public function destroy(Denomination $denomination)
    {
        if ($denomination->transactions()->exists()) {
            $denomination->update(['is_active' => false]);
            return redirect()->route('admin.denominations.index')->with('success', 'Harga dinonaktifkan karena masih memiliki transaksi');
        }

        $denomination->delete();

        return redirect()->route('admin.denominations.index')->with('success', 'Harga berhasil dihapus');
    }
}
