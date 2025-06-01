<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'sub_jasa_id',
        'name',
        'quantity',
        'price',
        'subtotal',
        'tukang_profile_id'
    ];

    /**
     * Get the order this item belongs to
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the sub jasa (service) for this item
     */
    public function subJasa(): BelongsTo
    {
        return $this->belongsTo(SubJasa::class);
    }

    /**
     * Get the technician assigned to this item
     */
    public function tukangProfile(): BelongsTo
    {
        return $this->belongsTo(TukangProfile::class);
    }
}
