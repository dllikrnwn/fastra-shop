<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Denomination;
use App\Models\Transaction;
use App\Mail\TransactionCreated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class TransactionController extends Controller
{
    public function checkout(Game $game, Denomination $denomination)
    {
        if (auth()->check() && auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard')->with('error', 'Admin tidak dapat melakukan pembelian.');
        }

        abort_unless($game->is_active && $denomination->is_active && $denomination->game_id === $game->id, 404);
        $game->load('category');

        return view('checkout', compact('game', 'denomination'));
    }

    public function checkoutCustom(Game $game, $quantity)
    {
        if (auth()->check() && auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard')->with('error', 'Admin tidak dapat melakukan pembelian.');
        }

        abort_unless($game->is_active && $game->has_custom_amount, 404);

        $quantity = max(1, (int) $quantity);

        // Calculate price using the same logic as the frontend
        $denominations = $game->denominations()->active()->ordered()->get();
        $price = $this->calculateCustomPrice($quantity, $denominations);

        // Create virtual denomination for checkout
        $denomination = new Denomination();
        $denomination->id = 0;
        $denomination->game_id = $game->id;
        $denomination->name = $quantity . ' ' . $game->name;
        $denomination->nominal = (string) $quantity;
        $denomination->price = $price;
        $denomination->is_active = true;

        return view('checkout', compact('game', 'denomination', 'quantity'));
    }

    private function calculateCustomPrice(int $quantity, $denominations): int
    {
        $best = null;
        foreach ($denominations as $d) {
            $q = (int) preg_replace('/[^0-9]/', '', $d->nominal);
            if ($q <= $quantity) $best = $d;
        }

        if ($best) {
            $exact = $denominations->first(fn($d) => (int) preg_replace('/[^0-9]/', '', $d->nominal) === $quantity);
            if ($exact) return (int) $exact->price;
            $rate = (int) round($best->price / max(1, (int) preg_replace('/[^0-9]/', '', $best->nominal)));
            return $quantity * $rate;
        }

        return $quantity * 500; // fallback rate
    }

    public function process(Request $request, Game $game, Denomination $denomination)
    {
        if (auth()->check() && auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard')->with('error', 'Admin tidak dapat melakukan pembelian.');
        }

        abort_unless($game->is_active && $denomination->is_active && $denomination->game_id === $game->id, 404);

        $validated = $request->validate([
            'game_nickname' => 'required|string|max:255',
            'buyer_name' => 'required|string|max:255',
            'buyer_email' => 'required|email|max:255',
            'buyer_phone' => 'nullable|string|max:20',
            'payment_method' => 'required|string|in:qris,bank_transfer,e_wallet',
        ]);

        $user = auth()->user();
        if ($user && $user->isAdmin()) {
            return redirect()->route('admin.dashboard')->with('error', 'Admin tidak dapat melakukan pembelian.');
        }

        $customQuantity = null;
        $amount = $denomination->price;

        if ($request->has('custom_quantity') && $request->custom_quantity) {
            $customQuantity = (int) $request->custom_quantity;
            $denominations = $game->denominations()->active()->ordered()->get();
            $amount = $this->calculateCustomPrice($customQuantity, $denominations);
        }

        $transaction = Transaction::create([
            'user_id' => auth()->id(),
            'game_id' => $game->id,
            'denomination_id' => $denomination->id ?: null,
            'game_nickname' => $validated['game_nickname'],
            'custom_quantity' => $customQuantity,
            'buyer_name' => $validated['buyer_name'],
            'buyer_email' => $validated['buyer_email'],
            'buyer_phone' => $validated['buyer_phone'] ?? null,
            'amount' => $amount,
            'payment_method' => $validated['payment_method'],
            'status' => 'pending',
        ]);

        try {
            Mail::to($validated['buyer_email'])->send(new TransactionCreated($transaction));
        } catch (\Exception $e) {
        }

        return redirect()->route('payment.manual', $transaction)
            ->with('success', 'Transaksi berhasil dibuat! Silakan lakukan pembayaran.');
    }

    public function index()
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Silakan login untuk melihat riwayat transaksi.');
        }

        $transactions = Transaction::where('user_id', auth()->id())
            ->with('game', 'denomination')
            ->latest()
            ->paginate(10);

        return view('transactions.index', compact('transactions'));
    }

    public function track()
    {
        return view('transactions.track');
    }

    public function lookup(Request $request)
    {
        $validated = $request->validate(['invoice' => 'required|string|max:100']);

        $transaction = Transaction::where('invoice', $validated['invoice'])
            ->with('game', 'denomination')
            ->first();

        if (!$transaction) {
            return back()->withInput()->with('error', 'Invoice tidak ditemukan. Periksa kembali nomor invoice.');
        }

        return view('transactions.track', compact('transaction'));
    }

    public function show($invoice)
    {
        $transaction = Transaction::where('invoice', $invoice)
            ->with('game', 'denomination')
            ->firstOrFail();

        $owner = false;
        if (auth()->check() && auth()->id() === $transaction->user_id) {
            $owner = true;
        }

        return view('transactions.show', compact('transaction', 'owner'));
    }

    public function receipt($invoice)
    {
        $transaction = Transaction::where('invoice', $invoice)
            ->with('game', 'denomination')
            ->firstOrFail();

        return view('transactions.receipt', compact('transaction'));
    }
}
