@component('mail::message')
# Pembayaran Berhasil! 🎉

Halo **{{ $transaction->buyer_name }}**,

Pembayaran untuk transaksi berikut telah berhasil dikonfirmasi.

## Detail Transaksi

| | |
|---|---|
| **Invoice** | {{ $transaction->invoice }} |
| **Game** | {{ $transaction->game->name ?? '-' }} |
| **Nominal** | {{ $transaction->denomination->name ?? '-' }} |
| **ID Game** | {{ $transaction->game_nickname ?? '-' }} |
| **Total** | Rp {{ number_format($transaction->amount, 0, ',', '.') }} |
| **Status** | ✅ LUNAS |

@component('mail::button', ['url' => $transactionUrl])
Lihat Detail Transaksi
@endcomponent

Silakan cek akun game kamu untuk melihat saldo yang sudah masuk.

Terima kasih telah menggunakan Fastra Shop! 🌟

Salam,<br>
**Fastra Shop Team**
@endcomponent
