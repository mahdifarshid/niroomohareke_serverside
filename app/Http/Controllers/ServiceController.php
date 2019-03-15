<?php

namespace App\Http\Controllers;

use App\Service_image;
use App\Services;
use App\Setting;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Services::with('serviceImages')->get();
        $services = json_decode($services);
        return view('service.service', compact('services'));
    }


    public function add(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|min:2',
            'description' => 'required'
        ]);

        $gallery = new Services();
        $gallery->title = $request->title;
        $gallery->description = $request->description;
        $gallery->save();

        Service_image::where('service_id', '=', 0)
            ->update(array('service_id' => $gallery->id));

        return redirect()->back();
    }

    public function remove($id)
    {
        $services = Services::find($id);

        $images = Service_image::where('service_id', '=', $services->id);

        foreach ($images->get() as $image) {
            if ($image->image != "") {
                if (file_exists('images/services/' . $image->image)) {
                    unlink('images/services/' . $image->image);
                }
            }
        }
        $services->delete();
        $images->delete();
        return redirect()->back();
    }

    public function edit(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|min:2',
            'description' => 'required|min:2',
        ]);
        $service = Services::find($request->id);
        $service->title = $request->title;
        $service->description = $request->description;
        $service->save();
        return redirect()->to('/service');
    }

    public function more()
    {
        $telegram = Setting::where('title', '=', 'telegram')->get();
        $aboutus = Setting::where('title', '=', 'aboutus')->get();
        $adobe = Setting::where('title', '=', 'adobe_reader')->get();
        $main = array();

        $array = array();

        if (!isset($telegram->first()->value)) {

            $array['telegram'] = '';
            $array['aboutus'] = '';
            $array['adobe_reader'] = '';
            array_push($main, $array);
            return $main;
        }

        $telegramUrl = $telegram->first()->value;
        if (!preg_match("~^(?:f|ht)tps?://~i", $telegramUrl)) {
            $telegramUrl = "http://" . $telegramUrl;
        }

        $array['telegram'] = $telegramUrl;
        $array['aboutus'] = $aboutus->first()->value;
        $array['adobe_reader'] = $adobe->first()->value;


        array_push($main, $array);
        return $main;
    }


    public function newserviceajax(Request $request)
    {
        if (isset($request->id)) {
            $id = $request->id;
        } else {
            $id = 0;
        }
        if ($request->ajax()) {
            $images = Service_image::where('service_id', '=', $id)->get();
            $view = view('service.ajax.service_imagedata', compact('images'))->render();
            return response()->json(['html' => $view]);
        }
    }

    public function delete_image($id)
    {
        $uploaded_image = Service_image::where('id', '=', $id)->first();
        if (empty($uploaded_image)) {
            return Response::json(['message' => 'Sorry file does not exist'], 400);
        }
        $resized_file = 'images/services/' . $uploaded_image->image;
        if (file_exists($resized_file)) {
            if (is_file($resized_file)) {
                unlink($resized_file);
            }
        }
        if (!empty($uploaded_image)) {
            $uploaded_image->delete();
        }
        return redirect()->back();
    }

    public function add_image(Request $request)
    {

        $customMessages = [
            'required' => 'نمیتواند خالی باشد :attribute'
        ];
        $this->validate($request, [
            'service_image' => 'required',
        ], $customMessages);

        $this->createFolders();

        $photo_path = "images/services";

        $photoName = $this->uploadImages($request->service_image, $photo_path);
        $upload = new Service_image();
//        $upload->filename = $photoName;
        $upload->image = $photoName;
//        $upload->original_name = $photoName;
        $upload->service_id = $request->service_id;
        $upload->save();

        return redirect()->back();
    }


    public function editservice($id)
    {
        $services = Services::find($id);
        return view('service.editservice', compact('services'));
    }


    private function createFolders()
    {
        $photo_path = "images";
        if (!is_dir($photo_path)) {
            mkdir($photo_path, 0777);
        }

        $photo_path = "images/services";
        if (!is_dir($photo_path)) {
            mkdir($photo_path, 0777);
        }
    }

    private function uploadImages($image, $path)
    {
        $name = sha1(date('YmdHis') . str_random(15));
        $photoName = time() . $name . '.' . $image->getClientOriginalExtension();
//        Image::make($image)
//            ->resize(800, null, function ($constraints) {
//                $constraints->aspectRatio();
//            })->crop(500, 500)->trim()
//            ->save($path . '/' . $photoName);
        Image::make($image)
            ->resize(400, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save($path . '/' . $photoName);
        return $photoName;
    }


 
}
