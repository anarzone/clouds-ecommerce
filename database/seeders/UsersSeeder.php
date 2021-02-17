<?php

namespace Database\Seeders;

use App\Models\Customers\Customer;
use App\Models\Images\Image;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        $customerUser = User::where('email','test@test.com');
        if($customerUser->first()){
            $customerUser->truncate();
        }
        $customer = Customer::where('firstname', 'Test');
        if($customer->first()){
            $customer->truncate();
        }
//        $image = Image::where('path','some/fake/path');
//        if($image->first()){
//            $image->truncate();
//        }

        Customer::create([
            'firstname' => 'Test',
            'lastname' => 'Testovic',
            'birthdate' => new Carbon('1993-01-03'),
            'interested_in' => Customer::GENDER_MALE,
            'user_id' => User::create([
                'email' => 'test@test.com',
                'password' => Hash::make(1234)
            ])->id,
//            'profile_image_id' => Image::create([
//                'path' => 'some/fake/path',
//                'type' => Image::CUSTOMER_TYPE,
//            ])->id
        ]);

        Schema::enableForeignKeyConstraints();
    }
}
