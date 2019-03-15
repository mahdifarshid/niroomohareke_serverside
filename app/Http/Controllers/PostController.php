<?php

namespace App\Http\Controllers;

use App\Attr;
use App\Attr_product;
use App\Category;
use App\Product;
use App\Product_attr;
use App\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Intervention\Image\Facades\Image;

class PostController extends Controller
{
    private $photos_path;

    public function __construct()
    {
        $this->photos_path = public_path('/images');
    }


    ////////////////ajax ////////////////////
    public function newpostajax(Request $request)
    {
        if ($request->ajax()) {
            $images = Upload::where('product_id', '=', 0)->get();
            $view = view('post.ajax.post_imagedata', compact('images'))->render();
            return response()->json(['html' => $view]);
        }
    }

    public function editpostajax(Request $request)
    {
        if ($request->ajax()) {
            $images = Upload::where('product_id', '=', $request->id)->get();
            $view = view('post.ajax.post_imagedata', compact('images'))->render();
            return response()->json(['html' => $view]);
        }
    }

    public function ajax_attr(Request $request)
    {
        if ($request->ajax()) {
            $cat_id = $request->cat_id;
            Config::set('id', $cat_id);
            $attr_products = DB::table('categories as t1')
                ->select('t2.id as attr_id', 't2.title', 't3.title as parent_title')
                ->join('attrs as t2', 't1.id', 't2.idcategory')
                ->join('attrs as t3', 't2.parent_id', '=', 't3.id')
                ->where('t1.id', '=', $cat_id)
                ->orderBy('t2.parent_id', 'asc')
                ->orderBy('t2.id', 'asc')
                ->get();
            $tmp = array();
            $args = json_decode($attr_products, true);
            foreach ($args as $arg) {
                $tmp[$arg['parent_title']][] = $arg;
            }
            $attributes = array();
            foreach ($tmp as $type => $labels) {
                $attributes[] = array(
                    'parent_title' => $type,
                    'Attr_val' => $labels
                );
            }
            $view = view('post.ajax.attributesdata', compact('attributes'))->render();
            return response()->json(['html' => $view]);
        }
    }

    ////////////////end ajax/////////////////////////


    public function getpostlist(Request $request)
    {
        if (!isset($request->cat_id) || $request->cat_id == "all") {
            $products = DB::table('products as t1')
                ->select('t1.id', 't1.title','t1.thumb','t2.cat_name')
                ->join('categories as t2', 't1.category_id', '=', 't2.id')
                ->paginate(10);
        } else {
            $products = DB::table('products as t1')
                ->select('t1.id', 't1.title', 't1.thumb','t2.cat_name')
                ->join('categories as t2', 't1.category_id', '=', 't2.id')
                ->where('t1.category_id', '=', $request->cat_id)
                ->paginate(10);
        }

        $category = Category::all();

        return view('post.allpost', [
            'products' => $products,
            'categories' => $category
        ]);
    }

    public function delete(Request $request)
    {
        $product = Product::from('products as t1')
            ->leftjoin('uploads as t2', 't1.id', '=', 't2.product_id')
            ->where('t1.id', '=', $request->id)
            ->get();

        if (isset($product->first()->thumb)) {
            if (file_exists('images/products/thumb/' . $product->first()->thumb)) {
                if (is_file('images/products/thumb/' . $product->first()->thumb)) {
                    unlink('images/products/thumb/' . $product->first()->thumb);
                }
            }
        }

        foreach ($product as $pro) {
            if (file_exists('images/products/' . $pro->resized_name)) {
                if (is_file('images/products/' . $pro->resized_name)) {
                    unlink('images/products/' . $pro->resized_name);
                    Upload::find($pro->id)->delete();
                }

            }

        }


        Attr_product::where('product_id', '=', $request->id)->delete();;

        $user = Product::findOrFail($request->id);
        $user->delete();

        return redirect()->back();
    }


    public function showpost($id)
    {
        $attr_products = DB::table('attr_products as t1')
            ->select('t1.Attr_val', 't2.title', 't3.title as parent_title')
            ->join('attrs as t2', 't1.Attr_id', '=', 't2.id')
            ->join('attrs as t3', 't2.parent_id', '=', 't3.id')
            ->where('product_id', '=', $id)
            ->whereNotNull('t1.Attr_val')
            ->whereRaw('LENGTH(t1.Attr_val) != 0')
            ->orderBy('t2.parent_id', 'asc')
            ->orderBy('t2.id', 'asc')
            ->get();

        $tmp = array();
        $args = json_decode($attr_products, true);
        foreach ($args as $arg) {
            $tmp[$arg['parent_title']][] = $arg;
        }
        $output = array();
        foreach ($tmp as $type => $labels) {
            $output[] = array(
                'parent_title' => $type,
                'Attr_val' => $labels
            );
        }
        $uploads = Upload::where('product_id', '=', $id)->get();

        $products = Product::where('products.id', '=', $id)->join('categories', 'categories.id', '=', 'products.category_id')->get();
        return view(
            'post.showpost',
            [
                'products' => $products,
                'attributes' => $output,
                'images' => $uploads
            ]
        );
    }


/////////////////////addpost///////////////////////

