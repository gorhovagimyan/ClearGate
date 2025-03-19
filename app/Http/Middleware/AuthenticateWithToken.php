<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthenticateWithToken
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
        $token = $request->bearerToken() ?? $request->header('Authorization');
        
        if (!$token) {
            return response()->json(['message' => 'Unauthorized. No token provided.'], 401);
        }

        $user = User::where('api_token', $token)->first();
        
        if (!$user) {
            return response()->json(['message' => 'Invalid token.'], 401);
        }

        Auth::login($user);
        
        return $next($request);
    }
} 