<?php

namespace App\Models\Campaigns;

use App\Models\Locale;
use App\Models\Products\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Campaign extends Model
{
    use HasFactory;

    const RATE_TYPE_PERCENTAGE = 1;
    const RATE_TYPE_FLAT = 2;

    const IMAGE_PATH = 'campaigns';

    const UNPUBLISHED_STATUS = 0;
    const PUBLISHED_STATUS = 1;

    const BANNER_TYPE = 1;
    const PROMOTION_TYPE = 2;

    protected $fillable = [
        'rate',
        'rate_type',
        'campaign_type',
        'status',
        'cover',
    ];

    public function translation($locale = null){
        $locale = $locale ?? App::getLocale();
        $locale_id = Locale::where('code', $locale)->first()->id;
        return $this->hasOne(CampaignTranslation::class, 'campaign_id')->where('locale_id', $locale_id)->first();
    }

    public function translations(){
        return $this->hasMany(CampaignTranslation::class, 'campaign_id');
    }

    public function products(){
        return $this->belongsToMany(Product::class, CampaignProduct::class);
    }
}
