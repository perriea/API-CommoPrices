<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/api/auth/{user}/{token}', 'Auth\AuthController@getLogin', function ($tokenId) {
	Route::controller(
		'auth', 'Auth\AuthController', 
		['user' => 'auth.index', 'token' => 'auth.index']
	);
    return view('api');
});

Route::get('/api/logout', 'Auth\AuthController@getLogout');


Route::group(['middleware' => 'auth.api'], function () {
	Route::get('/api/{meth}/{mat}', 'API@index', function ($matId) {
		Route::controller('APIctrl', 'API', ['meth' => 'APIctrl.index', 'mat' => 'APIctrl.index']);
    	return view('api');
	});
});