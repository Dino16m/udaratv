<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class seriesquality extends Model
{
    public $table ="seriesquality";
    protected $primaryKey = 'id';
     protected $fillable =['episode_id','series_id','season_number','season_id','quality','file_path','number_downloaded'];
    
    public function episodes(){
      return $this->belongsTo(episodes::class);
    }
    public function series(){
        return $this->belongsTo(series::class);
    }
    
}
