<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use UxWeb\SweetAlert\SweetAlert;
use App\Http\Services\MessageService;
use Illuminate\Support\Facades\Auth;

class MessagesController extends Controller
{
    public function POSTSendNewMessage(Request $request) {
        try {
            $result = MessageService::sendMessage($request);

            if(!$result) {
                return Redirect::route('night-out-search.index');
            } else {
                SweetAlert::success('Message Sent');
                return Redirect::route('night-out-search.index');
            }
        } catch (Exception $e) {
            SweetAlert::error('Please log in to access this feature', 'Authorization Error');
            return Redirect::route('login.index');
        }
    }

    public function GETMessage($id) {
        try {
            $result = MessageService::getThread($id);

            if(!$result) {
                return Redirect::route('messages.index');
            } else {
                return view('account/view-message', ['messages' => $result[0], 'otherUser' => $result[1], 'currentUser' => Auth::id()]);
            }
        } catch (Exception $e) {
            SweetAlert::error('Please log in to access this feature', 'Authorization Error');
            return Redirect::route('login.index');
        }
    }

    public function POSTSendMessage($id, Request $request) {
        try {
            $result = MessageService::sendMessage($request);

            if(!$result) {
                return Redirect::route('view-message.index');
            } else {
                $result = MessageService::getThread($id);
                return view('account/view-message', ['messages' => $result[0], 'otherUser' => $result[1], 'currentUser' => Auth::id()]);
            }
        } catch (Exception $e) {
            SweetAlert::error('Please log in to access this feature', 'Authorization Error');
            return Redirect::route('login.index');
        }
    }
}