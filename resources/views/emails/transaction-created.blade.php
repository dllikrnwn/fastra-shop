@component('mail::message')
# Halo {{ $transaction->buyer_name }},

Terima kasih telah melakukan pemesanan di **Fastra Shop**!

## Detail Transaksi

| | |
|---|---|
| **Invoice** | {{ $transaction->invoice }} |
| **Game** | {{ $transaction->game->name ?? '-' }} |
| **Nominal** | {{ $transaction->denomination->name ?? '-' }} |
| **ID Game** | {{ $transaction->game_nickname ?? '-' }} |
| **Total** | Rp {{ number_format($transaction->amount, 0, ',', '.') }} |

@component('mail::table')
| Metode Pembayaran |
|:-----------------|
| {{ ucfirst(str_replace('_', ' ', $transaction->payment_method ?? '-')) }} |
@endcomponent

@component('mail::button', ['url' => $paymentUrl])
Bayar Sekarang
@endcomponent

Silakan lakukan pembayaran segera untuk menghindari kedaluwarsa.

Terima kasih telah menggunakan Fastra Shop!

Salam,<br>
**Fastra Shop Team**
@endcomponent
