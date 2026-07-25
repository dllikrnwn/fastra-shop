<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Mail\TransactionPaid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::with('game', 'denomination', 'user');

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('invoice', 'like', '%' . $request->search . '%')
                  ->orWhere('buyer_name', 'like', '%' . $request->search . '%')
                  ->orWhere('buyer_email', 'like', '%' . $request->search . '%');
            });
        }

        $transactions = $query->latest()->paginate(20)->withQueryString();
        $statuses = ['pending', 'awaiting_verification', 'paid', 'failed', 'expired'];

        return view('admin.transactions.index', compact('transactions', 'statuses'));
    }

    public function show(Transaction $transaction)
    {
        $transaction->load('game', 'denomination', 'user');
        return view('admin.transactions.show', compact('transaction'));
    }

    public function updateStatus(Request $request, Transaction $transaction)
    {
        $validated = $request->validate([
            'status' => 'required|in:paid,failed,expired',
        ]);

        $transaction->update([
            'status' => $validated['status'],
            'paid_at' => $validated['status'] === 'paid' ? now() : $transaction->paid_at,
        ]);

        if ($validated['status'] === 'paid') {
            $transaction->load('game', 'denomination');
            try {
                Mail::to($transaction->buyer_email)->send(new TransactionPaid($transaction));
            } catch (\Exception $e) {
            }
        }

        return redirect()->route('admin.transactions.show', $transaction->id)
            ->with('success', 'Status transaksi berhasil diperbarui menjadi ' . $validated['status']);
    }
}
