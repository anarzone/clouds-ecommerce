<?php

namespace App\Models\Products\Carts;

use App\Models\Products\Product;
use App\Models\Products\Variant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id',
        'product_id',
        'variant_id',
        'price',
        'quantity',
    ];

    public function cart(){
        return $this->belongsTo(Cart::class, 'cart_id');
    }

    public function variant(){
        return $this->belongsTo(Variant::class, 'variant_id');
    }

    public function product(){
        return $this->belongsTo(Product::class, 'product_id');
    }
}
