<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Facades\JWTAuth;

class JWTAuthentication
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
        try {
            $user = JWTAuth::parseToken()->authenticate();
        }
        catch(TokenExpiredException $e) {
            return response()->json(['success'=>false, 'message'=>'token expired', 401]);
        }
        catch(TokenInvalidException $e) {
            dd($e);
            return response()->json(['success'=>false, 'message'=>'token invalid', 401]);
        }
        catch(JWTException $e) {
            return response()->json(['success'=>false, 'message'=>$e->getMessage(), 401]);
        }
        return $next($request);
    }
}