    public function newpost(Request $request)
    {
        $cat_id = $request->cat_id;

        /* Config::set('id', $cat_id);
         $attr_products = DB::table('categories as t1')
             ->select('t2.id as attr_id', 't2.title', 't3.title as parent_title')
             ->join('attrs as t2', 't1.id', 't2.idcategory')
             ->join('attrs as t3', 't2.parent_id', '=', 't3.id')
             ->where('t1.id', '=', $cat_id)
             ->orderBy('t2.parent_id', 'asc')
             ->orderBy('t2.id', 'asc')
             ->get();
 //        return $attr_products;
         $tmp = array();
         $args = json_decode($attr_products, true);
         foreach ($args as $arg) {
             $tmp[$arg['parent_title']][] = $arg;
         }
         $output = array();
         foreach ($tmp as $type => $labels) {
             $output[] = array(
                 'parent_title' => $type,
                 'Attr_val' => $labels
             );
         }*/

        $category = Category::all();
        $choosedcat = Category::where('id', '=', $cat_id)->get();
//        $uploads = Upload::where('product_id', '=', 0)->get();
//        return $category;
        return view('post.newpost',
            [
//                'attributes' => $output,
//                'images' => $uploads,
                'category' => $category,
//                'choosedcat' => $choosedcat
            ]
        );
    }

    public function addnewpost(Request $request)
    {
        $customMessages = [
            'required' => 'نمیتواند خالی باشد :attribute',
            'min' => 'حدافل عنوان باید 2 کاراکتری باشد'
        ];
        $this->validate($request, [
            'title' => 'required|min:2',
            'category_id' => 'required',
        ], $customMessages);

        $this->createFolders();
        $photo_path = "images/products/thumb";


        $product = new Product();
        $product->title = $request->title;
        $product->price = $request->price;
        if($request->code_kala != null){
            $product->code_kala = $request->code_kala;
        }
       else{
           $product->code_kala = '';
       }
        $product->category_id = $request->category_id;


        if (isset($request->primary_image)) {
            $photoName = $this->uploadImages($request->primary_image, $photo_path);
            $product->thumb = $photoName;
            $product->save();
            if (isset($request->attr_id)) {
                foreach ($request->attr_id as $index => $attr) {
                    if (!empty($request->attr_val[$index])) {
                        $product_attr = new Attr_product();
                        $product_attr->product_id = $product->id;
                        $product_attr->Attr_id = $attr;;
                        $product_attr->Attr_val = str_replace('%',' درصد',$request->attr_val[$index]);
                        $product_attr->save();
                    }
                }
            }
        } else {
            $product->save();
        }
        Upload::where('product_id', '=', 0)
            ->update(array('product_id' => $product->id));

//        return $request;
//        if(isset($product->id)){
//           $categories= Category::all();
//            return view('post.newpost',[
//                'categories'=>$categories,
//                'stored_productid'=>$product->id,
//            ]);
//        }
        if (isset($product->id)) {
            return redirect()->to('post/newpost?p=' . $product->id);
        } else
            return redirect()->back();
    }

/////////////////////end addpost///////////////////////


