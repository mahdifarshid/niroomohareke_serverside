<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/categories','CategoryController@getCetegories');

//get filter attributes
Route::post('/attributes','AttributeController@index');

//Route::post('/attributes','AttributeController@filter');
//Route::get('/attributes/attr','AttributeController@filter');

Route::group(['prefix'=>'/product'],function(){
//    Route::get('/','ProductController@getproducts');
    Route::post('/filter','ProductController@filter');
    Route::post('/detail','ProductController@getproduct_detail');
});

Route::get('/galleries','GalleryController@getGallery');
Route::get('/khadamat','KhadamatController@getKhadamat');
Route::post('/khadamatDetail','KhadamatController@getKhadamatDetail');
Route::get('/more','KhadamatController@more');


Route::get('/doc_cats','DocumentController@getdoc_cats');
Route::get('/docs','DocumentController@get_docs');
