<?php

namespace App\Http\Controllers;

use App\Attr;
use App\Attr_val;
use App\Category;
use App\Product;
use Illuminate\Http\Request;

class FeatureController extends Controller
{
    public function index(Request $request)
    {
        if (isset($request->cat_id) && isset($request->cat_title)) {
            $attributes = Attr::from('attrs')->where('idcategory', '=', $request->cat_id)
                ->where('parent_id', '=', '0')
                ->orderBy('order_by','ASC')
                ->paginate(10);
            if ($request->action == 'sub') {
                $attributes = Attr::from('attrs')->where('parent_id', '=', $request->fea_id)->orderBy('order_by','ASC')->paginate(10);
            }
            return view('category.features.feature',
                compact('attributes')
            );

        } else {
            return redirect()->to('/category');
        }
    }
    public function addfeature(Request $request)
    {
        $customMessages = [
            'required' => 'نمیتواند خالی باشد :attribute',
            'min'=>'حدافل عنوان باید 2 کاراکتری باشد'
        ];
        $this->validate($request, [
            'featurename' => 'required|min:2',
        ],$customMessages);
        $feature = new Attr();
        $feature->title = $request->featurename;
        $feature->idcategory = $request->cat_id;
        if (isset($request->fea_id)) {
            $feature->parent_id = $request->fea_id;
        }
        $feature->save();
        return redirect()->back();
    }
    public function editfeature()
    {
        $category_list = Category::from('categories as t1')
            ->select('t1.cat_name  as parent_name', 't2.cat_name', 't2.parent_id', 't2.id')
            ->rightJoin('categories as t2', 't1.id', '=', 't2.parent_id')
            ->orderby('cat_name', 'asc')->get();
        return view('category.features.editfeature', compact('category_list'));
    }

    public function editfea(Request $request)
    {
        $category = Attr::find($request->feature_id);
        if ($category) {
            $category->title = $request->name;
            $category->save();
        }
        if (isset($request->sub)) {
           $att =Attr::where('id','=',$request->feature_id);
            return redirect()->to('/feature?cat_id=' . $request->cat_id . '&cat_title=' . $request->feature_title
            .'&fea_id='.$att->first()->parent_id.'&action=sub'
            );
        }
        return redirect()->to('/feature?cat_id=' . $request->cat_id . '&cat_title=' . $request->feature_title);
    }

    public function delete(Request $request)
    {
        $user = Attr::find($request->id);
        $user->delete();

        $user = Attr::where('parent_id','=',$request->id);
        $user->delete();

        return redirect()->back();
    }


    public function editOrder(Request $request)
    {
        for($i=0;$i<count($request->fea);$i++){
            if ($request->order[$i] != null){
                $category = Attr::find($request->fea[$i]);
                $category->order_by = $request->order[$i];
                $category->save();
            }

        }
        return redirect()->back();
        return $request;
    }


}
