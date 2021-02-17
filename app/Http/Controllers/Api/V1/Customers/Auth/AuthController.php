<?php

namespace App\Http\Controllers\Api\V1\Customers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\RegisterUserRequest;
use App\Http\Requests\V1\StoreCustomerRequest;
use App\Http\Resources\Api\V1\Customer;
use App\Models\User;
use App\Services\CustomerService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{
    private $customerService, $userService;
    public function __construct(CustomerService $customerService, UserService $userService)
    {
        $this->customerService = $customerService;
        $this->userService = $userService;
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function login(Request $request){
        $validator = Validator::make($request->all(),
            [
                'email' => 'required|email',
                'password' => 'required'
            ]
        );

        if($validator->fails()){
            return response()->json([
                "message" => 'Validation failed',
                'status' => config('statuses.error'),
                'statusCode' => Response::HTTP_UNPROCESSABLE_ENTITY,
                'errors' => $validator->getMessageBag()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user = User::where('email', $request->email)->first();

        if(!$user){
            return response()->json([
                'message' => 'Wrong email address',
                'status' => config('statuses.error'),
                'statusCode' => Response::HTTP_UNPROCESSABLE_ENTITY,
                'errors' => [
                    'email' => ['Email does not exist']
                ]

            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        if(Hash::check($request->password, $user->password)){
            $token = $user->createToken('Laravel Password Grant Client')->accessToken;
            $response = [
                'message' => 'Logged in successfully',
                'status' => config('statuses.ok'),
                'statusCode' => Response::HTTP_OK,
                'data' => [
                    'access_token' => $token,
                    'type' => 'Bearer',
                    'personal_details' => new Customer($user->customer)
                ]
            ];
            return response($response, 200);
        }else{
            return response()->json([
                "message" => 'Validation failed',
                'status' => config('statuses.error'),
                'statusCode' => Response::HTTP_UNPROCESSABLE_ENTITY,
                'errors' => [
                    'password' => ['Password does not match']
                ]

            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function logout(Request $request){
        $token = $request->user()->token();
        $token->revoke();
        $response = [
            'message' => 'You have been successfully logged out!',
            'statusCode' => Response::HTTP_OK,
            'data' => []
        ];

        return response($response, 200);
    }

    public function register(RegisterUserRequest $request){
        $this->customerService->save($request);

        $user = User::where('email', $request->email)->first();

        return response()->json([
            'message' => 'Registered successfully',
            'status' => config('statuses.ok'),
            'statusCode' => Response::HTTP_CREATED,
            'data' => [
                'access_token' => $user->createToken('Laravel Password Grant Client')->accessToken,
                'type' => 'Bearer',
                'personal_details' => new Customer($user->customer)
            ]
        ], Response::HTTP_CREATED);
    }

    public function me(){
        return response([
            'message' => 'Personal details',
            'statusCode' => Response::HTTP_OK,
            'status' => config('statuses.ok'),
            'data' => new Customer(auth('api')->user()->customer)
        ]);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            "message" => "Logged in successfully",
            'statusCode' => Response::HTTP_OK,
            "data" => [
                'access_token' => $token,
                'token_type' => 'Bearer',
                'expires_in' => auth('auth:api')->factory()->getTTL() * 60
            ]
        ]);
    }

    public function updatePersonalDetails(StoreCustomerRequest $request){
        return response()->json([
            'message' => 'Personal details updated',
            'statusCode' => Response::HTTP_OK,
            'status' => config('statuses.ok'),
            'data' => new Customer($this->customerService->save($request->merge([
                'customer_id' => auth()->user()->customer->id,
                'user_id' => auth()->user()->id,
            ]))),
        ]);
    }

    public function updatePassword(Request $request){
        $validator = Validator::make($request->all(), [
            'old_password' => 'required|min:8',
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required|min:8',
        ]);

        if($validator->fails()){
            return response()->json([
                "message" => 'Validation failed',
                'status' => config('statuses.error'),
                'statusCode' => Response::HTTP_UNPROCESSABLE_ENTITY,
                'errors' => $validator->getMessageBag()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if(!Hash::check($request->old_password, auth()->user()->password)){
            return response()->json([
                "message" => 'Validation failed',
                'status' => config('statuses.error'),
                'statusCode' => Response::HTTP_UNPROCESSABLE_ENTITY,
                'errors' => [
                    'old_password' => ['Old password is not correct']
                ]
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $this->userService->updatePassword(auth('api')->user()->id, $request->password);

        return response()->json([
            'message' => 'Password updated',
            'statusCode' => Response::HTTP_OK,
            'status' => config('statuses.ok'),
            'data' => [],
        ]);
    }
}
