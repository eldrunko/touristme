<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Place_guide as place;

class Guide extends Model
{
    protected $table="guides";
    protected $fillable=["normal_user_id"];

    public function services(){
    	return $this->hasMany('App\Place_guide');
    }
    
    public function places(){
    	return $this->belongsToMany('App\Place');
    }

  


   
}
