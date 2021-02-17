<?php

namespace App\Models\Categories;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GenderTypeTranslation extends Model
{
    use HasFactory;

    protected $table = 'gender_type_translations';
    protected $fillable = [
        'name',
        'gender_type_id',
        'locale_id',
    ];
}
