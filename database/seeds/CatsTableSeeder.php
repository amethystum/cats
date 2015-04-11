<?php

use Illuminate\Database\Seeder;

class CatsTableSeeder extends Seeder {
  public function run(){
    DB::table('cats')->insert(
        array('id'=>1, 'name'=>"No.1CAT", 'date_of_birth'=>new DateTime, 'breed_id'=>1, 'created_at'=>new DateTime, 'updated_at'=>new DateTime)
      );
  }
}
