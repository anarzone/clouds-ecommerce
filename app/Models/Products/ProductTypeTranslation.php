<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductTypeTranslation extends Model
{
    use HasFactory;
    protected $table = 'product_type_translations';

    protected $fillable = [
        'name',
        'product_type_id',
        'locale_id',
    ];
}
