<?php

namespace App\Models\Products\Carts;

use App\Models\Customers\Customer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id'
    ];

    public function items(){
        return $this->hasMany(CartItem::class, 'cart_id');
    }

    public function customer(){
        return $this->belongsTo(Customer::class,'customer_id');
    }
}
