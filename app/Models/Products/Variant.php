<?php

namespace App\Models\Products;

use App\Models\Products\Carts\CartItem;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variant extends Model
{
    use HasFactory;

    protected $fillable = [
        'image_id',
        'product_id',
        'option_1',
        'option_2',
        'price',
        'sku',
        'quantity',
    ];

    public function product(){
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function cartItem(){
        return $this->hasMany(CartItem::class,'variant_id');
    }
}
