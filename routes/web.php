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


Route::group(['middleware' => 'auth'], function() {


	Route::group(['prefix' => 'friend'], function() {
		Route::get('/settings/{id}', 'FriendController@getSettings');
		Route::post('/settings/{id}/attach-account', 'FriendController@postAttachAccount');
		Route::get('/settings/{id}/events/{provider}/{remote_id}', 'FriendController@getModalEvents');
		Route::post('/settings/{id}/events/{provider}/{remote_id}/save', 'FriendController@saveModalEvents');

		Route::get('/list', 'FriendController@getList');
		Route::post('/list', 'FriendController@postAdd');

	});

	Route::get('/', 'TimelineController@getTimeline');

	Route::group(['prefix' => 'profile'], function() {
		Route::get('/edit', 'ProfileController@editProfile');
		Route::post('/edit', 'ProfileController@postEditProfile');
	});

});



Route::group(['prefix' => 'webhook'], function() {
	Route::post('/viber/c7e1fd2e3171a8266d6bdb05dae76eca', 'ViberController@webhook');
	Route::get('/viber/c7e1fd2e3171a8266d6bdb05dae76eca', 'ViberController@webhook');
});


Route::group([], function() {

	Route::get('/login', 'Auth\LoginController@getLogin');
	Route::post('/login', 'Auth\LoginController@postLogin');
	Route::get('/logout', 'Auth\LoginController@getLogout');

	Route::post('/register/send-sms', 'Auth\RegisterController@postSmsConfirmation');
	Route::post('/register', 'Auth\RegisterController@postRegister');

});


Route::group(['prefix' => 'service'], function() {

	Route::get('/token', 'ServiceController@getCsrfToken');

});