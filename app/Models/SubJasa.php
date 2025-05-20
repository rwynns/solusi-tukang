<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubJasa extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sub_jasa';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'jasa_id',
        'nama',
        'deskripsi',
        'harga',
        'durasi',
        'satuan',
        'gambar',
        'is_active',
        'urutan',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'harga' => 'decimal:2',
        'is_active' => 'boolean',
        'urutan' => 'integer',
    ];

    /**
     * Get the jasa that owns the sub jasa.
     */
    public function jasa()
    {
        return $this->belongsTo(Jasa::class);
    }
}
