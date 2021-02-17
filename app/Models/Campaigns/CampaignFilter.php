<?php

namespace App\Models\Campaigns;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampaignFilter extends Model
{
    use HasFactory;
    protected $table = 'campaign_filters';

    protected $fillable = [
        'campaign_id',
        'age_type_ids',
        'gender_type_ids',
        'category_ids',
        'brand_id',
        'product_type_id',
    ];

    public function campaign(){
        return $this->hasOne(Campaign::class,'campaign_id');
    }
}
