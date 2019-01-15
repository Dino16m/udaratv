<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class naija extends Model
{
   public $table ="naija";
   protected $fillable=['name','file_path','type','short_description','image_link','imdb_link','first_letter_of_name'];
   public function quality(){
     return $this->hasMany(naijaquality::class);
   }
}
