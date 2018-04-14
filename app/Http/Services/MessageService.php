<?php
/**
 * Created by PhpStorm.
 * User: Mitchell
 * Date: 2017-04-07
 * Time: 12:13 AM
 */

namespace App\Http\Services;

use App\Http\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Mockery\CountValidator\Exception;
use Carbon\Carbon;
use Cmgmyr\Messenger\Models\Message;
use Cmgmyr\Messenger\Models\Participant;
use Cmgmyr\Messenger\Models\Thread;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class MessageService
{
    public static function getMessages() {
        $user = Auth::user();

        if(!is_null($user)) {
            $messagePreviews = [];
            $threads = Thread::forUser($user->id)->get();
            foreach($threads as $thread) {

                $otherUserId = $thread->participantsUserIds($user->id);
                $otherUserData = User::where([
                    ['id', '=', $otherUserId[0]],
                ])
                    ->select('users.firstName', 'users.city', 'users.age', 'users.bio', 'users.image_slug')
                    ->get();
                $images = UserService::getImages($otherUserData[0]);
                $otherUserData[0]['images'] = $images;
                $latestMessage = $thread->getLatestMessageAttribute();
                $unreadMessage = $thread->isUnread($user->id) == true ? 'true': 'false';

                if(strlen($latestMessage->body) > 25) {
                    $latestMessage->body = substr($latestMessage->body, 0, 25) . '....';
                }

                $messagePreview = [
                    'otherUser'     => $otherUserData[0],
                    'latestMessage' => $latestMessage,
                    'isUnread'      => $unreadMessage,
                ];

                array_push($messagePreviews, $messagePreview);
            }

            return $messagePreviews;
        } else {
            throw new Exception('User not authorized');
        }
    }
    public static function sendMessage($data) {
        $user = Auth::user();

        if(!is_null($user)) {

            $userId = $data['userId'];
            $message = $data['message'];

            $fieldConstraints = [
                'message'       => 'Min:1',
                'userId'        => 'exists:users,id',
            ];

            $fields = [
                'message'       => $message,
                'userId'        => $userId,
            ];

            $validator = Validator::make($fields, $fieldConstraints);

            if(!$validator->fails()) {
                //Valid user provided, try to send the message
                $existingThreads = Thread::forUser($user->id)->get();
                $exists = false;

                foreach($existingThreads as $thread) {
                    if($thread->participants()->get()[0]['user_id'] == $userId || $thread->participants()->get()[1]['user_id'] == $userId) {
                        $exists = true;
                        $threadId = $thread->id;
                    }
                }

                if(!$exists) {
                    $thread = Thread::create(
                        [
                            'subject' => '',
                        ]
                    );
                    // Message
                    Message::create(
                        [
                            'thread_id' => $thread->id,
                            'user_id'   => $user->id,
                            'body'      => $message,
                        ]
                    );
                    // Sender
                    Participant::create(
                        [
                            'thread_id' => $thread->id,
                            'user_id'   => $user->id,
                            'last_read' => new Carbon,
                        ]
                    );
                    // Recipients
                    $thread->addParticipant($userId);
                } else {
                    // Message
                    Message::create(
                        [
                            'thread_id' => $threadId,
                            'user_id'   => $user->id,
                            'body'      => $message,
                        ]
                    );
                }
            }

            return $validator;
        } else {
            throw new Exception('User not authorized');
        }
    }

    public static function getThread($id) {
        $user = Auth::user();

        if(!is_null($user)) {
            try {
                $thread = Thread::findOrFail($id);
            } catch (ModelNotFoundException $e) {
                throw new Exception('Thread not found');
            }

            $participants = $thread->participants()->get();
            $valid = false;
            $otherParticipant = -1;

            foreach($participants as $participant) {
                if($participant->user_id == $user->id) {
                    $valid = true;
                } else {
                    $otherParticipant = $participant->user_id;
                }
            }

            if($valid) {
                //User is viewing a conversation they are part of
                $thread->markAsRead($user->id);

                return [$thread->messages()->get(), $otherParticipant];
            } else {
                throw new Exception('User is not part of this conversation');
            }

        } else {
            throw new Exception('User not authorized');
        }
    }
}