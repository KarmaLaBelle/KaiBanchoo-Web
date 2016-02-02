<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['middleware' => 'web'], function () {
    // Auth
    Route::auth();

    Route::post('/login', 'Auth\customLogin@login');

    // User Avatar for the game
    Route::get('/{user}', function(App\User $user = null) {
        if(isset($user) && $user->avatar != "")
        {
            $img = Image::make($user->avatar)->resize(128, 128);
        } else {
            $img = Image::make(config('bancho.defaultAvatar'));
        }
        return $img->response();
    })->where('user', '[0-9]+');

    Route::get('/u/{userid}', 'userProfile@getProfile')->where('userid', '[0-9]+');

    // Dashboard
    Route::get('/dashboard', 'dashboard@index');
    Route::get('/dashboard/avatar', 'dashboard@getAvatarPage');
    Route::post('/dashboard/avatar', 'dashboard@postAvatarPage');

    // Index
    Route::get('/', 'Index@getIndex');
    Route::get('/home', 'HomeController@index');
});

Route::post('/', 'Index@postIndex');
Route::get('/{section}', 'Debug@getDebug')->where(['section' => '.*']);
Route::post('/{section}', 'Debug@postDebug')->where(['section' => '.*']);
