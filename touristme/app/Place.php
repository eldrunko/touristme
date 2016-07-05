<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    protected $table='places';
    protected $fillable=["place"];

    public function guides(){
       return $this->belongsToMany('App\Guide','guides_places'/*,'id'/*,'normal_user_id'*/);
    }

     public function scopeCostAndUser($query){
   return $query->join('guide_place', 'guide_place.place_id','=','places.id')
                ->join('users','users.id','=','guide_place.guide_id');

    }
}
