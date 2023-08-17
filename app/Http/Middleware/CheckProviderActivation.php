<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Provider;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckProviderActivation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
    {
        // return $next($request);
        $data=Provider::where('phone',$request->phone)->first();
        if($data['activation']=='active'){
            return $next($request);
    } else {
        return response()->json(['status' => 'fail', 'message' => 'your account is not activated'], 403);
    }
    }
    }
}
