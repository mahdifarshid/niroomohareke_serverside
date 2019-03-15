<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\This;

class Product extends Model
{
    function images()
    {
        return $this->hasMany(Upload::class);
    }

    public function attriutes()
    {
        return $this->hasMany(Product_attr::class);

    }

    public function many()
    {
        return $this->belongsToMany(Attr::class)
            ->withPivot('idval');
    }

    public function productCategory()
    {
        return $this->hasMany(Category::class,'id','category_id');
    }
}
