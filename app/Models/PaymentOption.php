<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentOption extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'account_number',
        'account_name',
        'qr_code',
        'logo',
        'is_active'
    ];

    /**
     * Get active payment options ordered by the order field
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getActive()
    {
        return self::where('is_active', true)
            ->orderBy('order')
            ->get();
    }
}
