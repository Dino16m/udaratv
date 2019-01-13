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

Route::get('/me', function() {
    //echo $you.' are '. $me;
    $RawVideoName= '000flash.mp4';
return Hash::make($RawVideoName);
   //return strtolower( substr($RawVideoName, 3, (strpos($RawVideoName, '.')-3) ));
    /**$val = pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION);
    $stream = file_get_contents($url);
    $filepath = base_path('public/images/fila.png');
    $file = file_put_contents($filepath, $stream);
    $File = new File($filepath);
   return Storage::putFileAs('/public/', $File, 'fila.png' );
/**$string = 'wwww.me.com/ypu/public/videos/love.mp4';
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
Route::get('/download/{Type}/{QualityId}', 'categoryController@download');
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
Route::get('tag/{Tag}', 'categoryController@getVideosOfTag');
//e.g udaratv.com/types/naija
Route::get('types/{Type}', 'categoryController@getVideosOfType');
Route::get('type/{Type}', 'categoryController@getVideosOfType');


Route::get('uploader/index' ,['as'=>'uploader/index','middleware'=>'auth','uses'=> 'uploadController@index']);

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
