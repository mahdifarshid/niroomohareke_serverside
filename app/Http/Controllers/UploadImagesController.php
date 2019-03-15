<?php

namespace App\Http\Controllers;


use App\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Intervention\Image\Facades\Image;

class UploadImagesController extends Controller
{

    public function destroy2($id)
    {
        $uploaded_image = Upload::where('id','=',$id)->first();
        if (empty($uploaded_image)) {
            return Response::json(['message' => 'Sorry file does not exist'], 400);
        }
        $resized_file = 'images/products/' . $uploaded_image->resized_name;
        if (file_exists($resized_file)) {
            if(is_file($resized_file)){
                unlink($resized_file);
            }
        }
        if (!empty($uploaded_image)) {
            $uploaded_image->delete();
        }
        return redirect()->back();
    }


}
