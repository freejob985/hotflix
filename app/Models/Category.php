<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = ['id'];

    public function scopeActive()
    {
    	return $this->where('status',1);
    }

    public function subcategory(){

    	return $this->hasMany(SubCategory::class);
    }
}
