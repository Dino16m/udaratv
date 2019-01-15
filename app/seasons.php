<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class seasons extends Model
{
   public $table = "seasons";
   protected $primaryKey = 'id';
   protected $fillable=['season_name','series_id'];
   public $timestamps = false;
   public function series(){
     return $this->belongsTo(series::class);
   }
   
   public function episodes(){
     return $this->hasMany(episodes::class, 'season_id', 'id');
   }
}
