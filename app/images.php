<?php

namespace App;
use App\Posts;
use Illuminate\Database\Eloquent\Model;

class images extends Model
{
    function getPosts(){
        return $this->belongsTo(Posts::class);
    }
}
