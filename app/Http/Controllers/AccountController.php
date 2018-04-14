<?php

namespace App\Http\Controllers;

use App\Http\Services\MessageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Http\Services\UserService;
use Prologue\Alerts\Facades\Alert;
use Mockery\CountValidator\Exception;
use UxWeb\SweetAlert\SweetAlert;

class AccountController extends Controller
{
    public function GETBasicInfo()
    {
        try {
            $result = UserService::getAccountInfo();

            if($result) {
                return view('account/basic-info', $result);
            }
        } catch (Exception $e) {
            SweetAlert::error('Please log in to access this feature', 'Authorization Error');
            return Redirect::route('login.index');
        }
    }

    public function GETProfilePhotos() {
        $user = Auth::user();
        $userData = ['photos' => []];

        if($user) {
            $userData['photos'] = UserService::getPhotos();
        }
        return view('account/profile-photos', ['userData' => $userData]);
    }

    public function GETMessages() {
        $results = MessageService::getMessages();
        return view('account/messages', ['messages' => $results]);
    }

    public function GETPrivacy() {
        return view('account/privacy');
    }

    public function POSTBasicInfo(Request $request)
    {
        $userUpdate = $request->only([
            'email',
            'firstName',
            'city',
            'age',
            'bio'
        ]);

        try {
            $result = UserService::updateUser($userUpdate);

            if($result->fails()) {
                return Redirect::back()->withErrors($result)->withInput();
            } else {
                SweetAlert::success('Your user information has been successfully updated', 'Information Updated');
                return Redirect::route('basic-info.index');
            }
        } catch (Exception $e) {
            SweetAlert::error('Please log in to access this feature', 'Authorization Error');
            return Redirect::route('login.index');
        }
    }

    public function POSTProfilePhotos(Request $request)
    {
        try {
            $result = UserService::uploadPhoto($request);

            if($result->fails()) {
                return Redirect::back()->withErrors($result)->withInput();
            } else {
                SweetAlert::success('Your photo has been successfully uploaded', 'Photo Uploaded');
                return Redirect::route('profile-photos.index');
            }
        } catch (Exception $e) {
            SweetAlert::error('Please log in to access this feature', 'Authorization Error');
            return Redirect::route('login.index');
        }
    }

    public function POSTMessages(Request $request)
    {
        return;
    }

    public function POSTPrivacy(Request $request)
    {
        return;
    }

    public function DELETEProfilePhotos(Request $request) {
        try {
            $result = UserService::deletePhoto($request);

            if(!$result) {
                return Redirect::back()->withErrors($result)->withInput();
            } else {
                SweetAlert::success('Your photo has been successfully deleted', 'Photo Deleted');
                return Redirect::route('profile-photos.index');
            }
        } catch (Exception $e) {
            SweetAlert::error('Please log in to access this feature', 'Authorization Error');
            return Redirect::route('login.index');
        }
    }
}
