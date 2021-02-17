<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use HasFactory;

    const COLOR = 'Rəng';
    const SIZE = 'Ölçü';

    public function values(){
        return $this->hasMany(OptionValue::class,'option_id');
    }
}
