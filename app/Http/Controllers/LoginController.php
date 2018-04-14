<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\MessageBag;

class LoginController extends Controller
{
    public function GETLogin()
    {
        return view('login');
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
                return Redirect::route('basic-info.index');
            } else {
                $errors = new MessageBag(['password' => ['Email and/or password invalid']]);
                return Redirect::back()->withErrors($errors)->withInput();
            }
        }
    }
}
