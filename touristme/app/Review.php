<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table='reviews';
    protected $fillable=[
    	'text',
    	'rating',
    	'reservation_id',
    ];
}
