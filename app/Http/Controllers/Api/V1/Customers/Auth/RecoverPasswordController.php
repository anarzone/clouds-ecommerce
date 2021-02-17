<?php

namespace App\Http\Controllers\Api\V1\Customers\Auth;

use App\Events\SendMail;
use App\Http\Controllers\Controller;
use App\Models\OtpAuthentication;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RecoverPasswordController extends Controller
{
    public function reset(Request $request)
    {
        $rules = [
            'email' => 'required|email|exists:users',
        ];


        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid email',
                'status' => config('statuses.error'),
                'statusCode' => Response::HTTP_UNPROCESSABLE_ENTITY,
                'errors' => $validator->getMessageBag()

            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return $this->sendOtp($request->email);
    }

    public function verifyOtp(Request $request){
        $validator = Validator::make($request->all(), [
            'otp_code' => 'required',
            'token' => 'required|string'
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => 'Errors',
                'status' => config('statuses.error'),
                'statusCode' => Response::HTTP_UNPROCESSABLE_ENTITY,
                'errors' => $validator->getMessageBag()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $otpAuth = OtpAuthentication::where('token', $request->token)->first();

        if($otpAuth && $this->checkOtpTokenExpireDate($request->token)){

            if($request->otp_code == $otpAuth->otp){
                $response = [
                    'message' => 'Otp code confirmed',
                    'status' => config('statuses.ok'),
                    'statusCode' => Response::HTTP_OK,
                    'data' => []
                ];

                $status = Response::HTTP_OK;
            }else{
                $response = [
                    'message' => 'Otp code is incorrect',
                    'status' => config('statuses.error'),
                    'statusCode' => Response::HTTP_UNPROCESSABLE_ENTITY,
                    'errors' => [
                        'otp_code' => ['Wrong otp code']
                    ]
                ];
                $status = Response::HTTP_UNPROCESSABLE_ENTITY;
            }
        }else{
            $response = [
                'message' => 'Token expired or incorrect',
                'status' => config('statuses.error'),
                'statusCode' => Response::HTTP_UNPROCESSABLE_ENTITY,
                'errors' => [
                    'token' => ['Token is expired or incorrect']
                ]
            ];
            $status = Response::HTTP_UNPROCESSABLE_ENTITY;
        }

        return response()->json($response, $status);
    }

    public function recover(Request $request){
        $rules = [
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required|min:8',
            'token' => 'required|string|exists:otp_authentication'
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
            return response()->json([
                'message' => 'Errors',
                'status' => config('statuses.error'),
                'statusCode' => Response::HTTP_UNPROCESSABLE_ENTITY,
                'errors' => $validator->getMessageBag()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if(!$this->checkOtpTokenExpireDate($request->token)){
            return response()->json([
                'message' => 'Token is expired',
                'status' => config('statuses.error'),
                'statusCode' => Response::HTTP_UNPROCESSABLE_ENTITY,
                'errors' => [
                    'token' => 'Token is expired'
                ]
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $otp = OtpAuthentication::where('token', $request->token)->first();


        User::where('email', $otp->email)->update(['password' => Hash::make($request->password)]);

        return response()->json([
            'message' => 'Password updated',
            'status' => config('statuses.ok'),
            'statusCode' => Response::HTTP_CREATED,
            'data' => []
        ], Response::HTTP_CREATED);
    }

    public function sendOtp($email){
        $otp = $this->otpGenerator();
        $token = Str::random(60);

        OtpAuthentication::create([
            'otp' => 1234,
            'email' => $email,
            'token' => $token,
            'expired' => Carbon::now()->addMinutes(15)->toDateTimeString(),
        ]);

        Event::dispatch(new SendMail(
            $email,
            'Şifrə bərpa kodu',
            $this->otpGenerator(),
            'mail.otp'
        ));

        return response()->json([
            'message' => 'Token generated successfully',
            'status' => config('statuses.ok'),
            'statusCode' => Response::HTTP_OK,
            'data' => [
                'token' => $token,
                'otp_code' => 1234
            ]
        ]);
    }

    public function resendOtp(Request $request){
        $validator = Validator::make($request->all(), [
            'token' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid token',
                'status' => config('statuses.error'),
                'statusCode' => Response::HTTP_UNPROCESSABLE_ENTITY,
                'errors' => $validator->getMessageBag()

            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $otpAuth = OtpAuthentication::where('token', $request->token)->first();


        if($otpAuth && $this->checkOtpTokenExpireDate($request->token)){
            $otpAuth->update(['expired' => Carbon::parse($otpAuth->expired_date)->addMinutes(-15)->toDateTimeString()]);
            return $this->sendOtp($otpAuth->email);
        }
        return response()->json([
            'message' => 'Token expired or incorrect',
            'status' => config('statuses.error'),
            'statusCode' => Response::HTTP_UNPROCESSABLE_ENTITY,
            'errors' => [
                'token' => ['Token is expired or incorrect']
            ]
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function otpGenerator(){
        $alphaNum = range('0','9');
        shuffle($alphaNum);
        $otp = '';
        for($i = 0; $i < 3; $i++){
            $otp .= $alphaNum[$i];
        }
        return $otp;
    }

    public function checkOtpTokenExpireDate($token){
        $otp = OtpAuthentication::where('token', $token)->first();
        return Carbon::parse(Carbon::now())->diffInMinutes($otp->expired) < 15;
    }
}
