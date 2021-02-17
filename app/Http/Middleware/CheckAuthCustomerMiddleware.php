<?php

namespace App\Http\Middleware;

use App\Models\Customers\Customer;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class CheckAuthCustomerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = User::where('email', $request->email)->first();
        if($user && !Customer::where('user_id', $user->id)->exists()){
            return response([
                'message' => 'User not found',
                'data' => []
            ]);
        }


        return $next($request);
    }
}
