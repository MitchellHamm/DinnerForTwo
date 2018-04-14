<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Http\Services\UserService;
use Prologue\Alerts\Facades\Alert;
use Mockery\CountValidator\Exception;
use UxWeb\SweetAlert\SweetAlert;

class NightOutController extends Controller
{
    public function GETNightOut() {
        try {
            $result = UserService::getUserListing();
            $activities = UserService::getActivities();

            if(!$result) {
                return view('night-out/night-out', ['activities' => $activities]);
            } else {
                return Redirect::route('night-out-search.index');
            }
        } catch (Exception $e) {
            SweetAlert::error('Please log in to access this feature', 'Authorization Error');
            return Redirect::route('login.index');
        }
    }

    public function GETNightOutSearch() {
        try {
            $result = UserService::getUserListing();

            if($result) {
                $searchResults = UserService::searchAvailableUsers();
                return view('night-out/night-out-search', [
                    'currentActivity' => $result['activity_id'],
                    'results' => $searchResults]);
            } else {
                return Redirect::route('night-out.index');
            }
        } catch (Exception $e) {
            SweetAlert::error('Please log in to access this feature', 'Authorization Error');
            return Redirect::route('login.index');
        }
    }

    public function POSTNightOut(Request $request) {
        try {
            $result = UserService::listUser($request);

            if(!$result) {
                return Redirect::back()->withErrors($result)->withInput();
            } else {
                return Redirect::route('night-out-search.index');
            }
        } catch (Exception $e) {
            SweetAlert::error('Please log in to access this feature', 'Authorization Error');
            return Redirect::route('login.index');
        }
    }

    public function POSTUpdateActivity(Request $request) {
        try {
            $result = UserService::updateListing($request);

            if(!$result) {
                return Redirect::back()->withErrors($result)->withInput();
            } else {
                return Redirect::route('night-out-search.index');
            }
        } catch (Exception $e) {
            SweetAlert::error('Please log in to access this feature', 'Authorization Error');
            return Redirect::route('login.index');
        }
    }
}
