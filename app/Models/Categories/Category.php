<?php

namespace App\Models\Categories;

use App\Models\Categories\CategoryTranslation;
use App\Models\Images\Image;
use App\Models\Locale;
use App\Models\Products\Product;
use App\Models\Products\ProductCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Category extends Model
{
    use HasFactory;

    const COVER_PATH = 'covers';

    protected $fillable = [
        'slug',
        'cover_image_id',
        'parent_id',
        'position',
        'grid'
    ];

    public function translation($locale = null){
        $locale = $locale ?? App::getLocale();
        $locale_id = Locale::where('code', $locale)->first()->id;
        return $this->hasOne(CategoryTranslation::class, 'category_id')->where('locale_id', $locale_id);
    }

    public function translations(){
        return $this->hasMany(CategoryTranslation::class, 'category_id');
    }

    public function cover(){
        return $this->belongsTo(Image::class,'cover_image_id');
    }

    public function parent(){
        return $this->belongsTo(self::class,'parent_id');
    }

    public function children(){
        return $this->hasMany(self::class, 'parent_id')->with('parent');
    }

    public function products(){
        return $this->belongsToMany(Product::class,ProductCategory::class);
    }

    public function genderTypes(){
        return $this->belongsToMany(GenderType::class,CategoryGenderType::class);
    }

    public function ageTypes(){
        return $this->belongsToMany(AgeType::class,CategoryAgeType::class);
    }
}
