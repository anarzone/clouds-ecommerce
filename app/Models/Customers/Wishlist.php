<?php

namespace App\Models\Customers;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;
    protected $table = 'favorites';
    protected $fillable = [
        'customer_id',
        'product_id',
        'color',
        'size',
        'price',
        'sale_price',
    ];
}
