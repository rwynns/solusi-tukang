<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'sub_jasa_id',
        'quantity',
        'price',
        'additional_data'
    ];

    protected $casts = [
        'additional_data' => 'array',
        'price' => 'decimal:2',
        'quantity' => 'integer'
    ];

    /**
     * Relationship to User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship to SubJasa
     */
    public function subJasa(): BelongsTo
    {
        return $this->belongsTo(SubJasa::class);
    }

    /**
     * Get total price for this cart item
     */
    public function getTotalPriceAttribute(): float
    {
        return $this->price * $this->quantity;
    }

    /**
     * Get formatted total price
     */
    public function getFormattedTotalPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->total_price, 0, ',', '.');
    }

    /**
     * Scope to get cart items for a specific user
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Get cart count for a specific user
     */
    public static function getCartCount($userId): int
    {
        return self::where('user_id', $userId)->sum('quantity');
    }

    /**
     * Get cart total for a specific user
     */
    public static function getCartTotal($userId): float
    {
        return self::where('user_id', $userId)
            ->get()
            ->sum(function ($item) {
                return $item->total_price;
            });
    }

    /**
     * Add item to cart or update quantity if exists
     */
    public static function addToCart($userId, $subJasaId, $quantity = 1, $price = null, $additionalData = [])
    {
        // Get the SubJasa to get the price if not provided
        if (!$price) {
            $subJasa = SubJasa::find($subJasaId);
            $price = $subJasa ? $subJasa->harga : 0;
        }

        $cart = self::where('user_id', $userId)
            ->where('sub_jasa_id', $subJasaId)
            ->first();

        if ($cart) {
            // Update quantity if item already exists
            $cart->quantity += $quantity;
            $cart->save();
        } else {
            // Create new cart item
            $cart = self::create([
                'user_id' => $userId,
                'sub_jasa_id' => $subJasaId,
                'quantity' => $quantity,
                'price' => $price,
                'additional_data' => $additionalData
            ]);
        }

        return $cart;
    }

    /**
     * Update cart item quantity
     */
    public static function updateQuantity($userId, $subJasaId, $quantity)
    {
        $cart = self::where('user_id', $userId)
            ->where('sub_jasa_id', $subJasaId)
            ->first();

        if ($cart) {
            if ($quantity <= 0) {
                $cart->delete();
                return null;
            } else {
                $cart->quantity = $quantity;
                $cart->save();
                return $cart;
            }
        }

        return null;
    }

    /**
     * Remove item from cart
     */
    public static function removeFromCart($userId, $subJasaId)
    {
        return self::where('user_id', $userId)
            ->where('sub_jasa_id', $subJasaId)
            ->delete();
    }

    /**
     * Clear all cart items for a user
     */
    public static function clearCart($userId)
    {
        return self::where('user_id', $userId)->delete();
    }
}
