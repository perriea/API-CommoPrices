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

/*
** Accueil
** Input : none
** Output : none
*/
Route::get('/', function () {
    return view('welcome');
});


/*
** Afficher graph
** Input : nom du materiau
** Output graph
*/
Route::get('/graph/{mat}', function ($mat) {
	return View::make('graph', array('mat' => $mat));
});


/*
** Authentification
** Input : user, token
** Output : JSON
** Creation d'une session API
*/
Route::get('/api/auth/{user}/{token}', 'Auth\AuthController@getLogin', function ($tokenId) {
	Route::controller(
		'auth', 'Auth\AuthController', 
		['user' => 'auth.index', 'token' => 'auth.index']
	);
    return view('api');
});


/*
** Logout
** Input : none
** Output : JSON
** Destruction de la session en cours
*/
Route::get('/api/logout', 'Auth\AuthController@getLogout');


/*
** API
** Input : SESSION, methode & matiere
** Output : JSON
** Afficher les donnees de l'API seulement si on est auth.
*/
Route::group(['middleware' => 'auth.api'], function () {
	Route::get('/api/{meth}/{mat}', 'API@index', function ($matId) {
		Route::controller('APIctrl', 'API', ['meth' => 'APIctrl.index', 'mat' => 'APIctrl.index']);
    	return view('api');
	});
});