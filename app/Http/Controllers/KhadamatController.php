<?php

namespace App\Http\Controllers;

use App\Services;
use App\Setting;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class KhadamatController extends Controller
{
    public function index()
    {
        $services = Services::select('id', 'title')->paginate(10);
        return view('khadamat.khadamat', compact('services'));
    }

    public function show($id)
    {
        $services = Services::find($id);
        return view('khadamat.show', compact('services'));
    }

    public function edit_service($id)
    {
        $services = Services::find($id);
        return view('khadamat.editkhadamat', compact('services'));
    }

    public function edit(Request $request)
    {
        $services = Services::find($request->id);
        $services->title = $request->title;
        $services->html = $request->html;
        $services->save();
        return redirect()->back();
    }

    public function delete($id)
    {
        $service=Services::find($id);
        $service->delete();
        return redirect()->back();
    }

    public function add_service(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|min:2',
            'html' => 'required'
        ]);

        $gallery = new Services();
        $gallery->title = $request->title;
        $gallery->html = $request->html;
        $gallery->save();
        return redirect()->back();
    }

    public function new_service()
    {
        return view('khadamat.newkhadamat');
    }

    public function add_image(Request $request)
    {
        $customMessages = [
            'required' => 'نمیتواند خالی باشد :attribute'
        ];
        $this->validate($request, [
            'file' => 'required',
        ], $customMessages);

        $this->createFolders();

        $photo_path = "images/services";
        $photoName = $this->uploadImages($request->file, $photo_path);
        return url('/images/services/' . $photoName);
    }



    ////////////////////////API//////////////////////

      public function more()
        {
            $telegram = Setting::where('title', '=', 'telegram')->get();
            $address = Setting::where('title', '=', 'address')->get();
            $aboutus = Setting::where('title', '=', 'aboutus')->get();
            $adobe = Setting::where('title', '=', 'adobe_reader')->get();
            $main = array();

            $array = array();

            if (!isset($telegram->first()->value)) {

                $array['address'] = '';
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

            $addressUrl = $address->first()->value;
            if (!preg_match("~^(?:f|ht)tps?://~i", $addressUrl)) {
                $addressUrl = "http://" . $addressUrl;
            }

            $array['telegram'] = $telegramUrl;
            $array['address'] = $addressUrl;
            $array['aboutus'] = $aboutus->first()->value;
            $array['adobe_reader'] = $adobe->first()->value;


            array_push($main, $array);
            return $main;
        }


    public function getKhadamat()
    {
        $services = Services::all();
        return $services;
    }

    /*    public function getKhadamatDetail(Request $request)
        {
            $services = Services::with('serviceImages')->where('id','=',$request->khadamat_id)->get();
            $services = json_decode($services, true);
            foreach ($services as $index => $service) {
                foreach ($services[$index]['service_images'] as $in => $image) {
                    $services[$index]['service_images'][$in]['image'] =
                        url('images/services/' . $services[$index]['service_images'][$in]['image']);
                }
            }
            return $services;
        }*/

    public function getKhadamatDetail(Request $request)
    {
        $services = Services::where('id', '=', $request->khadamat_id)->get();
        $services = json_decode($services, true);
        foreach ($services as $index => $service) {
            $services[$index]['html'] =
                "<style>p,strong,span{line-height: 35px !important;padding: 0 4px !important;}
 @font-face {font-family: 'vazir';src: url('  file:///android_asset/fonts/vazir.ttf') format('truetype'); !important;}     p, pre, span,strong,input, a, button, h1, h2, h3, h4, h5, h6, ul, li, option, select {font-family: vazir, 'Segoe UI', Tahoma, sans-serif !important;}
 </style>" . $services[$index]['html'];
        }
        return $services;
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
