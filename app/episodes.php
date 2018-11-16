<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class episodes extends Model
{
    public $table ="episodes";
    public $fillable =['series_id','episode_name','season_id'];
    public function quality(){
        return $this->hasMany(seriesquality::class);
    }
    public function season(){
      return $this->belongsToOne(seasons::class);
    }
}
