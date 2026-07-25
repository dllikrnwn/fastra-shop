<?php

namespace App\Mail;

use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TransactionCreated extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Transaction $transaction) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Invoice Transaksi #' . $this->transaction->invoice,
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.transaction-created',
            with: [
                'transaction' => $this->transaction,
                'paymentUrl' => route('transactions.show', $this->transaction->invoice),
            ],
        );
    }
}
