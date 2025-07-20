<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_number',
        'address',
        'role_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Get the role associated with the user.
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Check if user has specific role
     * 
     * @param string $roleName
     * @return bool
     */
    public function hasRole($roleName)
    {
        return $this->role->name === $roleName;
    }

    /**
     * Check if user is Admin
     * 
     * @return bool
     */
    public function isAdmin()
    {
        return $this->hasRole('admin');
    }

    /**
     * Check if user is Tukang
     * 
     * @return bool
     */
    public function isTukang()
    {
        return $this->hasRole('tukang');
    }

    /**
     * Check if user is Customer
     * 
     * @return bool
     */
    public function isCustomer()
    {
        return $this->hasRole('customer');
    }

    /**
     * Get the tukang profile associated with the user.
     */
    public function tukangProfile(): HasOne
    {
        return $this->hasOne(TukangProfile::class);
    }

    /**
     * Get bank accounts for tukang
     */
    public function bankAccounts(): HasMany
    {
        return $this->hasMany(TukangBankAccount::class, 'tukang_id');
    }

    /**
     * Get withdrawal requests
     */
    public function withdrawalRequests(): HasMany
    {
        return $this->hasMany(WithdrawalRequest::class, 'tukang_id');
    }

    /**
     * Get earning splits for tukang
     */
    public function earningSplits(): HasMany
    {
        return $this->hasMany(EarningSplit::class, 'tukang_id');
    }

    /**
     * Get available balance for withdrawal
     */
    public function getAvailableBalanceAttribute()
    {
        return $this->earningSplits()
            ->where('status', 'distributed')
            ->sum('tukang_amount');
    }

    /**
     * Get pending withdrawal amount
     */
    public function getPendingWithdrawalsAttribute()
    {
        return $this->withdrawalRequests()
            ->whereIn('status', ['pending', 'approved'])
            ->sum('requested_amount');
    }

    /**
     * Get withdrawable balance (available - pending)
     */
    public function getWithdrawableBalanceAttribute()
    {
        return $this->available_balance - $this->pending_withdrawals;
    }
}
