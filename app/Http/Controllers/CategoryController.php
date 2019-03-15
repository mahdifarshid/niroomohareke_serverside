<?php

namespace App\Http\Controllers;

use App\Attr;
use App\Category;
use App\Product;
use App\Upload;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $id = 0;
        if (isset($request->id)) {
            $id = $request->id;
        }
        $category = Category::from('categories')
            ->withCount('getposts')
            ->orderby('order_by', 'asc')
            ->where('parent_id', '=', $id)
            ->paginate(10);
        return view('category.category', [
            'category' => $category,
            'count' => count($category)
        ]);
    }

    public static function getCount($id)
    {
        return $posts = Category::where('id', '=', $id)->withCount('getposts')->get();
    }

    public function addcat(Request $request)
    {
        $this->validate($request, [
            'cat_name' => 'required|min:2||unique:categories',
            'cat_image' => 'required'
        ]);
        if (isset($request->cat_image)) {
            $path = "images";
            if (!is_dir($path)) {
                mkdir($path, 0777);
            }
            $photo_path = "images/category";
            if (!is_dir($photo_path)) {
                mkdir($photo_path, 0777);
            }
            $name = sha1(date('YmdHis') . str_random(15));
            $photoName = time() . $name . '.' . $request->cat_image->getClientOriginalExtension();
//            Image::make($request->cat_image)
//                ->resize(800, null, function ($constraints) {
//                    $constraints->aspectRatio();
//                })->crop(600, 600)->trim()
//                ->save($photo_path . '/' . $photoName);
            Image::make($request->cat_image)
                ->resize(250, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($photo_path . '/' . $photoName);

            $category = new Category();
            $category->cat_name = $request->cat_name;
            $category->cat_image = $photoName;
            $category->save();
        } else {
            $category = new Category();
            $category->cat_name = $request->cat_name;
            $category->save();
        }
        return redirect()->back();
    }

    public function editcategory($cat_id)
    {
        $category = Category::find($cat_id);
        return view('category.editcategory', compact('category'));
    }

    public function editcat(Request $request)
    {
        if (isset($request->cat_image)) {
            $path = "images";
            if (!is_dir($path)) {
                mkdir($path, 0777);
            }
            $photo_path = "images/category";
            if (!is_dir($photo_path)) {
                mkdir($photo_path, 0777);
            }
            $name = sha1(date('YmdHis') . str_random(15));
            $photoName = time() . $name . '.' . $request->cat_image->getClientOriginalExtension();
//            Image::make($request->cat_image)
//                ->resize(800, null, function ($constraints) {
//                    $constraints->aspectRatio();
//                })->crop(600, 600)->trim()
//                ->save($photo_path . '/' . $photoName);
            Image::make($request->cat_image)
                ->resize(250, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($photo_path . '/' . $photoName);

            $cat = Category::find($request->id);
            if ($cat->cat_image != "") {
                if (file_exists('images/category/' . $cat->cat_image) && !empty($cat->cat_image)) {
                    unlink('images/category/' . $cat->cat_image);
                }
            }
            $category = Category::find($request->id);
            $category->cat_name = $request->cat_name;
            $category->cat_image = $photoName;
            $category->save();
        } else {
            $category = Category::find($request->id);
            $category->cat_name = $request->cat_name;
            $category->save();
        }
        return redirect()->to('/category');
    }

    public function delete($id)
    {
        $user = Category::find($id);
        if ($user->cat_image!="") {
            if (file_exists('images/category/' . $user->cat_image) && !empty($user->cat_image)) {
                unlink('images/category/' . $user->cat_image);
            }
        }
        $product = Product::from('products as t1')
            ->join('uploads as t2', 't1.id', '=', 't2.product_id')
            ->where('t1.category_id', '=', $id)
            ->get();

        foreach ($product as $pro) {
            if ($pro->resized_name != "") {
                if (file_exists('images/products/' . $pro->resized_name)) {
                    unlink('images/products/' . $pro->resized_name);
                }
            }
            Upload::find($pro->id)->delete();
        }
        Attr::where('idcategory', '=', $id)->delete();
        Product::where('category_id', '=', $id)->delete();
        Category::find($id)->delete();
        return redirect()->back();
    }

    ///////////////////api///////////////////////
    public function getCetegories()
    {
//        $category = Category::with('children')->where('parent_id', '=', '0')->get();
        $category = Category::where('parent_id', '=', '0')->orderBy('order_by', 'ASC')->withCount('getposts')->get();
        foreach ($category as $cat => $value) {
            $category[$cat]->cat_image = url('/images/category/' . $value->cat_image);
        }

        return $category;
    }

    public function editOrder(Request $request)
    {
        for($i=0;$i<count($request->cat);$i++){
            if ($request->order[$i] != null){
               $category = Category::find($request->cat[$i]);
               $category->order_by = $request->order[$i];
               $category->save();
            }

        }
        return redirect()->back();
    }


}
