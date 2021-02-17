<?php

namespace App\Models\Campaigns;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampaignProduct extends Model
{
    use HasFactory;

    const PRODUCT = 1;
    const BRAND = 2;
    const CATEGORY = 3;
    const PRODUCT_TYPE = 4;
    const SHIPPING = 5;

    protected $table = 'campaign_products';
}
