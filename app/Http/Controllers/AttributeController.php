<?php

namespace App\Http\Controllers;

use App\Attr;
use App\Attr_product;
use App\Product;
use App\Product_attr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttributeController extends Controller
{
    //api
    public function index(Request $request)
    {
        $attr = Attr::
        with('children')
            ->where('idcategory', '=', $request->cat_id)
            ->where('parent_id', '=', 0)
            ->get();

        $unique = 1;
        for ($i = 0; $i < count($attr); $i++) {
            for ($j = 0; $j < count($attr[$i]['children']); $j++) {
                for ($k = 0; $k < count($attr[$i]['children'][$j]['attribute_values']); $k++) {
                    $attr[$i]['children'][$j]['attribute_values'][$k]['id'] = $unique++;
                }
            }
        }
        return $attr;
    }


    //api

}
