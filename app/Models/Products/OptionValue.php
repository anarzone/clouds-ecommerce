<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionValue extends Model
{
    use HasFactory;
    protected $table = 'option_values';
    protected $fillable = [
        'option_id',
        'name',
    ];

    public function option(){
        return $this->belongsTo(Option::class,'option_id');
    }
}
