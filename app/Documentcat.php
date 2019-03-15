<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Documentcat extends Model
{
    public function documents()
    {
        return $this->hasMany(Document::class,'cat_id','id');
    }
}
