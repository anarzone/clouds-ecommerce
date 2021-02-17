<?php

namespace App\Http\Controllers\Api\V1\Customers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customers\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{
    // just for test
    public function redirectProvider($provider){
        return Socialite::driver($provider)->redirect();
    }

    // just for test
    public function handleCallback($provider){
        $user = Socialite::driver($provider)->user();
        dd($user);
    }


    public function handleGetUserFacebook(){
        // validation
        $userData = Socialite::driver('facebook')->userFromToken(request()->get('access_token'));
        return $this->findOrCreateUser($userData->user);

    }

    public function handleGetUserFromGoogle(){
         // validation
        $userData = Socialite::driver('google')->userFromToken(request()->get('access_token'));
        return $this->findOrCreateUser($userData);
    }

    public function findOrCreateUser($userData){
        if (!$loggedUser = User::where('email', $userData->user['email'])->first()){
            $loggedUser = User::create([
                'email' => $userData->getEmail()
            ]);

            return Customer::create([
                'user_id' => $loggedUser->id,
                'firstname' => explode(' ', $userData->getName())[0],
                'lastname' => explode(' ', $userData->getName())[1],
            ]);
        }

        return response([
            'message' => 'Logged in successfully',
            'statusCode' => Response::HTTP_OK,
            'access_token' => $loggedUser->createToken('Laravel Password Grant Client')->accessToken,
            'type' => 'Bearer'
        ], 200);
    }
}
