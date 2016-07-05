<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $table="feedbacks";
    protected $fillable=["vote","journey","text"];
}
