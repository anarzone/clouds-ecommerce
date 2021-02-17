<?php

namespace Database\Seeders;

use App\Models\Categories\AgeType;
use App\Models\Categories\AgeTypeTranslation;
use App\Models\Categories\GenderType;
use App\Models\Categories\GenderTypeTranslation;
use App\Models\Locale;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class AgeGenderTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        AgeType::truncate();
        GenderType::truncate();

        $ageTypesTranslations = [
            'slugs' => [
                'toddler',
                'junior',
                'baby',
            ],
            'translations' => [
                [
                    1 => 'Toddler',
                    2 => 'Toddler',
                    3 => 'Toddler',
                ],
                [
                    1 => 'Junior',
                    2 => 'Junior',
                    3 => 'Junior',
                ],
                [
                    1 => 'Baby',
                    2 => 'Baby',
                    3 => 'Baby',
                ],
            ]
        ];

        $genderTypesTranslations = [
            'slugs' => [
                'boy',
                'girl'
            ],
            'translations' => [
                [
                    1 => 'Boy',
                    2 => 'Boy',
                    3 => 'Boy',
                ],
                [
                    1 => 'Girl',
                    2 => 'Girl',
                    3 => 'Girl',
                ],
            ]
        ];


        // seed age types
        foreach ($ageTypesTranslations['slugs'] as $i => $type){
            $ageType = AgeType::create([
                'slug' => $type
            ]);

            foreach ($ageTypesTranslations['translations'][$i] as $localeId => $translation){
                AgeTypeTranslation::create([
                    'name' => $translation,
                    'age_type_id' => $ageType->id,
                    'locale_id' => $localeId,
                ]);
            }
        }

        // seed gender types
        foreach ($genderTypesTranslations['slugs'] as $i => $type){
            $genderType = GenderType::create([
                'slug' => $type
            ]);

            foreach ($genderTypesTranslations['translations'][$i] as $localeId => $translation){
                GenderTypeTranslation::create([
                    'name' => $translation,
                    'gender_type_id' => $genderType->id,
                    'locale_id' => $localeId,
                ]);
            }
        }


        Schema::enableForeignKeyConstraints();
    }
}
