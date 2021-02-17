<?php

namespace App\Models\Categories;

use App\Models\Locale;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class AgeType extends Model
{
    use HasFactory;
    protected $table = 'age_types';
    protected $fillable = [
        'slug'
    ];

    public function translation($locale = null){
        $locale = $locale ?? App::getLocale();
        $locale_id = Locale::where('code', $locale)->first()->id;
        return $this->hasOne(AgeTypeTranslation::class, 'age_type_id')->where('locale_id', $locale_id);
    }

    public function translations(){
        return $this->hasMany(AgeTypeTranslation::class, 'age_type_id');
    }

    public function categories(){
        return $this->belongsToMany(Category::class,CategoryAgeType::class);
    }

}
