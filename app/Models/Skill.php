<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
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
     * Get the tukang profiles that have this skill.
     * 
     * This assumes you'll create a many-to-many relationship with tukang_profiles
     */
    // public function tukangProfiles()
    // {
    //     return $this->belongsToMany(TukangProfile::class, 'tukang_skills', 'skill_id', 'tukang_profile_id')
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
     * Scope to search skills by name
     */
    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', "%{$search}%");
    }
}
