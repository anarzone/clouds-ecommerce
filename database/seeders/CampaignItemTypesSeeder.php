<?php

namespace Database\Seeders;

use App\Models\Campaigns\CampaignItemType;
use App\Models\Campaigns\CampaignItemTypeTranslation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class CampaignItemTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        $typesTranslations = [
            [
                1 => 'Məhsul',
                2 => 'Product',
                3 => 'Product',
            ],
            [
                1 => 'Marka',
                2 => 'Brand',
                3 => 'Brand',
            ],
            [
                1 => 'Kateqoriya',
                2 => 'Category',
                3 => 'Category',
            ],
        ];

        if(CampaignItemType::all()->isEmpty()){
            foreach ($typesTranslations as $i => $typesTranslation){
                $campaignType = CampaignItemType::create(['id' => $i+1]);
                foreach ($typesTranslation as $key => $translation){
                    CampaignItemTypeTranslation::create([
                        'name' => $translation,
                        'campaign_item_type_id' => $campaignType->id,
                        'locale_id' => $key,
                    ]);
                }
            }
        }

        Schema::enableForeignKeyConstraints();
    }
}
