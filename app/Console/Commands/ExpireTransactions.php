<?php

namespace App\Console\Commands;

use App\Models\Transaction;
use Illuminate\Console\Command;

class ExpireTransactions extends Command
{
    protected $signature = 'transactions:expire';
    protected $description = 'Expire pending transactions older than 1 hour';

    public function handle(): int
    {
        $expiredCount = Transaction::where('status', 'pending')
            ->where('created_at', '<', now()->subHour())
            ->update(['status' => 'expired']);

        if ($expiredCount > 0) {
            $this->info("{$expiredCount} transaksi expired.");
        } else {
            $this->info("Tidak ada transaksi yang perlu di-expire.");
        }

        $expiredVerifyCount = Transaction::where('status', 'awaiting_verification')
            ->where('created_at', '<', now()->subHours(24))
            ->update(['status' => 'expired']);

        if ($expiredVerifyCount > 0) {
            $this->info("{$expiredVerifyCount} transaksi awaiting_verification expired (>24 jam).");
        }

        return self::SUCCESS;
    }
}
