<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class hollywoodquality extends Model
{
    protected $fillable =['hollywood_id','quality','file_path','number_downloaded'];
    public $table ="hollywoodquality";
    public function hollywood(){
      return $this->belongsTo(hollywood::class);
    }
}
