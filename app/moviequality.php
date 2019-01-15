<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class moviequality extends Model
{
    protected $fillable =['allmovies_id','quality','file_path','number_downloaded'];
    protected $primaryKey = 'id';
    public $table ="moviequality";
    public function allmovies(){
      return $this->belongsTo(allmovies::class);
    }
}
