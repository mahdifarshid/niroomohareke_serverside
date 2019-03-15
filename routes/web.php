<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Posts;
use Illuminate\Http\Request;


//Route::auth();
Route::get('/', 'HomeController@index');
//Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'category', 'middleware' => 'auth'], function () {
    Route::get('/', 'CategoryController@index');
    Route::post('/addcategory', 'CategoryController@addcat');
    Route::get('/editcategory/{cat_id}', 'CategoryController@editcategory');
    Route::get('/delete/{id}', 'CategoryController@delete')->name('category.delete');
    Route::post('/editcat', 'CategoryController@editcat');
    Route::get('/editOrder', 'CategoryController@editOrder');
});

Route::group(['prefix' => 'feature', 'middleware' => 'auth'], function () {
    Route::get('/', 'FeatureController@index');
    Route::get('/delete/{id}', 'FeatureController@delete')->name('feature.delete');
    Route::post('/addfeature', 'FeatureController@addfeature');
    Route::get('/editfeature', 'FeatureController@editfeature');
    Route::post('/editfea', 'FeatureController@editfea');
    Route::post('/editOrder', 'FeatureController@editOrder');
//    Route::post('/deleteselected', 'FeatureController@deleteselected');
});

Route::group(['prefix' => 'post', 'middleware' => 'auth'], function () {
    Route::get('/', 'PostController@getpostlist');
    Route::post('/addimage', 'PostController@addimage');
    Route::get('/images-delete/{id}', 'UploadImagesController@destroy2');
    Route::get('/delete/{id}', 'PostController@delete')->name('post.delete');


    Route::get('/showpost/{id}', 'PostController@showpost');
    Route::post('/addnewpost', 'PostController@addnewpost');

    Route::get('/editpost/{id}', 'PostController@editpost');
    Route::post('/edit', 'PostController@edit');
    Route::post('/editpost/ajax', 'PostController@editpostajax');

    Route::get('/newpost', 'PostController@newpost');
    Route::post('/newpost/ajax', 'PostController@newpostajax');
    Route::post('/newpost/ajax_attr', 'PostController@ajax_attr');
});


Route::group(['prefix' => 'gallery', 'middleware' => 'auth'], function () {
    Route::get('/', 'GalleryController@index');
    Route::post('/add', 'GalleryController@add');
    Route::get('/editgallery/{id}', 'GalleryController@editgallery');
    Route::post('/edit', 'GalleryController@edit');
    Route::get('/delete/{id}', 'GalleryController@remove');
});


Route::group(['prefix' => 'service', 'middleware' => 'auth'], function () {
    Route::get('/', 'ServiceController@index');
    Route::post('/add', 'ServiceController@add');
    Route::post('/edit', 'ServiceController@edit');
    Route::get('/delete/{id}', 'ServiceController@remove');

    Route::post('/ajax', 'ServiceController@newserviceajax');
    Route::get('/images-delete/{id}', 'ServiceController@delete_image');
    Route::post('/addimage', 'ServiceController@add_image');

    Route::get('/editservice/{id}', 'ServiceController@editservice');
});

Route::group(['prefix' => 'khadamat', 'middleware' => 'auth'], function () {
    Route::get('/', 'KhadamatController@index');
    Route::get('/new', 'KhadamatController@new_service');
    Route::get('/editkhadamat/{id}', 'KhadamatController@edit_service');
    Route::post('/edit', 'KhadamatController@edit');

    Route::get('/show/{id}', 'KhadamatController@show');
    Route::post('/add', 'KhadamatController@add_service');
    Route::post('/add_image', 'KhadamatController@add_image');

    Route::get('/delete/{id}', 'KhadamatController@delete')->name('khadamat.delete');
});


Route::group(['prefix' => 'setting', 'middleware' => 'auth'], function () {
    Route::get('/', 'SettingController@index');
//    Route::post('/addabout', 'SettingController@addabout');
//    Route::post('/addchannel', 'SettingController@addchannel');
//    Route::post('/addadobe', 'SettingController@addadobe');
    Route::post('/addmore', 'SettingController@addmore');

});


Route::get('/logout', function () {
    \Illuminate\Support\Facades\Auth::logout();
    return redirect('/login');
});

Route::group(['prefix' => 'document', 'middleware' => 'auth'], function () {
    Route::get('/', 'DocumentController@document_index');
    Route::post('/addDocument', 'DocumentController@add_doc');
    Route::get('/delete/{id}', 'DocumentController@del_doc');
    Route::get('/deletefile/{id}', 'DocumentController@del_docfile');

    Route::get('/editDocument/{id}', 'DocumentController@edit_documet');
    Route::post('/editDoc', 'DocumentController@edit_doc');


    Route::get('/category', 'DocumentController@cat_index');
    Route::post('/addcat', 'DocumentController@add_cat');
    Route::get('/cat/delete/{id}', 'DocumentController@del_cat');

    Route::get('/editcategory/{id}', 'DocumentController@edit_category');
    Route::post('/editcat', 'DocumentController@edit_cat');
});


//Route::get('/test','SettingController@test');

Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
