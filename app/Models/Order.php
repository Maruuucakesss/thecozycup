<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public const STATUSES = ['pending', 'accepted', 'on_the_way', 'ready', 'completed', 'cancelled'];

    protected $fillable = [
        'user_id', 'total', 'status', 'contact_name', 'phone', 'pickup_time', 'note',
        'order_type', 'delivery_address', 'delivery_fee', 'reminded_at',
    ];

    protected $casts = ['reminded_at' => 'datetime'];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getIsDeliveryAttribute(): bool
    {
        return $this->order_type === 'delivery';
    }

    public function getSubtotalAttribute(): float
    {
        return (float) $this->total - (float) $this->delivery_fee;
    }

    /** True when the customer should be told something (on the way / ready to pick up). */
    public function getNeedsAttentionAttribute(): bool
    {
        return in_array($this->status, ['on_the_way', 'ready'], true);
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending'    => 'Pending',
            'accepted'   => 'Accepted',
            'on_the_way' => 'On the way',
            'ready'      => 'Ready for pickup',
            'completed'  => 'Completed',
            'cancelled'  => 'Cancelled',
            default      => ucfirst($this->status),
        };
    }

    /** Message shown to the customer on "My orders". */
    public function getCustomerMessageAttribute(): string
    {
        return match ($this->status) {
            'pending'    => 'Waiting for the shop to accept your order.',
            'accepted'   => 'Your order was accepted and is being prepared.',
            'on_the_way' => 'Your order is on the way! Please be ready to receive it.',
            'ready'      => "It's time to pick up your order! It's ready at the counter.",
            'completed'  => 'Order completed. Thank you!',
            'cancelled'  => 'This order was cancelled.',
            default      => '',
        };
    }
}
