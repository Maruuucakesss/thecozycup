<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id', 'name', 'description', 'image', 'is_drink',
        'price', 'price_cold', 'price_hot', 'featured', 'active',
    ];

    protected $casts = [
        'is_drink' => 'boolean',
        'featured' => 'boolean',
        'active'   => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeAvailable($q)
    {
        return $q->where('active', true);
    }

    /** Public URL of the uploaded photo, or null when there is none. */
    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }

    public function getPriceLabelAttribute(): string
    {
        if (!$this->is_drink) {
            return peso($this->price);
        }

        $parts = [];
        if (!is_null($this->price_cold)) {
            $parts[] = peso($this->price_cold) . ' cold';
        }
        if (!is_null($this->price_hot)) {
            $parts[] = peso($this->price_hot) . ' hot';
        }

        return implode(' · ', $parts);
    }
}
