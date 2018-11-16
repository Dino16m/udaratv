<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class recently_updated extends Model
{
    
    public $table="recently_updated";
    protected $fillable=['video_name', 'video_link', 'season', 'episode', 'should_show'];
    
}
