<?php


namespace App\Http\Services;

use App\Http\Models\Activity;
use App\Http\Models\User;
use App\Http\Models\Image;
use App\Http\Models\AvailableUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManagerStatic;
use Mockery\CountValidator\Exception;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManager;

class UserService
{
    /*
    * @param $data: Expected array of user data
    * @return User model
    */
    public static function createUser($data) {
        if($data['password'] != $data['passwordConfirm']) {
            return 'Error, passwords do not match';
        }
        $data['password'] = Hash::make($data['password']);
        $data['image_slug'] = str_pad(rand(0, pow(10, 15)-1), 15, '0', STR_PAD_LEFT);
        $data['api_token'] = str_random(60);
        $user = User::create($data);
        return $user;
    }
    
    public static function generateToken($user) {
        $token = str_random(60);
        $data = [
            'api_token' => $token,
        ];

        $user->fill($data);
        $user->save();

        return $token;
    }

    /*
    * @param $data: Expected array of user data
    * @return User model
    */
    public static function updateUser($data) {
        $user = Auth::user();

        if(!is_null($user)) {
            $fieldConstraints = [
                'firstName'     => 'Min:2|Max:50|Alpha',
                'city'          => 'Min:2|Max:50|Alpha',
                'age'           => 'numeric',
                'bio'           => 'Min:2|Max:255',
                'email'         => 'Required|Between:3,64|Email|Unique:users,email' . ($user->id ? ",$user->id" : ''),
            ];

            $validator = Validator::make($data, $fieldConstraints);

            if(!$validator->fails()) {
                $user->fill($data);
                $user->save();
            }

            return $validator;
        } else {
            throw new Exception('User not authorized');
        }
    }

    public static function getAccountInfo() {
        $user = Auth::user();

        if($user) {
            $userData = [
                'email' => $user['email'],
                'firstName' => $user['firstName'],
                'city' => $user['city'],
                'age' => $user['age'],
                'bio' => $user['bio'],
            ];
            return $userData;
        } else {
            throw new Exception('User not authorized');
        }
    }

    public static function uploadPhoto(Request $data) {
        $user = Auth::user();

        $photoUpload = $data->only([
            'pic',
        ]);

        if(!is_null($user)) {
            $fieldConstraints = [
                'pic'     => ['image', Rule::dimensions()->maxWidth(3000)->maxHeight(3000)],
            ];

            $extension = Input::file('pic')->getClientOriginalExtension();
            $imagePath = 'images/' . $user['image_slug'];
            $fileName = time() . '.' . $extension;
            $imageName = 'images/' . $user['image_slug'] . '/' . $fileName;

            $validator = Validator::make($photoUpload, $fieldConstraints);

            if(!$validator->fails()) {
                if(!File::exists($imagePath)) {
                    // path does not exist
                    File::makeDirectory($imagePath, 0777, true, true);
                }
                $image = ImageManagerStatic::make($data->pic);
                $image->save($imageName);
                    //$data->pic->storeAs($imagePath, $fileName);
                if($image) {
                    Image::create(['user_id' => $user['id'], 'image_path' => $imageName]);
                }
            }

            return $validator;
        } else {
            throw new Exception('User not authorized');
        }
    }

    public static function getPhotos() {
        $user = Auth::user();
        $images = [];

        if($user) {
            $pathArray = Image::where('user_id', $user->id)
                ->get()->toArray();

            $pathToImages = 'images/' . $user['image_slug'];

            if(!File::exists($pathToImages)) {
                return [];
            }

            $files = File::allFiles($pathToImages);
            foreach($files as $file) {

                array_push($images, $pathToImages . '/' . $file->getFilename());
            }
            return $images;
        } else {
            return [];
        }
    }

