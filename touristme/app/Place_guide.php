<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Place_guide extends Model
{
	protected $table='guide_place';
    protected $fillable=['place_id','guide_id','cost'];

    public function infos(){
    	//return $this->belongsToMany('App\Info','place_guide_info', 'guide_place_id', 'info_id');
    	return $this->hasMany('App\Info','guide_place_id','id');
    }

 
}
