<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class subscribers extends Model
{
    protected $fillable = ['email', 'name', 'movie_name'];
    protected $table = 'subscribers';
    protected $primaryKey = 'id';
}
