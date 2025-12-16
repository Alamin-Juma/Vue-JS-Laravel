<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Order model representing purchase orders in the system.
 *
 * @property int $id
 * @property string $invoice
 * @property int $user_id
 * @property string $order_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Order extends Model
{
    /**
     * The table associated with the model.
     */
    protected $table = 'orders';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'invoice',
        'user_id',
        'order_date',
    ];

    /**
     * The attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'order_date' => 'date',
        ];
    }

    /**
     * Get the user who placed this order.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the items in this order.
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    /**
     * Calculate the total amount of the order.
     */
    public function getTotalAttribute(): float
    {
        return $this->items->sum(function ($item) {
            return $item->price * $item->quantity;
        });
    }
}
