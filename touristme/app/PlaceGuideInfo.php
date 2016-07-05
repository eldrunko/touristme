<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlaceGuideInfo extends Model
{
    protected $table="place_guide_info";
    protected $fillable=["guide_place_id","info_id"];
}
