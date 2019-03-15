<?php

namespace App\Http\Controllers;

use App\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{

    public function index()
    {
        $settting = Setting::where('title', '=', 'telegram')->get();
        if (!isset($settting->first()->title)) {
            $settting = new Setting();
            $settting->title = "telegram";
            $settting->save();
        }

        $settting = Setting::where('title', '=', 'aboutus')->get();
        if (!isset($settting->first()->title)) {
            $settting = new Setting();
            $settting->title = "aboutus";
            $settting->save();
        }

        $settting = Setting::where('title', '=', 'adobe_reader')->get();
        if (!isset($settting->first()->title)) {
            $settting = new Setting();
            $settting->title = "adobe_reader";
            $settting->save();
        }

        $settting = Setting::where('title', '=', 'address')->get();
        if (!isset($settting->first()->title)) {
            $settting = new Setting();
            $settting->title = "address";
            $settting->save();
        }

        $telegram = Setting::where('title','telegram');
        $aboutus=Setting::where('title','aboutus');
        $adobeReader=Setting::where('title','adobe_reader');
        $address=Setting::where('title','address');
        return view('setting',
            [
                'telegram' => $telegram,
                'address' => $address,
                'aboutus' => $aboutus,
                'AdobeReader' => $adobeReader
            ]
        );
    }

    public function addmore(Request $request)
    {
        if (isset($request->title)) {
            DB::table('settings')
                ->where('title', $request->title)
                ->update(array('value' => $request->value));
        }
        return redirect()->back();
    }

}
