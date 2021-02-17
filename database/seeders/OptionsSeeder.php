<?php

namespace Database\Seeders;

use App\Models\Products\Option;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class OptionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        $options = [
            ['id' => 1, 'name' => 'Rəng'],
            ['id' => 2, 'name' => 'Ölçü'],
        ];

        foreach ($options as $option){
            Option::updateOrCreate(['id' => $option['id']], ['name' => $option['name']]);
        }

        Schema::disableForeignKeyConstraints();
    }
}
