<?php

namespace Database\Seeders;

use App\Models\Locale;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocalesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        Locale::truncate();
        Locale::insert([
            [
                'code' => 'az',
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s'),
            ],
            [
                'code' => 'en',
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s'),
            ],
            [
                'code' => 'ru',
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s'),
            ],
        ]);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
