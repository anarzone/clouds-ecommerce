<?php

namespace App\Models\Categories;

use App\Models\Locale;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class GenderType extends Model
{
    use HasFactory;
    protected $table = 'gender_types';
    protected $fillable = [
        'slug'
    ];

    public function translation($locale = null){
        $locale = $locale ?? App::getLocale();
        $locale_id = Locale::where('code', $locale)->first()->id;
        return $this->hasOne(GenderTypeTranslation::class, 'gender_type_id')->where('locale_id', $locale_id);
    }

    public function translations(){
        return $this->hasMany(GenderTypeTranslation::class, 'gender_type_id');
    }

    public function categories(){
        return $this->belongsToMany(Category::class,CategoryGenderType::class);
    }
}
