<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;
    protected $table = 'product_images';

    const MAIN_TYPE = 1;
    const SECONDARY_TYPE = 2;
}
