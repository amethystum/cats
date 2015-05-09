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
//Route::group(array('middleware'=>'auth'), function(){
Route::get('cats/create',array('middleware'=>'auth', function(){
	$cat=new Cat;
	return view('cats.edit')
	  ->with('cat',$cat)
	  ->with('method','post');
}));
Route::post('cats',array('middleware'=>'auth|csrf', function(){
	$rules = array('name' => 'required|min:3', 'date_of_birth' => array('required', 'date'));
	$validation_result = Validator::make(Input::all(), $rules);
	if($validation_result->fails()){
		return Redirect::back()->with('message', $validation_result->messages());
}
else{
	  $cat=Cat::create(Input::all());
		$cat->user_id = Auth::user()->id;
		dd("success");
		if($cat->save()){
  		return Redirect::to('cats/'.$cat->id)->with('message','Successfully created page!');
		}else{
			return Redirect::back()->with('error', 'Could not create profile');
		}
	}
}));
//});
Route::get('auth/login', function(){
	return Redirect::to('login');
});
Route::get('cats/{cat}', function(Cat $cat){
	return view('cats.single')->with('cat',$cat);
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

Route::put('cats/{cat}',array('middleware'=>'csrf', function(Cat $cat){
  if(Auth::user()->canEdit($cat)){
		$cat->update(Input::all());
  	return Redirect::to('cats/'.$cat->id)->with('message','Successfully updated page!');
	}else{
		return Redirect::to('cats/'.$cat->id)->with('error',"Unauthorized operation");
	}
}));

Route::delete('cats/{cat}',array('middleware'=>'csrf', function(Cat $cat){
  $cat->delete();
  return Redirect::to('cats')
    ->with('message','Successfully deleted page!');
}));

View::composer('cats.edit',function($view){
  $breeds=Breed::all();
  if(count($breeds)>0){
    $breed_options=array_combine($breeds->lists('id'),$breeds->lists('name'));
  }else{
    $breed_options=array(null,'Unspecified');
  }
  $view->with('breed_options',$breed_options);
});

Route::get('login', function(){
	return view('login');
});

Route::post('login',  function(){
if(Auth::attempt(Input::only('username', 'password'))) {
//dd($this->session);
//$path=$this->session->pull('url.intended','/');
//var_dump($this->session);
//return Redirect::intended('/');
return Redirect::to('/');
} else {
return Redirect::back()
->withInput()
->with('error', "Invalid credentials");
}
});

Route::get('logout', function(){
Auth::logout();
return Redirect::to('/')
->with('message', 'You are now logged out');
});

