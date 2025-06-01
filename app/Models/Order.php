<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_number',
        'total_amount',
        'status',
        'payment_status',
        'payment_option_id',
        'customer_name',
        'customer_phone',
        'customer_address',
        'notes'
    ];

    /**
     * Generate a unique order number
     */
    public function generateOrderNumber(): string
    {
        $prefix = 'ST-' . date('Ymd');
        $unique = strtoupper(Str::random(6));

        return $prefix . '-' . $unique;
    }

    /**
     * Get the user who placed this order
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the items in this order
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get the payment for this order
     */
    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

    /**
     * Get the payment option used for this order
     */
    public function paymentOption(): BelongsTo
    {
        return $this->belongsTo(PaymentOption::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Variabel untuk status pembayaran
    const PAYMENT_STATUS_PENDING = 'pending';
    const PAYMENT_STATUS_VERIFYING = 'verifying';
    const PAYMENT_STATUS_PAID = 'paid';
    const PAYMENT_STATUS_CANCELLED = 'cancelled';
}
