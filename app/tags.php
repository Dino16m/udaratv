<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tags extends Model
{
    protected $table = 'tags';
    protected $fillable =['id', 'allmovies_id', 'tag'];
    public $timestamps = false;
    public function allmovies()
    {
        return $this->belongsTo(allmovies::class);
    }
}
