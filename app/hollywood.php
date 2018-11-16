<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class hollywood extends Model
{
    public $table ="hollywood";
    protected $fillable=['name','file_path','type','short_description','image_link','imdb_link','first_letter_of_name'];
    public function quality(){
      return $this->hasMany(quality::class);
    }
}
