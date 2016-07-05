<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Place_guide;

class Info extends Model
{
   protected $table="infos";
    protected $fillable=["cost",
    					"begin",
    					"end",
    					"time",
    					"date",
    					"guide_place_id",
    					];
    public function place_guide_owner(){
    	return $this->belongsTo('App\Place_guide','guide_place_id','id');
    }
    
     

}
