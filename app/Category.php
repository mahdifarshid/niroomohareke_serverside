<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function model_two()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class,'parent_id')->with('children');
    }

    public function parent() {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function getposts(){
        return $this->hasMany(Product::class);
    }




}
