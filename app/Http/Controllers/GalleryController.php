<?php

namespace App\Http\Controllers;

use App\Gallery;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class GalleryController extends Controller
{

    public function add(Request $request)
    {

        $this->validate($request, [
            'title' => 'required|min:2',
            'gallery_image' => 'required'
        ]);

        if (isset($request->title)) {
            $path = "images";
            if (!is_dir($path)) {
                mkdir($path, 0777);
            }

            $photo_path = "images/gallery";
            if (!is_dir($photo_path)) {
                mkdir($photo_path, 0777);
            }

            $name = sha1(date('YmdHis') . str_random(15));
            $photoName = time() . $name . '.' . $request->gallery_image->getClientOriginalExtension();
//            Image::make($request->gallery_image)
//                ->resize(700, null, function ($constraints) {
//                    $constraints->aspectRatio();
//                })->crop(650, 650)->trim()
//                ->save($photo_path . '/' . $photoName);

            Image::make($request->gallery_image)
                ->resize(400, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($photo_path . '/' . $photoName);


            $gallery = new Gallery();
            $gallery->title = $request->title;
            $gallery->image = $photoName;
            $gallery->save();
        }
        return redirect()->back();
    }

    public function index()
    {
        $GalleryArray = Gallery::paginate(20);
        foreach ($GalleryArray as $index=>$value) {
            $GalleryArray[$index]['image']=url('/images/gallery/' . $value->image);
        }
        return view('gallery.gallery', compact('GalleryArray'));
    }

    public function remove($id)
    {
        $image = Gallery::find($id);
    
        if (isset($image->image)) {
            if (file_exists('images/gallery/' . $image->image) && !empty($image->image)) {
                unlink('images/gallery/' . $image->image);
            }
        }
        Gallery::find($id)->delete();
        return redirect()->back();
    }

    public function editgallery($id)
    {
        $gallery = Gallery::find($id);
        return view('gallery.editgallery', compact('gallery'));
    }

    public function edit(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|min:2',
        ]);
        $gallery = Gallery::find($request->id);
        $gallery->title = $request->title;
        $gallery->save();
        return redirect()->to('/gallery');
    }

    //////////////////////////api//////////////////
    ///
    public function getGallery()
    {
        $galery = Gallery::all();

        foreach ($galery as $image => $value) {
            $galery[$image]->image = url('/images/gallery/' . $galery[$image]->image);
        }
        return $galery;
    }
}
