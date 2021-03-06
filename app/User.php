<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;

public function getAuthIdentifier() {
return $this->getKey();
}
public function getAuthPassword() {
return $this->password;
}
public function cats(){
return $this->hasMany('Cat');
}
public function owns(Cat $cat){
return $this->id == $cat->owner;
}
public function canEdit(Cat $cat){
return $this->is_admin or $this->owns($cat);
}
}
