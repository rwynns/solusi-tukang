<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class TukangProfile extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'location_id',
        'bio',
        'profile_photo',
    ];

    /**
     * Get the user that owns the tukang profile.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the location associated with the tukang.
     */
    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    /**
     * Get the skills for the tukang.
     */
    public function skills(): BelongsToMany
    {
        return $this->belongsToMany(
            SubJasa::class,
            'tukang_skills',
            'tukang_profile_id',
            'sub_jasa_id'
        );
    }

    /**
     * Get the tukang's full name from the user relationship.
     */
    public function getNameAttribute()
    {
        return $this->user->name;
    }

    /**
     * Get the tukang's email from the user relationship.
     */
    public function getEmailAttribute()
    {
        return $this->user->email;
    }

    /**
     * Get the tukang's phone number from the user relationship.
     */
    public function getPhoneNumberAttribute()
    {
        return $this->user->phone_number;
    }

    /**
     * Get the tukang's address from the user relationship.
     */
    public function getAddressAttribute()
    {
        return $this->user->address;
    }
}
