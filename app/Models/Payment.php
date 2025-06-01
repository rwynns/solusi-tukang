<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'user_id',
        'payment_proof',
        'admin_notes',
        'status',
        'verified_at'
    ];

    protected $casts = [
        'verified_at' => 'datetime',
    ];

    /**
     * Get the order associated with this payment
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the user who made this payment
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
