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
Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);*/
Route::get('/', function(){
	return Redirect::to('cats');
});

Route::get('cats', function(){
	return "All cats";
});

Route::get('cats/{id}', function($id){
	return "Cat #$id";
})->where('id','[0-9]+');

Route::get('about', function(){
	return view('about')->with('number_of_cats', 9000);
});
