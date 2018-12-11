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
use App\series;

Route::get('/me', function() {
    //echo $you.' are '. $me;
   // return view('welcome');
 $id = false;
 $retval = $id ? 'one' : 'two';
 echo $retval;
});

//home i.e udaratv.com
Route::get('/', 'categoryController@index');
//categories eg udaratv.com/movies/abc
Route::get('/categories/{Type}/{Cat}', 'categoryController@getCatIndex');
//e.g udaratv.com/download/series/1
Route::get('/download/{Type}/{id}', 'categoryController@download');
//e.g udaratv.com/movies/naija/the_wedding_party 2
Route::get('movies/{Type}/{Name}', 'categoryController@getMovieIndex');
//e.g udaratv.com/naijaseries/jenifa's_diary
Route::get('series/{Type}/{Name}', 'categoryController@getSeasonsList');
// e.g udaratv.com/series/1/how_to_get_away_with_murder
Route::get('series/{season_id}/{Name}/{Season}', 'categoryController@getEpisodesIndex');
//e.g udaratv.com/series/episodes/the_flash_season1_episode_1/3
Route::get('series/episodes/{Name}/{Id}', 'categoryController@getEpisode');

Route::get('uploader/index', 'uploadController@index');
Route::post('uploader/newSeries', 'uploadController@addNewSeries');
Route::post('uploader/updateSeries', 'uploadController@updateExistingSeries');
Route::post('uploader/newMovie', 'uploadController@addNewMovie');
Route::post('uploader/updateMovie', 'uploadController@updateExistingMovie');
