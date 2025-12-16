<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\UserType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * User model representing customers and distributors in the MLM system.
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $user_type
 * @property int|null $referred_by
 * @property string $joined_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class User extends Model
{
    /**
     * The table associated with the model.
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'user_type',
        'referred_by',
        'joined_date',
    ];

    /**
     * The attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'joined_date' => 'date',
        ];
    }

    /**
     * Get the full name of the user.
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * Check if the user is a distributor.
     */
    public function isDistributor(): bool
    {
        return $this->user_type === UserType::DISTRIBUTOR->value;
    }

    /**
     * Check if the user is a customer.
     */
    public function isCustomer(): bool
    {
        return $this->user_type === UserType::CUSTOMER->value;
    }

    /**
     * Get the user who referred this user.
     */
    public function referrer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'referred_by');
    }

    /**
     * Get all users referred by this user.
     */
    public function referrals(): HasMany
    {
        return $this->hasMany(User::class, 'referred_by');
    }

    /**
     * Get all orders made by this user.
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'user_id');
    }

    /**
     * Scope to filter only distributors.
     */
    public function scopeDistributors($query)
    {
        return $query->where('user_type', UserType::DISTRIBUTOR->value);
    }

    /**
     * Scope to filter only customers.
     */
    public function scopeCustomers($query)
    {
        return $query->where('user_type', UserType::CUSTOMER->value);
    }
}
