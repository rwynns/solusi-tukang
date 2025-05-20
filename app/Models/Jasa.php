<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Jasa extends Model
{
    use HasFactory, Sluggable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'jasa';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'deskripsi',
        'gambar',
        'slug',
    ];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'nama'
            ]
        ];
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Get image URL attribute
     *
     * @return string
     */
    public function getImageUrlAttribute()
    {
        if ($this->gambar) {
            return asset('storage/' . $this->gambar);
        }

        return asset('images/placeholder-service.jpg');
    }

    /**
     * Get the sub jasa for the jasa.
     */
    public function subJasa()
    {
        return $this->hasMany(SubJasa::class);
    }
}
