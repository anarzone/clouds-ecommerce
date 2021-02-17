<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductTranslation extends Model
{
    use HasFactory;
    protected $table = 'product_translations';
    protected $fillable = [
        'title',
        'description',
        'product_id',
        'locale_id',
    ];

    public function product(){
        return $this->belongsTo(Product::class,'product_id');
    }
}
