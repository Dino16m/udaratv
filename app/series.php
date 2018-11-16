<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class series extends Model
{
    protected $table= 'series';
    protected $fillable =['name', 'series_path','type', 'number_of_seasons','short_description', 'image_link','imdb_link','first_letter_of_name'];
    
    public function makeNew($details){
     $season = $this->seasons()->create(['season_name'=>$details['number_of_seasons'],'series_id'=>$this->id]);
     $episode= $season->episodes()->create(['series_id'=>$this->id,'episode_name'=>$details['episode_name'],'season_id'=>$season->id]);
     $seriesquality = $episode->quality()->create(['series_id'=>$this->id,'episodes_id'=>$episode->id,'quality'=>$details['quality'],'file_path'=>$details['file_path'],'season_number'=>$details['number_of_seasons'],'season_id'=>$season->id, 'number_downloaded'=> 0 ]);
     if( ($this!=null && $season!=null) && ($episode != null && $seriesquality != null)){
        return true;
     }
     return false;
    }

    public function seasons(){
      return $this->hasMany(series::class);
    }
}
