<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function GETUser() {
        $user = Auth::guard('api')->user();
        if($user) {
            return response(array(
                'status' => 200,
                'user' => $user->toArray(),
            ));
        } else {
            return response(array(
                'status' => 403,
                'message' => 'User not logged in',
            ));
        }
    }
    public function POSTLogin(Request $request)
    {
        $userRequest = $request->only([
            'email',
            'password',
        ]);
        $rememberParam = $request->only('remember_me');

        $rememberMe = $rememberParam['remember_me'] = '1' ? true : false;

        if(isset($userRequest['email']) && isset($userRequest['password'])) {;
            if($user = Auth::attempt($userRequest, $rememberMe)) {
                $user = Auth::user();
                $token = UserService::generateToken($user);
                return response(array(
                    'status' => 200,
                    'user' => $user->toArray(),
                    'token' => $token,
                    ),200);
            } else {
                return response(array(
                    'status' => 402,
                    'message' => 'Invalid username or password',
                ),200);
            }
        }
    }
}
