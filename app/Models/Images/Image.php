<?php

namespace App\Models\Images;

use App\Models\Categories\Category;
use App\Models\Customers\Customer;
use App\Models\Products\Product;
use App\Models\Products\ProductImage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    const CATEGORY_TYPE = 1;
    const PRODUCT_TYPE = 2;
    const CUSTOMER_TYPE = 3;

    protected $fillable = [
        'path',
        'type',
    ];

    public function category(){
        return $this->hasOne(Category::class,'cover_image_id');
    }

    public function customer(){
        return $this->hasOne(Customer::class, 'profile_image_id');
    }

    public function products(){
        return $this->belongsToMany(Product::class, ProductImage::class);
    }
}
