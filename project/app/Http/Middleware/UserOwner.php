<?php

namespace App\Http\Middleware;

use Closure;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class UserOwner
{
    public function handle($request, Closure $next, $guard = null)
    {
        try {
            if ($request->header('Authorization')) {
                $decode_token = JWT::decode($request->header('Authorization'), new Key(env('JWT_SECRET'), 'HS256'));

                if (auth()->user()->id == $decode_token->sub) {
                    return $next($request);
                }
            }

            return 'not allowed.';
        } catch (\Exception $e) {

        }
    }
}
