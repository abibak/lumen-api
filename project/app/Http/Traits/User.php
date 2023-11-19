<?php

namespace App\Http\Traits;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;

trait User
{
    public function decode_token(string $token)
    {
        return JWT::decode($token, new Key(env('JWT_SECRET'), 'HS256'));
    }

    public function owner($token)
    {
        return $this->decode_token($token)->sub ?? '';
    }
}
