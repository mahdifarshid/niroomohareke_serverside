<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Attr extends Model
{
    public function AttrValues()
    {
        return $this->hasMany(Attr_val::class);
    }

    public function children()
    {
        return $this->hasMany(Attr::class, 'parent_id')
            ->with('children')
            ->with('attribute_values')
//            ->groupBy('title')

//            ->withCount('attribute_values')
            ;
    }

    public function cou()
    {
        $this->hasMany(Attr_product::class, 'Attr_id', 'id');
    }

    public function attribute_values()
    {
        return $this->hasMany(Attr_product::class, 'Attr_id', 'id')
            ->select('Attr_id', 'Attr_val', DB::raw('count(*) as total'))
            ->groupBy('Attr_id')
            ->groupBy('Attr_val')
            ->where('Attr_val','<>','')
            ;

    }

}
