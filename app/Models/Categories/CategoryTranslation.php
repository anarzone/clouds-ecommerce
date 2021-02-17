<?php

namespace App\Models\Categories;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryTranslation extends Model
{
    use HasFactory;

    protected $table = 'category_translations';
    protected $fillable = [
        'name',
        'category_id',
        'locale_id',
    ];

    public function category(){
        return $this->belongsTo(Category::class, 'category_id');
    }
}
