<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EarningSplit extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'tukang_id',
        'total_amount',
        'tukang_amount',
        'admin_amount',
        'tukang_percentage',
        'admin_percentage',
        'status',
        'distributed_at',
        'notes'
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'tukang_amount' => 'decimal:2',
        'admin_amount' => 'decimal:2',
        'tukang_percentage' => 'decimal:2',
        'admin_percentage' => 'decimal:2',
        'distributed_at' => 'datetime',
    ];

    /**
     * Get the order that owns the earning split
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the tukang (user) that owns the earning split
     */
    public function tukang(): BelongsTo
    {
        return $this->belongsTo(User::class, 'tukang_id');
    }

    /**
     * Create earning split for an order
     */
    public static function createForOrder(Order $order, ?int $tukangId = null): self
    {
        $totalAmount = $order->total_amount;
        $tukangPercentage = 90.00;
        $adminPercentage = 10.00;

        $tukangAmount = $totalAmount * ($tukangPercentage / 100);
        $adminAmount = $totalAmount * ($adminPercentage / 100);

        return self::create([
            'order_id' => $order->id,
            'tukang_id' => $tukangId,
            'total_amount' => $totalAmount,
            'tukang_amount' => $tukangAmount,
            'admin_amount' => $adminAmount,
            'tukang_percentage' => $tukangPercentage,
            'admin_percentage' => $adminPercentage,
            'status' => 'pending'
        ]);
    }

    /**
     * Mark as distributed
     */
    public function markAsDistributed(): bool
    {
        return $this->update([
            'status' => 'distributed',
            'distributed_at' => now()
        ]);
    }

    /**
     * Get total admin earnings
     */
    public static function getTotalAdminEarnings(?string $period = null): float
    {
        $query = self::where('status', 'distributed');

        if ($period === 'month') {
            $query->whereMonth('distributed_at', date('m'))
                ->whereYear('distributed_at', date('Y'));
        } elseif ($period === 'year') {
            $query->whereYear('distributed_at', date('Y'));
        }

        return $query->sum('admin_amount');
    }

    /**
     * Get total tukang earnings
     */
    public static function getTotalTukangEarnings(?int $tukangId = null, ?string $period = null): float
    {
        $query = self::where('status', 'distributed');

        if ($tukangId) {
            $query->where('tukang_id', $tukangId);
        }

        if ($period === 'month') {
            $query->whereMonth('distributed_at', date('m'))
                ->whereYear('distributed_at', date('Y'));
        } elseif ($period === 'year') {
            $query->whereYear('distributed_at', date('Y'));
        }

        return $query->sum('tukang_amount');
    }
}
