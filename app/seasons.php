<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class seasons extends Model
{
   public $table = "seasons";
   protected $fillable=['series_name','series_id'];
   public function series(){
     return $this->belongsTo(series::class);
   }
   public function episodes(){
     return $this->hasMany(episodes::class);
   }
}
