<?php


namespace App\Http\Controllers;

use App\Attr;
use App\Category;
use App\Comment;
use App\Country;
use App\Post;
use App\Product;
use App\Product_attr;
use App\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
require_once 'jdf.php';
class ProductController extends Controller
{

    private function get($id)
    {
        $products = DB::table('attr_product')
            ->join('attr_vals', 'attr_product.idval',
                '=', 'attr_vals.id')
            ->where('attr_vals.id', '=', $id)->get();
        return $products->first()->val;
    }

    public function create()
    {
        $attr = Attr::where('idcategory', '=', '2')->with('AttrValues')->get();
        return view('product.addproduct', compact('attr'));
    }

    //api
    public function getproducts()
    {
        $products = Product::select('id', 'title', 'price', 'thumb', 'category_id')->paginate(10);
        foreach ($products as $product => $value) {
            $products[$product]->thumb = url('/images/products/' . $products[$product]->thumb);
        }
        return $products;
    }

    public function getproduct_detail(Request $request)
    {
        $id = $request->product_id;

        $attr_products = DB::table('attr_products as t1')
            ->select('t1.Attr_val', 't2.title', 't3.title as parent_title')
            ->join('attrs as t2', 't1.Attr_id', '=', 't2.id')
            ->join('attrs as t3', 't2.parent_id', '=', 't3.id')
            ->where('product_id', '=', $id)
            ->whereNotNull('t1.Attr_val')
            ->whereRaw('LENGTH(t1.Attr_val) != 0')

            ->orderBy('t2.order_by', 'asc')
//            ->orderBy('t2.parent_id', 'asc')
//            ->orderBy('t2.id', 'asc')
            ->get();

//return $products;
        $tmp = array();
        $args = json_decode($attr_products, true);
        foreach ($args as $arg) {
            $tmp[$arg['parent_title']][] = $arg;
        }
        $output = array();
        foreach ($tmp as $type => $labels) {
            $output[] = array(
                'parent_title' => $type,
                'attribute_list' => $labels
            );
        }
        $uploads = Upload::where('product_id', '=', $id)->get();

        foreach ($uploads as $upload => $value) {
            $uploads[$upload]->resized_name = url('/images/products/' . $uploads[$upload]->resized_name);
        }


//        $products = Product::find($id);
        $products = Product::where('id', $id)
//            ->select('created_at', DB::raw('DATE(`created_at`) as created'),
//            "id","title","price","thumb","code_kala","category_id")
//            ->whereRaw('Date(created_at) = CURDATE()')
            ->get();


        foreach ( $products as $index=>$value){
            $date = $value->created_at;
            $array = explode(' ', $date);
//print_r($array);
            list($year, $month, $day) = explode('-', $array[0]);
            list($hour, $minute, $second) = explode(':', $array[1]);
            $timestamp = mktime($hour, $minute, $second, $month, $day, $year);
//echo $timestamp;
            $jalali_date = jdate("تاریخ:Y/m/d زمان:H:i:s", $timestamp);
            $timezone = 0;
            $day_number = jdate('j',$timestamp);
            $month_number = jdate('n',$timestamp);
            $year_number = jdate('y',$timestamp);

            $date = "$year_number/$month_number/$day_number";
            $products[$index]->created = $date;
        }






        if(isset($products->first()->category_id)){
            $cat_id=$products->first()->category_id;
                if ($cat_id == 56) {
                    $products->map(function ($post) {
                        $post['is_code_dastgah'] = 1;
                        return $post;
                    });
                } else {
                    $products->map(function ($post) {
                        $post['is_code_dastgah'] = 0;
                        return $post;
                    });
                }

        }

        $products= $products->first();

//        $products = Product::find(1);
//return $products;
//return $output;
//        return view(
//            'post.showpost',
//            [
//                'products' => $products,
//                'attributes' => $output,
//                'images' => $uploads
//            ]
//        );
        $original = new Collection($products);
        $latest = new Collection(['attributes' => $output]);
        $uploads = new Collection(['images' => $uploads]);

        $productDetail = $original->merge($latest);
        $productDetail = $productDetail->merge($uploads);


//      array_push(json_decode($products,true),$output);
        return $productDetail;
    }

//api

    public function filter(Request $request)
    {
        $filter = true;

        if (isset($request->filter)) {
            if (!empty($request->filter)) {
                $collection = DB::table('attr_products')->select('product_id')->distinct();
//            ->join('products as t2','t1.product_id','=','t2.id');
                $count = 0;
                $arr = array();
                foreach (json_decode($request->filter, true) as $item => $value) {
                    if ($value['flag']) {
                        if ($count == 0) {
//                            return $value;
                            $collection->where('attr_id', '=', $value['attr_id']);
                            $collection->where('Attr_val', 'like', $value['attr_value']);
                            $count++;
                        } else {
                            $collection->orwhere('attr_id', '=', $value['attr_id']);
//                            $collection->orwhere('Attr_val', 'like', $item);
                            $collection->where('Attr_val', 'like', $value['attr_value']);
                        }
                        $arr[] = $item;
                    }
                }
//                return $arr;
                $name = $collection->get();

                $product_ids = array();

                foreach (json_decode($name, true) as $na) {
                    array_push($product_ids, $na);
                }
                if ($count != 0) {

                    if ($request->category_id == 0) {
                        $products = Product::select('id', 'title', 'code_kala', 'thumb', 'price')
                            ->with('images')
                            ->whereIn('id', $product_ids)
                            ->paginate(10);
                    } elseif ($request->search) {
                        $products = Product::select('id', 'title', 'code_kala', 'thumb', 'price')
                            ->with('images')
                            ->whereIn('id', $product_ids)
                            ->where('category_id', $request->category_id)
                            ->where('title', 'like', '%' . $request->search . '%')
                            ->paginate(10);
                    } else {
                        $products = Product::select('id', 'title', 'code_kala', 'thumb', 'price')
                            ->with('images')
                            ->whereIn('id', $product_ids)
                            ->where('category_id', $request->category_id)
                            ->paginate(10);
//                    return $product_ids;
                    }
                } else {
                    $filter = false;
                }
            } else {
                $filter = false;
            }
        } else {
            $filter = false;
        }
        if ($filter == false) {
            if ($request->category_id == 0) {
                $products = Product::select('id', 'code_kala', 'title', 'thumb', 'price')
                    ->with('images')
                    ->paginate(10);
            } elseif ($request->search) {
                $products = Product::select('id', 'code_kala', 'title', 'thumb', 'price')
                    ->with('images')
                    ->where('category_id', $request->category_id)
                    ->where('title', 'like', '%' . $request->search . '%')
                    ->paginate(10);
            } else {
                $products = Product::select('id', 'code_kala', 'title', 'thumb', 'price')
                    ->with('images')
                    ->where('category_id', $request->category_id)
                    ->paginate(10);
            }

        }

        if ($request->category_id == 56) {
            $CodeDastgah = Category::select('is_code_dastgah')->where('id', 56)->get();
        }
        foreach ($products as $product => $value) {
            $products[$product]->thumb = url('/images/products/thumb/' . $products[$product]->thumb);
            if (isset($CodeDastgah)) {
                $products->map(function ($post) {
                    $post['is_code_dastgah'] = 1;
                    return $post;
                });
            } else {
                $products->map(function ($post) {
                    $post['is_code_dastgah'] = 0;
                    return $post;
                });
            }

        }//            ->get();
//;
//        file_put_contents("response.txt",json_encode($products,JSON_PRETTY_PRINT));
        file_put_contents("response.txt", var_export($request, true));
        return response()->json($products);
    }

}
