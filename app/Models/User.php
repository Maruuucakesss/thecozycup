<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
class User extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $fillable = ['name','email','password','role'];
    protected $hidden = ['password','remember_token'];
    public function cartItems(){ return $this->hasMany(CartItem::class); }
    public function orders(){ return $this->hasMany(Order::class); }
    public function isAdmin(): bool { return $this->role === 'admin'; }
    /** Removes cart items whose product was disabled. Returns true if any were removed. */
    public function purgeUnavailableCart(): bool
    {
        $ids = $this->cartItems()->whereHas('product', fn($q) => $q->where('active', false))->pluck('id');
        if ($ids->isEmpty()) return false;
        CartItem::destroy($ids->all());
        return true;
    }
}
