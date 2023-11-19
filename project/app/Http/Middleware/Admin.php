<?php

namespace App\Http\Middleware;


use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Factory as Auth;

class Admin
{
    protected $auth;

    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    public function handle(Request $request, \Closure $next, $guard = null)
    {
        if ($this->auth->guard($guard)->guest()) {
            return response('Unauthorized.', 401);
        }

        if (auth()->user()->is_admin) {
            return $next($request);
        }

        return response(['message' => 'Not allowed'], 403);
    }
}
