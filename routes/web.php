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

Route::get('/', function () {
    return view('welcome');
});


Route::get('auth/callback/twitch', 'SocialAuthController@callback');
Route::get('login', [ 'as' => 'login', 'uses' => 'SocialAuthController@redirect']);
Route::get('logout', 'SocialAuthController@logout');

Route::resource('streamers', 'StreamersController');

Route::post('/streamers/{streamer}/notes', 'StreamerNotesController@store');
Route::get('/streamers/{streamer}/notes', 'StreamerNotesController@get');
Route::get('/notes', 'StreamerNotesController@getAll');
Route::delete('/streamers/{streamer}/notes/{note}', 'StreamerNotesController@destroy');
Route::patch('/streamers/{streamer}/notes/{note}', 'StreamerNotesController@update');
