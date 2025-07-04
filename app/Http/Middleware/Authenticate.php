<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\JsonResponse)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            // حاول تستخرج المستخدم من التوكن
            $user = JWTAuth::parseToken()->authenticate();
        } catch (JWTException $e) {
            // لو فيه مشكلة في التوكن، ارجع Unauthorized
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
