<?php

namespace App\Http\Requests;

class UserRequest extends Request
{
    public function rules($action)
    {
        switch ($action) {
            case 'login':
                return [
                    'email' => 'bail|string|email',
                    'password' => 'bail|required|string',
                ];

            case 'register':
                return [
                    'first_name' => 'bail|string|required|max:255',
                    'last_name' => 'bail|string|required|max:255',
                    'email' => 'bail|string|email|unique:users',
                    'points' => 'bail|required|int',
                    'password' => 'bail|required|string',
                ];

            case 'update':
                return [
                    'first_name' => 'bail|string|max:255',
                    'last_name' => 'bail|string|max:255',
                    'email' => 'bail|string|email|unique:users',
                    'password' => 'bail|string',
                ];
        }
    }
}
