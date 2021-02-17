<?php

namespace App\Models\Campaigns;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampaignTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'campaign_id',
        'locale_id',
    ];

    protected $table = 'campaign_translations';
}
