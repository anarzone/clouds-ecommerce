<?php

namespace App\Models\Products;

use App\Models\Locale;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class ProductType extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';

    protected $table = 'product_types';
    protected $fillable = [
        'slug'
    ];

    public function translation($locale = null){
        $locale = $locale ?? App::getLocale();
        $locale_id = Locale::where('code', $locale)->first()->id;
        return $this->hasOne(ProductTypeTranslation::class, 'product_type_id')->where('locale_id', $locale_id)->first();
    }

    public function translations(){
        return $this->hasMany(ProductTypeTranslation::class, 'product_type_id');
    }

    public function products(){
        return $this->hasMany(Product::class,'product_type_id');
    }
}
