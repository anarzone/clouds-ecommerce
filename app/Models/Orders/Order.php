<?php

namespace App\Models\Orders;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    const STATUS_PENDING = 1;
    const STATUS_PAID = 2;

    protected $fillable = [
        'customer_id',
        'status',
        'shipping_address',
        'shipping_floor',
        'shipping_country',
        'shipping_city',
        'status',
        'tax',
        'subtotal',
        'delivery',
        'total',
        'reward',
        'gift_cart',
        'debit_cart',
        'note',
    ];
}
