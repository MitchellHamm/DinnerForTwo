<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Prologue\Alerts\Facades\Alert;
use App\Http\Services\UserService;

class RegisterController extends Controller
{
    public function GETRegister()
    {
        return view('register');
    }

    public function POSTRegister(Request $request)
    {
        $newUser = $request->only([
            'email',
            'password',
            'passwordConfirm',
        ]);
        $paramConstraints = [
            'email' => 'required|unique:users|max:255|Email',
            'password' => 'required|min:8',
            'passwordConfirm' => 'required|min:8',
        ];
        $validator = Validator::make($newUser, $paramConstraints);

        if($validator->fails()) {
            //Handle input errors
            return Redirect::back()->withErrors($validator)->withInput();
        } else {
            $user = UserService::createUser($newUser);

            Auth::login($user);

            alert()->success('Your account has been successfully created! Take a minute to finish you profile for others to see.', 'Account Created!')->persistent('Close');

            return Redirect::route('basic-info.index');
        }
    }
}
