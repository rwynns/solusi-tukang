<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WithdrawalRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'tukang_id',
        'withdrawal_number',
        'bank_account_id',
        'requested_amount',
        'fee_amount',
        'net_amount',
        'status',
        'notes',
        'admin_notes',
        'approved_by',
        'approved_at',
        'transferred_at',
        'completed_at',
        'cancelled_at',
        // Support for controller naming
        'amount',
        'admin_fee',
        'total_amount'
    ];

    protected $casts = [
        'requested_amount' => 'decimal:2',
        'fee_amount' => 'decimal:2',
        'net_amount' => 'decimal:2',
        'approved_at' => 'datetime',
        'transferred_at' => 'datetime',
        'completed_at' => 'datetime'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($withdrawal) {
            $withdrawal->withdrawal_number = 'WD' . now()->format('Ymd') . str_pad(
                static::whereDate('created_at', today())->count() + 1,
                4,
                '0',
                STR_PAD_LEFT
            );
        });
    }

    public function tukang()
    {
        return $this->belongsTo(User::class, 'tukang_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'tukang_id');
    }

    public function bankAccount()
    {
        return $this->belongsTo(TukangBankAccount::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function balanceTransaction()
    {
        return $this->hasOne(BalanceTransaction::class, 'withdrawal_request_id');
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => 'bg-yellow-100 text-yellow-800',
            'approved' => 'bg-blue-100 text-blue-800',
            'transferred' => 'bg-green-100 text-green-800',
            'completed' => 'bg-green-100 text-green-800',
            'rejected' => 'bg-red-100 text-red-800'
        ];

        return $badges[$this->status] ?? 'bg-gray-100 text-gray-800';
    }

    public function getStatusTextAttribute()
    {
        $statuses = [
            'pending' => 'Menunggu Persetujuan',
            'approved' => 'Disetujui',
            'transferred' => 'Sedang Transfer',
            'completed' => 'Selesai',
            'rejected' => 'Ditolak'
        ];

        return $statuses[$this->status] ?? 'Tidak Diketahui';
    }

    public static function getWithdrawalFee($amount)
    {
        if ($amount <= 1000000) {
            return 5000; // Rp 5,000
        } elseif ($amount <= 5000000) {
            return 10000; // Rp 10,000
        } else {
            return 15000; // Rp 15,000
        }
    }

    public static function getMinimumWithdrawal()
    {
        return 100000; // Rp 100,000
    }

    public static function getMinimumAmount()
    {
        return 50000; // Rp 50,000
    }

    public static function getAdminFee()
    {
        return 2500; // Rp 2,500
    }

    // Accessor untuk kompatibilitas dengan controller existing
    public function getAmountAttribute()
    {
        return $this->requested_amount;
    }

    public function getAdminFeeAttribute()
    {
        return $this->fee_amount;
    }

    public function getTotalAmountAttribute()
    {
        return $this->net_amount;
    }

    // Untuk menghandle assignment
    public function setAmountAttribute($value)
    {
        $this->attributes['requested_amount'] = $value;
    }

    public function setAdminFeeAttribute($value)
    {
        $this->attributes['fee_amount'] = $value;
    }

    public function setTotalAmountAttribute($value)
    {
        $this->attributes['net_amount'] = $value;
    }

    public static function generateWithdrawalNumber()
    {
        do {
            $number = 'WD' . date('Ymd') . rand(1000, 9999);
        } while (self::where('withdrawal_number', $number)->exists());

        return $number;
    }
}