    public static function deletePhoto(Request $data) {
        $user = Auth::user();

        $photoUpload = $data->only([
            'pic',
        ]);

        if(!is_null($user)) {

            $pieces = explode("/", $photoUpload['pic']);
            $folder = $pieces[1];
            $file = $pieces[2];

            $result = DB::table('user_images')->where([
                ['user_id', '=', $user['id']],
                ['image_path', '=', $photoUpload['pic']],
                ])
                ->get();

            if($result->count()) {
                if(File::exists($photoUpload['pic'])) {
                    // path exists
                    DB::table('user_images')->where([
                        ['user_id', '=', $user['id']],
                        ['image_path', '=', $photoUpload['pic']],
                    ])
                        ->delete();
                    File::delete($photoUpload['pic']);
                    return true;
                } else {
                    //Delete entry if the file doesn't exist
                    //THIS SHOULD NEVER HAPPEN
                    DB::table('user_images')->where([
                        ['user_id', '=', $user['id']],
                        ['image_path', '=', $photoUpload['pic']],
                    ])
                        ->delete();
                    return false;
                }
            } else {
                return false;
            }

        } else {
            throw new Exception('User not authorized');
        }
    }

    public static function getActivities() {
        return Activity::all();
    }

    public static function listUser(Request $data) {
        $user = Auth::user();

        $activity = $data->only([
            'activity',
        ]);

        if(!is_null($user)) {
            //List the user
            $expiresAt = date('Y-m-d H:i:s', time() + 60*60*16);
            $userId = $user->id;
            $city = $user->city;

            $activity_id = DB::table('activities')->where([
                'activity_name' => $activity['activity'],
            ])->get();

            if($activity_id->count()) {
                AvailableUser::create([
                    'user_id' => $userId,
                    'activity_id' => $activity_id->get(0)->id,
                    'expires_at' => $expiresAt,
                    'city' => $city,
                ]);
            } else {
                throw new Exception('Invalid activity');
            }
            return true;
        } else {
            throw new Exception('User not authorized');
        }
    }

    public static function getUserListing() {
        $user = Auth::user();

        if(!is_null($user)) {
            $result = DB::table('available_users')->where([
                'user_id' => $user->id,
            ])->get();

            if(count($result)) {
                return json_decode(json_encode($result->get(0)), true);
            } else {
                return false;
            }
        } else {
            throw new Exception('User not authorized');
        }
    }
    public static function updateListing(Request $data) {
        $user = Auth::user();

        if(!is_null($user)) {
            $result = DB::table('available_users')->where([
                'user_id' => $user->id,
            ])->get();

            if(count($result)) {
                $activity = $data->only([
                    'activity',
                ]);

                $activity_id = DB::table('activities')->where([
                    'activity_name' => $activity['activity'],
                ])->get();

                $result = AvailableUser::where('user_id', $user->id)
                                                ->update(['activity_id' => $activity_id->get(0)->id]);

                $result = DB::table('available_users')->where([
                    'user_id' => $user->id,
                ])->get();

                return json_decode(json_encode($result->get(0)), true);
            } else {
                throw new Exception('Listing does not exist');
            }
        } else {
            throw new Exception('User not authorized');
        }
    }

    public static function searchAvailableUsers() {
        $user = Auth::user();

        if(!is_null($user)) {

            $activityId = UserService::getUserListing();

            $results = User::where([
                ['available_users.city', '=', $user->city],
                ['available_users.user_id', '!=', $user->id],
                ['available_users.activity_id', '=', $activityId['activity_id']],
                ['available_users.expires_at', '>', date('Y-m-d H:i:s', time())],
                ])
                ->join('available_users', 'available_users.user_id', '=', 'users.id')
                ->select('users.id','users.firstName', 'users.city', 'users.age', 'users.bio', 'users.image_slug', 'available_users.*')
                ->take(25)
                ->get();

            $users = [];

            for($i = 0; $i < count($results); $i++) {
                $images = self::getImages($results[$i]);

                array_push($users, [
                    'id'            => $results[$i]->id,
                    'firstName'     => $results[$i]->firstName,
                    'age'           => $results[$i]->age,
                    'city'          => $results[$i]->city,
                    'bio'           => $results[$i]->bio,
                    'images'        => $images,
                ]);
            }

            return $users;
        } else {
            throw new Exception('User not authorized');
        }
    }

    public static function getImages($user) {
        $imageSlug = 'images/'. $user['image_slug'];
        $images = [];

        if(File::exists($imageSlug)) {
            $files = File::allFiles($imageSlug);
            foreach($files as $file) {

                array_push($images, $imageSlug . '/' . $file->getFilename());
            }

        }

        return $images;
    }
}