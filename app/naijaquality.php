<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class naijaquality extends Model
{
  public $table ="naijaquality";
  protected $fillable =['naija_id','quality','file_path','number_downloaded'];

    public function naija(){
      return $this->belongsTo(naija::class);
    }
}
