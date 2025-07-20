<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TukangBankAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'tukang_id',
        'bank_name',
        'account_number',
        'account_holder_name',
        'is_primary',
        'is_verified',
        'verified_at'
    ];

    protected $casts = [
        'is_primary' => 'boolean',
        'is_verified' => 'boolean',
        'verified_at' => 'datetime'
    ];

    public function tukang()
    {
        return $this->belongsTo(User::class, 'tukang_id');
    }

    public function withdrawalRequests()
    {
        return $this->hasMany(WithdrawalRequest::class, 'bank_account_id');
    }

    public function getMaskedAccountNumberAttribute()
    {
        $number = $this->account_number;
        return substr($number, 0, 4) . str_repeat('*', strlen($number) - 8) . substr($number, -4);
    }

    public static function getBankList()
    {
        return [
            'BCA' => 'Bank Central Asia',
            'BNI' => 'Bank Negara Indonesia',
            'BRI' => 'Bank Rakyat Indonesia',
            'Mandiri' => 'Bank Mandiri',
            'CIMB' => 'CIMB Niaga',
            'Danamon' => 'Bank Danamon',
            'Permata' => 'Bank Permata',
            'Maybank' => 'Maybank Indonesia',
            'OCBC' => 'OCBC NISP',
            'Panin' => 'Bank Panin',
        ];
    }
}
