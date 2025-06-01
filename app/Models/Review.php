<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id',
        'user_id',
        'content',
    ];

    /**
     * Get the order that owns this review.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the user that created this review.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
