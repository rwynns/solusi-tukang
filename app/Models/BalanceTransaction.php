<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BalanceTransaction extends Model
{
    protected $fillable = [
        'transaction_id',
        'type',
        'order_id',
        'withdrawal_request_id',
        'tukang_id',
        'amount',
        'balance_before',
        'balance_after',
        'description',
        'metadata'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'balance_before' => 'decimal:2',
        'balance_after' => 'decimal:2',
        'metadata' => 'array'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function withdrawal()
    {
        return $this->belongsTo(WithdrawalRequest::class, 'withdrawal_request_id');
    }

    public function tukang()
    {
        return $this->belongsTo(User::class, 'tukang_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($transaction) {
            if (empty($transaction->transaction_id)) {
                $transaction->transaction_id = 'TXN' . now()->format('YmdHis') . str_pad(
                    static::whereDate('created_at', now()->toDateString())->count() + 1,
                    4,
                    '0',
                    STR_PAD_LEFT
                );
            }
        });
    }

    public function getTypeDisplayAttribute()
    {
        $types = [
            'customer_payment' => 'Pembayaran Customer',
            'withdrawal_request' => 'Request Penarikan',
            'withdrawal_completed' => 'Transfer Selesai',
            'admin_fee' => 'Fee Admin',
            'refund' => 'Refund',
            'adjustment' => 'Penyesuaian'
        ];

        return $types[$this->type] ?? $this->type;
    }

    public function getAmountColorAttribute()
    {
        return in_array($this->type, ['customer_payment', 'refund'])
            ? 'text-green-600'
            : 'text-red-600';
    }
}
