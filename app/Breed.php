<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Breed extends Model {
public $timestamps = false;
public function cats(){
return $this->hasMany('App\Cat');
}
}
