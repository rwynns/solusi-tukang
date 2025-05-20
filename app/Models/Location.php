<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Get all tukang profiles that service this location.
     */
    // public function tukangProfiles()
    // {
    //     return $this->belongsToMany(TukangProfile::class, 'tukang_locations', 'location_id', 'tukang_profile_id')
    //         ->withTimestamps();
    // }

    /**
     * Get formatted creation date
     */
    public function getFormattedCreatedAtAttribute()
    {
        return $this->created_at->format('d F Y');
    }

    /**
     * Scope to search locations by name
     */
    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', "%{$search}%");
    }
}
