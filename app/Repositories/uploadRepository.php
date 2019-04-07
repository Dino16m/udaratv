<?php

namespace App\Repositories;

use \App\series;
use \App\Validator;
use \App\allmovies;
use \App\seasons;
use \App\Constants;
use \App\Exceptions\seriesExistException;
use \App\Exceptions\seriesNotCreatedException;
use \App\Exceptions\seriesNotUpdatedException;
use \App\Exceptions\movieNotCreatedException;
use \App\Exceptions\movieNotUpdatedException;
use \Illuminate\Database\QueryException;

class uploadRepository {

private $series;
private $movies;

public function _construct(series $series, allmovies $movies)
{
    $this->series = $series;
    $this->movies = $movies;
}


public function createSeries($details, $tags)
{
    if ($this->checkVideoExists($details['name'], $details['type'], 'series', ['id']) ===false){
        throw new seriesNotCreatedException($details['name'].'of type'.$details['type'].' already exists');
    }
    try{
      $series = $this->series->create($details);
    } catch (QueryException $exception){
        throw new seriesNotCreatedException($exception->getMessage() );
          
    }
    $series->add($tags);
    $returnModels = $series->makeNew($details);
    if(!$returnModels){
        throw new seriesNotCreatedException('there was an error creating entries for seasons and episodes of '. $details['name']);
    }

    return $returnModels;
}

public function updateSeries($details, $model = null)
{
    $series = ($model!==null && ($model instanceof series) ) ? $model: $this->checkVideoExists($details['name'], $details['type'], 'series', ['id']);
    if($series === false){
        throw new seriesNotUpdatedException('series with name '. $details['name'] .' and type'. $details['type'] .'doesn\'t exist' );
    }
    if($details['should_touch_season']==1){
        $series->update(['number_of_seasons'=>$details['number_of_seasons']]);
    }
    try{
        $series->touch();
        $newSeason = $series->seasons()->firstOrCreate(['season_name'=>$details['number_of_seasons']]);
        $episodes= $newSeason->episodes()->firstOrCreate(['series_id'=>$series->id,'episode_name'=>$details['episodeNumber']]);
        $quality=$episodes->quality()->firstOrCreate(['series_id'=>$series->id,
                                                    'quality'=>$quality, 
                                                    'file_path'=>$details['file_path'], 
                                                    'season_number'=>$details['number_of_seasons'],
                                                    'season_id'=>$newSeason->id,
                                                    'number_downloaded'=>0]);
    }catch(QueryException $e){
        throw new seriesNotUpdatedException($e->getMessage.'there was an error updating series '. $details['name']. 'of type '. $details['type']);
        
    }
    return ['series_id'=>$series->id, 'episode_id'=>$episodes->id, $quality_id=>$quality->id];

}

public function createMovie($details, $tags)
{
    if ($this->checkVideoExists($details['name'], $details['type'], 'movie', ['id']) !==false){
        throw new movieNotCreatedException($details['name'].'of type'.$details['type'].' already exists');
    }
    try{
        $movie = $this->movies->create($details);   
    }catch(QueryException $e){
        throw new movieNotCreatedException($e->getMessage());
    }
    $movie->add($tags);
    try {
       $quality = $movie->quality()->create(['quality'=>$details['quality'],'file_path'=>$details['file_path'],'number_downloaded'=>0]);
    } catch (QueryException $e) {
        throw new movieNotCreatedException($e->getMessage());
    }
    return ['movie_id'=>$movie->id, $quality_id=>$quality->id];
}

public function updateMovie($details, $model = null)
{
    $movie = ($model !== null && ($model instanceof allmovies)) ? $model :  $this->checkVideoExists($details['name'], $details['type'], 'movie', ['id']);
    if($movie ==false){
        throw new movieNotUpdatedException('movie with name '.$details['name'].'and type '.$details['type'].' doesn\'t exist');
    }
    if($details['should_show']==1){
        $movie->touch();
    }
    try{
    $quality = $movie->quality()->firstOrCreate(['quality'=>$details['quality'],'file_path'=>$file_path,'number_downloaded'=>0]); 
    }catch(QueryException $e){
        throw new movieNotUpdatedException("An entry couldn't be created for movie with name ".$details['name'].' and type '. $details['type']);   
    }
    return ['movie_id'=>$movie->id, $quality_id=>$quality->id];

}

public function checkVideoExists($name, $type, $model, $param = []) 
{   if($model === 'series'){ 
        try{
        $series = $param==[]? $this->series->where('type', $type)->where('name', $name)->first() :
                                                                 $this->series->where('type', $type)->where('name', $name)->first($param) ;
        }catch(QueryException $e){
            return false;
        }
        return $series->isNotEmpty() ? $series : false;
    }
    elseif ($model === 'movie') {
       try{
       $movie = $param ==[]? $this->movies->where('type', $type)->where('name', $name)->first() :
                                                                 $this->movies->where('type', $type)->where('name', $name)->first();
        }catch(QueryException $e){
            return false;
        }
       return $movie->isNotEmpty() ? $movie : false; 
    }
    else{ return false;}
}

public function getModelForUpdate($name, $type, $model, $param = [])
{
    return $this->checkVideoExists($name, $type, $model, $param = []);
}

}