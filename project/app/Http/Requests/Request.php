<?php

namespace App\Http\Requests;

use Dotenv\Exception\ValidationException;
use Illuminate\Support\Facades\Validator;

abstract class Request
{
    public function validate(array $data, $action = '')
    {
        $validator = Validator::make($data, $this->rules($action));

        if ($validator->fails()) {
            return $validator->errors()->toArray();
        }
    }

    abstract protected function rules($action);
}
