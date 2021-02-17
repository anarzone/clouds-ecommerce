<?php

namespace App\Models\Products;

use App\Models\Brands\Brand;
use App\Models\Campaigns\Campaign;
use App\Models\Categories\Category;
use App\Models\Images\Image;
use App\Models\Locale;
use App\Models\Products\Carts\CartItem;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Product extends Model
{
    use HasFactory;

    const PATH_PRODUCT_IMAGES = 'products';
    const SORT_NEW = 1;
    const SORT_LOWEST_PRICE = 2;
    const SORT_HIGHEST_PRICE = 3;

    protected $fillable = [
        'sku',
        'price',
        'quantity',
        'sale_price',
        'brand_id',
        'product_type_id',
    ];

    public function translation($locale = null){
        $locale = $locale ?? App::getLocale();
        $locale_id = Locale::where('code', $locale)->first()->id;
        return $this->hasOne(ProductTranslation::class, 'product_id')->where('locale_id', $locale_id)->first();
    }

    public function translations(){
        return $this->hasMany(ProductTranslation::class, 'product_id');
    }

    public function images(){
        return $this->belongsToMany(Image::class, ProductImage::class)->wherePivot('type',ProductImage::SECONDARY_TYPE);
    }

    public function mainImage(){
        return $this->belongsToMany(Image::class,ProductImage::class)->wherePivot('type',ProductImage::MAIN_TYPE);
    }

    public function brand(){
        return $this->belongsTo(Brand::class,'brand_id');
    }

    public function productType(){
        return $this->belongsTo(ProductType::class,'product_type_id');
    }

    public function variants(){
        return $this->hasMany(Variant::class,'product_id');
    }

    public function categories(){
        return $this->belongsToMany(Category::class,ProductCategory::class)->withPivot(['gender_type_id', 'age_type_id']);
    }

    public function cartItem(){
        return $this->hasMany(CartItem::class, 'product_id');
    }

    public function campaigns(){
        return $this->belongsToMany(Campaign::class);
    }
}
