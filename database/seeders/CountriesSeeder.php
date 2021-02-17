<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class CountriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(DB::table('countries')->count() == 0){
            $countries = File::get('public/countries/countries.json');
            $countries = json_decode($countries, true);
            $countries = (array)$countries;
            foreach ($countries as $country){
                DB::table('countries')->insert([
                    'id' => $country['id'],
                    'name' => $country['name'],
                    'iso2' => $country['iso2'],
                    'phone_code' => $country['phone_code'],
                ]);
            }
        }
        if(DB::table('cities')->count() == 0){
            $cities = File::get('public/countries/cities.json');
            $cities = json_decode($cities, true);
            $cities = (array)$cities;
            foreach ($cities as $city){
                DB::table('cities')->insert([
                    'id' => $city['id'],
                    'name' => $city['name'],
                    'country_id' => $city['country_id']
                ]);
            }
        }
    }
}
