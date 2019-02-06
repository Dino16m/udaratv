<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
| RewriteRule ^.env - [F,L,NC]
*/
use App\recently_updated as recents;
use App\Validator;
use App\seriesquality;
use App\series;
use Illuminate\Support\Facades\Storage;
use App\Events\downloadEvent;
use App\Constants;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Hash;
use \App\tags;
use \Illuminate\Database\QueryException;

Route::get('/me', function() {
    $path = '/videos/series/the%20flash/the%20flash-HD-S5-E13-(UdaraTv.com).mp4';
	  return Storage::disk('ext0')->exists('/videos/series/the flash/the flash-HD-S5-E13-(UdaraTv.com).mp4')? 'me' : 'you';
	//return str_random($length = 3).time().str_random($length = 2);
         
   

/**$string = 'wwww.me.com/ypu/public/v/ideos/love.mp4?';
//$bool = preg_match('~/public/videos/~', $string);
$match = [];
//preg_match('[^/]+$' , $string, $match);
//print_r($match);
echo basename($string);**/
});

//home i.e udaratv.com
Route::get('/', 'categoryController@index');
//categories eg udaratv.com/movies/abc
Route::get('/categories/{Type}/{Cat}', 'categoryController@getCatIndex');
//e.g udaratv.com/download/series/1
Route::get('/download/{Type}/{QualityId}', 'downloadController@download');
//e.g udaratv.com/movies/naija/the_wedding_party 2
Route::get('movies/{Type}/{Name}', 'categoryController@getMovieIndex');
//e.g udaratv.com/naijaseries/jenifa's_diary
Route::get('series/{Type}/{Name}', 'categoryController@getSeasonsIndex');
// e.g udaratv.com/series/1/how_to_get_away_with_murder
Route::get('series/{season_id}/{Name}/{Season}', 'categoryController@getEpisodesIndex');
//e.g udaratv.com/seriesepisodes/the_flash_season1_episode_1/3
Route::get('seriesepisodes/{Name}/{Id}', 'categoryController@getEpisode');
//e.g udaratv.com/recents/seemore
Route::get('recents/seemore', 'categoryController@getMoreRecents');

//e.g udaratv.com/tags/comedy
Route::get('tags/{Tag}', 'categoryController@getVideosOfTag');
Route::get('genre/{Tag}', 'categoryController@getVideosOfTag');
Route::get('tag/{Tag}', 'categoryController@getVideosOfTag');
//e.g udaratv.com/types/naija
Route::get('types/{Type}', 'categoryController@getVideosOfType');
Route::get('type/{Type}', 'categoryController@getVideosOfType');

Route::get('search', 'categoryController@search');

Route::get('uploader/index' ,['as'=>'uploader/index','middleware'=>'auth','uses'=> 'uploadController@index']);

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('filetest', 'fileController@index');
Route::post('filetest', 'fileController@upload');