    ///////////////editpost///////////////////
    public function editpost($id)
    {
        Config::set('id', $id);
        $cat_id=Product::where('id','=',$id)->get();

        $attr_products = DB::table('categories as t1')
            ->select('t2.id as attr_id', 't4.id as attr_product_id', 't2.title', 't3.title as parent_title', 't4.Attr_val')
            ->join('attrs as t2', 't1.id', 't2.idcategory')
            ->join('attrs as t3', 't2.parent_id', '=', 't3.id')
//            ->leftJoin('attr_products as t4', 't2.id', '=', 't4.Attr_id')
            ->leftJoin(DB::raw('attr_products as t4'), function ($join) {
//                global $id;
                $join->on('t2.id', '=', 't4.Attr_id');
                $join->where('t4.product_id', '=', Config::get('id'));
            })
            ->where('t2.idcategory','=',$cat_id->first()->category_id)
            ->orderBy('t2.parent_id', 'asc')
            ->orderBy('t2.id', 'asc')
            ->get();
        $tmp = array();
        $args = json_decode($attr_products, true);
        foreach ($args as $arg) {
            $tmp[$arg['parent_title']][] = $arg;
        }
        $output = array();
        foreach ($tmp as $type => $labels) {
            $output[] = array(
                'parent_title' => $type,
                'Attr_val' => $labels
            );
        }
//        return $output;
        $category = Category::all();
        $uploads = Upload::where('product_id', '=', $id)->get();

        $products = DB::table('products as t1')
            ->select('t1.thumb','t1.code_kala', 't1.title', 't1.price', 't1.id', 't2.cat_name')
            ->leftjoin('categories as t2', 't2.id', '=', 't1.category_id')
            ->where('t1.id', '=', $id)
            ->get();
//        return view('post.editpost',
        return view('post.edit',
            [
                'products' => $products,
                'attributes' => $output,
                'images' => $uploads,
                'category' => $category
            ]
        );
    }

    public function edit(Request $request)
    {
        if (isset($request->primary_image)) {
            $this->createFolders();
            $product = Product::find($request->product_id);
            if (isset($product->thumb)) {
                if (file_exists('images/products/thumb/' . $product->thumb)) {
                    unlink('images/products/thumb/' . $product->thumb);
                }
            }
            $photo_path = "images/products/thumb";

            $photoName = $this->uploadImages($request->primary_image, $photo_path);
            $product = Product::find($request->product_id);
            $product->title = $request->title;
            $product->price = $request->price;
            $product->code_kala = $request->code_kala;
            $product->thumb = $photoName;
//        $product->category_id = $request->category_id;
            $product->save();
        } else {
            $product = Product::find($request->product_id);
            $product->title = $request->title;
            $product->price = $request->price;
            $product->code_kala = $request->code_kala;
            $product->save();
        }

        $arr = array();
        if(isset($request->attr_id)) {
            foreach ($request->attr_id as $index => $attr) {
                $arr[] = $request->attr_val[$index];
                if (empty($request->attr_product_id[$index])) {
                    $product_attr = new Attr_product();
                    $product_attr->product_id = $request->product_id;
                    $product_attr->Attr_id = $attr;
                    $product_attr->Attr_val = str_replace('%', ' درصد', $request->attr_val[$index]);
                    $product_attr->save();
                } else {
                    $product_attr = Attr_product::find($request->attr_product_id[$index]);
                    $product_attr->product_id = $request->product_id;
                    $product_attr->Attr_id = $attr;;
                    if (isset($request->attr_val[$index]))
                        $product_attr->Attr_val = str_replace('%', ' درصد', $request->attr_val[$index]);
                    else {
                        $product_attr->Attr_val = '';
                    }
                    $product_attr->save();
                }
            }
        }
        return redirect()->back();
    }

    ///////////////end editpost///////////////////


    public function addimage(Request $request)
    {
//        file_put_contents('a.txt',var_export($request,true));

        $customMessages = [
            'required' => 'نمیتواند خالی باشد :attribute'
        ];
        $this->validate($request, [
            'post_image' => 'required',
        ], $customMessages);

        $this->createFolders();

        $photo_path = "images/products";
        $photoName = $this->uploadImages($request->post_image, $photo_path);

        $upload = new Upload();
//        $upload->filename = $photoName;
        $upload->resized_name = $photoName;
//        $upload->original_name = $photoName;
        $upload->product_id = $request->product_id;
        $upload->save();

        return redirect()->back();
    }

    ////////////////functions////////////////

    private function uploadImages($image, $path)
    {
        $name = sha1(date('YmdHis') . str_random(15));
        $photoName = time() . $name . '.' . $image->getClientOriginalExtension();
      /*  Image::make($image)
            ->resize(800, null, function ($constraints) {
                $constraints->aspectRatio();
            })->crop(500, 500)->trim()
            ->save($path . '/' . $photoName);*/
        Image::make($image)
            ->resize(400, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save($path . '/' . $photoName);

        return $photoName;
    }

    private function createFolders()
    {
        $photo_path = "images";
        if (!is_dir($photo_path)) {
            mkdir($photo_path, 0777);
        }

        $photo_path = "images/products";
        if (!is_dir($photo_path)) {
            mkdir($photo_path, 0777);
        }

        $photo_path = "images/products/thumb";
        if (!is_dir($photo_path)) {
            mkdir($photo_path, 0777);
        }
    }

    ////////////////end functions////////////////
}
