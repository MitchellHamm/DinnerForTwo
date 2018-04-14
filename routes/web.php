<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [
    'as'     => 'welcome.index',
    'uses'   => 'WelcomeController@GETWelcome'
]);

Route::get('login', [
    'as'     => 'login.index',
    'uses'   => 'LoginController@GETLogin'
]);

Route::post('login', [
    'as'     => 'login.submit',
    'uses'   => 'LoginController@POSTLogin'
]);

Route::get('logout', [
    'as'    => 'logout.index',
    'uses'  => 'LogoutController@GETLogout'
]);

Route::get('register', [
    'as'     => 'register.index',
    'uses'   => 'RegisterController@GETRegister'
]);

Route::post('register', [
    'as'     => 'register.submit',
    'uses'   => 'RegisterController@POSTRegister'
]);

Route::group(['prefix' => 'account'], function () {
    Route::get('basic-info', [
        'as'    => 'basic-info.index',
        'uses'  => 'AccountController@GETBasicInfo'
    ]);

    Route::post('basic-info', [
        'as'    => 'basic-info.submit',
        'uses'  => 'AccountController@POSTBasicInfo'
    ]);

    Route::get('view-message/{id}', [
        'as'    => 'view-message.index',
        'uses'  => 'MessagesController@GETMessage'
    ]);

    Route::post('view-message/{id}', [
        'as'    => 'view-message.submit',
        'uses'  => 'MessagesController@POSTSendMessage'
    ]);

    Route::get('messages', [
        'as'    => 'messages.index',
        'uses'  => 'AccountController@GETMessages'
    ]);

    Route::post('messages', [
        'as'    => 'messages.submit',
        'uses'  => 'AccountController@POSTMessages'
    ]);

    Route::get('profile-photos', [
        'as'    => 'profile-photos.index',
        'uses'  => 'AccountController@GETProfilePhotos'
    ]);

    Route::post('profile-photos', [
        'as'    => 'profile-photos.submit',
        'uses'  => 'AccountController@POSTProfilePhotos'
    ]);

    Route::post('profile-photos/delete', [
        'as'    => 'profile-photos.delete',
        'uses'  => 'AccountController@DELETEProfilePhotos'
    ]);

    Route::get('privacy', [
        'as'    => 'privacy.index',
        'uses'  => 'AccountController@GETPrivacy'
    ]);

    Route::post('privacy', [
        'as'    => 'privacy.submit',
        'uses'  => 'AccountController@POSTPrivacy'
    ]);
});

Route::get('search', [
    'as'    => 'night-out-search.index',
    'uses'  => 'NightOutController@GETNightOutSearch'
]);

Route::post('night-out', [
    'as'    => 'night-out.submit',
    'uses'  => 'NightOutController@POSTNightOut'
]);

Route::get('night-out', [
    'as'    => 'night-out.index',
    'uses'  => 'NightOutController@GETNightOut'
]);

Route::post('night-out-update', [
    'as'    => 'night-out.update',
    'uses'  => 'NightOutController@POSTUpdateActivity'
]);

Route::get('account', function () {
    return redirect('account/basic-info');
});

Route::post('send-message', [
    'as'    => 'send-message.submit',
    'uses'  => 'MessagesController@POSTSendNewMessage'
]);

/*Route::group(['prefix' => 'messages'], function () {
    Route::get('/', ['as' => 'messages', 'uses' => 'MessagesController@index']);
    Route::get('create', ['as' => 'messages.create', 'uses' => 'MessagesController@create']);
    Route::post('/', ['as' => 'messages.store', 'uses' => 'MessagesController@store']);
    Route::get('{id}', ['as' => 'messages.show', 'uses' => 'MessagesController@show']);
    Route::put('{id}', ['as' => 'messages.update', 'uses' => 'MessagesController@update']);
});*/