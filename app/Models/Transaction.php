<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice',
        'user_id',
        'game_id',
        'denomination_id',
        'game_nickname',
        'custom_quantity',
        'buyer_name',
        'buyer_email',
        'buyer_phone',
        'amount',
        'confirmed_amount',
        'payment_method',
        'payment_id',
        'status',
        'paid_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'confirmed_amount' => 'decimal:2',
        'paid_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (Transaction $model) {
            if (empty($model->invoice)) {
                $model->invoice = 'FST-' . strtoupper(Str::random(8)) . '-' . now()->format('Ymd');
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function denomination()
    {
        return $this->belongsTo(Denomination::class);
    }

    public function getFormattedAmountAttribute(): string
    {
        return 'Rp ' . number_format($this->amount, 0, ',', '.');
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'paid' => 'emerald',
            'pending' => 'amber',
            'failed' => 'red',
            'expired' => 'gray',
            default => 'gray',
        };
    }
}
