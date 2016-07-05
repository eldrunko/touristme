<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Info;
class Reservation extends Model
{
    protected $table='reservations';
    protected $fillable=['user_id','info_id'];

    public function info(){
    	return $this->belongsTo('App\Info');
    }
}
