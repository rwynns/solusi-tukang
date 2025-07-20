<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PlatformBalance extends Model
{
    protected $table = 'platform_balance';

    protected $fillable = [
        'total_balance',
        'available_balance',
        'pending_withdrawals',
        'admin_earnings'
    ];

    protected $casts = [
        'total_balance' => 'decimal:2',
        'available_balance' => 'decimal:2',
        'pending_withdrawals' => 'decimal:2',
        'admin_earnings' => 'decimal:2'
    ];

    public static function current()
    {
        return static::first();
    }

    public static function getCurrentBalance()
    {
        $balance = static::first();
        return $balance ? $balance->total_balance : 0;
    }

    public function addCustomerPayment($amount, $orderId)
    {
        DB::transaction(function () use ($amount, $orderId) {
            // 90% untuk tukang (available balance)
            $tukangAmount = $amount * 0.9;
            // 10% untuk admin
            $adminAmount = $amount * 0.1;

            $this->increment('total_balance', $amount);
            $this->increment('available_balance', $tukangAmount);
            $this->increment('admin_earnings', $adminAmount);

            // Log transaction
            BalanceTransaction::create([
                'transaction_id' => 'PAY-' . now()->format('YmdHis') . '-' . $orderId,
                'type' => 'customer_payment',
                'order_id' => $orderId,
                'amount' => $amount,
                'balance_before' => $this->total_balance - $amount,
                'balance_after' => $this->total_balance,
                'description' => "Customer payment for order #{$orderId}",
                'metadata' => [
                    'tukang_amount' => $tukangAmount,
                    'admin_amount' => $adminAmount
                ]
            ]);
        });
    }

    public function processWithdrawal($withdrawalId, $amount)
    {
        DB::transaction(function () use ($withdrawalId, $amount) {
            $this->decrement('available_balance', $amount);
            $this->increment('pending_withdrawals', $amount);

            BalanceTransaction::create([
                'transaction_id' => 'WR-' . now()->format('YmdHis') . '-' . $withdrawalId,
                'type' => 'withdrawal_request',
                'withdrawal_id' => $withdrawalId,
                'amount' => $amount,
                'balance_before' => $this->available_balance + $amount,
                'balance_after' => $this->available_balance,
                'description' => "Withdrawal request #{$withdrawalId}"
            ]);
        });
    }

    public function completeWithdrawal($withdrawalId, $amount)
    {
        DB::transaction(function () use ($withdrawalId, $amount) {
            $this->decrement('pending_withdrawals', $amount);
            $this->decrement('total_balance', $amount);

            BalanceTransaction::create([
                'transaction_id' => 'WC-' . now()->format('YmdHis') . '-' . $withdrawalId,
                'type' => 'withdrawal_completed',
                'withdrawal_id' => $withdrawalId,
                'amount' => $amount,
                'balance_before' => $this->total_balance + $amount,
                'balance_after' => $this->total_balance,
                'description' => "Withdrawal completed #{$withdrawalId}"
            ]);
        });
    }
}
