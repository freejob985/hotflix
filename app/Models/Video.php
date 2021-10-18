<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $guarded = ['id'];

    public function episode(){
    	return $this->belongsTo(Epsode::class);
    }

    public function item(){
    	return $this->belongsTo(Item::class);
    }
}
