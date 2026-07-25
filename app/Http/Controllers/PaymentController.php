<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Mail\TransactionCreated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PaymentController extends Controller
{
    public function manual(Transaction $transaction)
    {
        abort_if($transaction->status !== 'pending', 404);
        $transaction->load('denomination');

        return view('payment.manual', compact('transaction'));
    }

    public function confirm(Transaction $transaction)
    {
        abort_if($transaction->status !== 'pending', 404);

        $transaction->update([
            'confirmed_amount' => $transaction->amount,
            'status' => 'awaiting_verification',
        ]);

        try {
            Mail::to($transaction->buyer_email)->send(new TransactionCreated($transaction));
        } catch (\Exception $e) {
        }

        $waMessage = urlencode(
            "Pembayaran Baru ✅\n\n"
            . "Invoice: {$transaction->invoice}\n"
            . "Game: {$transaction->game->name} - {$transaction->denomination->name}\n"
            . "ID Game: {$transaction->game_nickname}\n"
            . "Total: Rp " . number_format($transaction->amount, 0, ',', '.') . "\n"
            . "Metode: " . ucfirst(str_replace('_', ' ', $transaction->payment_method ?? '-')) . "\n"
            . "Pembeli: {$transaction->buyer_name}\n"
            . "No WA: {$transaction->buyer_phone}\n\n"
            . "Silakan verifikasi di admin panel."
        );

        $waUrl = "https://wa.me/" . config('payment.wa_number') . "?text={$waMessage}";

        return response()->json([
            'success' => true,
            'wa_url' => $waUrl,
            'invoice_url' => route('transactions.show', $transaction->invoice),
        ]);
    }
}
