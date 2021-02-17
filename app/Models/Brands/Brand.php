<?php

namespace App\Models\Brands;

use App\Models\Products\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $table = 'brands';
    protected $fillable = [
        'name',
        'slug'
    ];

    public function products(){
        return $this->hasMany(Product::class,'brand_id');
    }
}
