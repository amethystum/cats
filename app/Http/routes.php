<?php
use App\Cat;
use App\Breed;
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
  $cats = Cat::all();
	return view('cats.index')->with('cats', $cats);
});

Route::get('test', function(){
	$cat = Cat::first();
  return view('test.index')->with('teststr', $cat->breed->name);
});

Route::model('cat', 'App\Cat');
Route::get('cats/{cat}', function(Cat $cat){
	return view('cats.single')->with('cat',$cat);
});

Route::get('cats/create',function(){
	$cat=new Cat;
	return view('cats.edit')
	  ->with('cat',$cat)
	  ->with('method','post');
});

Route::get('cats/{cat}/edit',function(Cat $cat){
	return view('cats.edit')
	  ->with('cat',$cat)
	  ->with('method','put');
});

Route::get('cats/{cat}/delete',function(Cat $cat){
	return view('cats.edit')
	  ->with('cat',$cat)
	  ->with('method','delete');
});

Route::get('about', function(){
	return view('about')->with('number_of_cats', 9000);
});

Route::get('cats/breeds/{name}', function($name){
  $breed = Breed::whereName($name)->with('cats')->first();
  return view('cats.index')
    ->with('breed', $breed)
    ->with('cats', $breed->cats);
});

Route::post('cats',function(){
  $cat=Cat::create(Input::all());
  return Redirect::to('cats/'.$cat->id)->with('message','Successfully created page!');
});

Route::put('cats/{cat}',function(Cat $cat){
  $cat->update(Input::all());
  return Redirect::to('cats/'.$cat->id)->with('message','Successfully updated page!');
});

Route::delete('cats/{cat}',function(Cat $cat){
  $cat->delete();
  return Redirect::to('cats')
    ->with('message','Successfully deleted page!');
});

View::composer('cats.edit',function($view){
  $breeds=Breed::all();
  if(count($breeds)>0){
    $breed_options=array_combine($breeds->lists('id'),$breeds->lists('name'));
  }else{
    $breed_options=array(null,'Unspecified');
  }
  $view->with('breed_options',$breed_options);
});
