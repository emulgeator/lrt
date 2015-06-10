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

Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');
Route::get('/links/anchor_chart', 'LinkController@getAnchorChart');
Route::get('/links/link_status_chart', 'LinkController@getLinkStatusChart');
Route::get('/links/from_url_chart', 'LinkController@getFromUrlChart');
Route::get('/links/bl_dom_chart', 'LinkController@getBlDomChart');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
