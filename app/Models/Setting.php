<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/** Simple name/value store for settings the admin can change on the website. */
class Setting extends Model
{
    public $timestamps = false;

    protected $fillable = ['name', 'value'];

    public static function get(string $name, $default = null)
    {
        return static::where('name', $name)->value('value') ?? $default;
    }

    public static function put(string $name, $value): void
    {
        static::updateOrCreate(['name' => $name], ['value' => (string) $value]);
    }

    /** Current delivery fee in pesos (pickup is always free). */
    public static function deliveryFee(): float
    {
        return (float) static::get('delivery_fee', config('shop.delivery_fee', 0));
    }
}
