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

Route::get('/', function () {
    return view('welcome');
});

Route::post('/', "PostHandler@handle");

Route::get('/web/bancho_connect.php', function () {
    return "";
});

Route::post('/web/osu-metrics.php', "Logging@Metrics");
Route::post('/web/osu-error.php', "Logging@Error");

Route::get('/web/osu-osz2-getscores.php', "Beatmap@getScores");
Route::post('/web/osu-submit-modular.php', "Beatmap@submitModular");

/*
Route::get('/version', function () {
    return "This is running KaiBanchoo! Version Zoozlez";
});
*/
Route::get('/{thingy}', "Debug@getThingy")->where(['thingy' => '.*']);
Route::post('/{thingy}', "Debug@getThingy")->where(['thingy' => '.*']);
