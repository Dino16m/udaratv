<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class allmovies extends Model
{
    public $table ="allmovies";
    protected $primaryKey = 'id';
    protected $fillable=['name','file_path','type','short_description','image_link','run_time', 'views','imdb_link','first_letter_of_name'];
   
    public function quality()
    {
      return $this->hasMany(moviequality::class);
    }
    public function add($Tags)
    {
        $tags = $Tags;
            
            foreach($tags as $tag) {
                $tag = strtolower($tag);
                try{
                 $this->tags()->create(['tag'=>$tag,'allmovies_id'=>$this->id]);
                } catch (Exception $e) {
                     \Log::debug($e->getMessage());
                 }
                }
          return $this; 
    }
    public function tags()
    {
        return $this->hasMany(tags::class);
    }
}
