<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;



class Wishlist extends Model
{
    protected $guarded = ['id'];
    protected $table = 'user_movies_wishlist';
}
