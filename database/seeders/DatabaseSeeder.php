<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            LocalesSeeder::class,
            PermissionSeeder::class,
            UsersSeeder::class,
            OptionsSeeder::class,
            CountriesSeeder::class,
            AgeGenderTypesSeeder::class,
            CampaignItemTypesSeeder::class
        ]);
    }
}
