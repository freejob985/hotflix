<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Advertise extends Model
{
    protected $guarded = ['id'];


    protected $casts = [
    	'content'=>'object'
    ];
}
