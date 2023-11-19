<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Firebase\JWT\JWT;

class UserController extends Controller
{
    use \App\Http\Traits\User;

    public function __construct()
    {
    }

    protected function jwt(User $user)
    {
        $payload = [
            'sub' => $user->id,
            'iat' => time(),
            'exp' => time() + 60 * 60
        ];

        return JWT::encode($payload, env('JWT_SECRET'), 'HS256');
    }

    public function index()
    {
        $users = User::with('winners')->get();

        return response()->json([
            'data' => $users,
        ], 200);
    }

    public function register(Request $request, UserRequest $userRequest)
    {
        $validate = $userRequest->validate($request->all(), 'register');

        if (!empty($validate)) {
            return response()->json([
                'errors' => $validate
            ]);
        }

        $user = User::create(array_merge(request()->all()));

        return response()->json([
            'data' => $user,
            'message' => 'Success register',
        ]);
    }

    public function login(Request $request, UserRequest $userRequest)
    {
        $validate = $userRequest->validate($request->all(), 'login');

        if (!empty($validate)) {
            return response()->json([
                'errors' => $validate
            ]);
        }

        $user = User::where('email', "=", $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            $token = $this->jwt($user);

            return response()->json([
                'token' => $token
            ]);
        }

        return response()->json(['errors' => 'User not found.']);
    }

    public function update($id, Request $request, UserRequest $userRequest)
    {
        $validate = $userRequest->validate($request->all(), 'update');

        if (!empty($validate)) {
            return response()->json([
                'errors' => $validate
            ]);
        }

        try {
            if ($id != $this->owner($request->header('Authorization'))) {
                throw new \Exception('Error update user.');
            }

            $user = User::where('id', '=', $id)->first();

            if ($user && $user->update($request->all())) {
                return response()->json([
                    'data' => $user,
                    'message' => 'Updated'
                ], 200);
            }
        } catch (\Exception $e) {
            return response()->json([
                'errors' => $e->getMessage(),
            ]);
        }

    }

    public function destroy($id, Request $request)
    {
        try {
            $id = (!is_numeric($id) ? throw new \Exception('Error delete user.') : $id);

            if ($id != $this->owner($request->header('Authorization'))) {
                throw new \Exception('Error delete user.');
            }

            $user_delete = User::where('id', '=', $id)->delete();

            if ($user_delete) {
                return response()->json(['message' => 'User deleted'], 200);
            }


        } catch (\Exception $e) {
            return response()->json([
                'errors' => $e->getMessage(),
            ]);
        }
    }
}
