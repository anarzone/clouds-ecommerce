<?php

namespace App\Http\Middleware;

use App\Models\Stuff\Admin;
use Closure;
use Illuminate\Http\Request;

class CheckAdminMiddleware
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
        $response = $next($request);
        if(auth('web')->user() && !Admin::where('user_id', auth('web')->user()->id)->exists()){
            return redirect()->route('manage.logout');
        }
        return $response;
    }
}
