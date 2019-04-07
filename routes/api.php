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
Route::get('mali', function(){
$mali =['i'=>'k'];
return response()->json($mali);
});
Route::post('uploader/newSeries', 'uploadController@addNewSeries');
Route::post('uploader/updateSeries', 'uploadController@updateExistingSeries');
Route::post('uploader/newMovie', 'uploadController@addNewMovie');
Route::post('uploader/updateMovie', 'uploadController@updateExistingMovie');

Route::get('search', 'categoryController@search');

Route::get('suggest', 'categoryController@suggest');

Route::get('subscribe', 'SubscriberController@subscribe');