<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class recently_updated extends Model
{
    
    public $table="recently_updated";
    protected $primaryKey = 'id';
    protected $fillable=['video_name', 'image_link', 'video_link', 'season', 'episode', 'should_show'];
    
}
