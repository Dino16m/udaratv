<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\allmovies;
use App\Events\downloadEvent;
use Illuminate\Support\Facades\Storage;
use App\series;
use App\episodes;
use App\seriesquality;
use App\recently_updated as Recents;
use App\Validator;
use App\Constants;

class categoryController extends Controller
{
    private const typesOfVideo = Constants::supportedVideoTypes;
    private static function baseMovieUrl () {
    
        return url('/videos/');
    }
    private const slash ='/';

    public function index()
    {
        $recents= $this::getHomeCat();
        if(!$recents)
        {
            abort(404);
        }
        return view('category_home')->with($recents);
    }
    public function getCatIndex($Type, $Cat)
    {
        //category e.g movies starting with a, b or c will have category abc
        $category = $Cat;
        if(!$this->validateRouteParameter($Type, 'routeParam') || !$this->validateRouteParameter($category, 'getParam')){
            return back();
        }
        $type=strtolower($Type);
        $models = $this::getCategoryModels($type, $category);
        if(!$models)
            { 
                return back(); 
            }
        $categoryArray=[];
        $movOrSer = Constants::inSeries($type) ? 'series' : 'movies';
        foreach ($models as  $model) {
            $saneModelName= preg_replace('/\s+/', '_', $model->name);
            $categoryArray[$model->name]=
            [
                'name'=>$model->name,
                'link'=>url($movOrSer.'/'.$type.'/'.$saneModelName),
                'paginator'=> [
                    'first_page_url'=>$models->url(1),
                    'previous_page_url'=> $models->previousPageUrl(), 
                    'next_page_url'=>$models->nextPageUrl(),
                    'last_page_url'=> $models->url($models->lastPage()),
                    'last'=>$models->lastPage(),
                    'path'=>url('categories/'.$type.'category?page=')
                            ]
            ];

        }
        //return view('categories')->with($categoryArray);
        return response()->json($categoryArray);
    }

    public function download(Request $request, $Type, $QualityId)
    {
        $Path = $request->get('file');
        $Type = Validator::sanitize($Type);
        $type = strtolower($Type);
        $path = Validator::sanitize($Path);
        $id = Validator::sanitize($QualityId);
        if(!Validator::isInt($id) && preg_match('~/videos/~', $path)==0)
        {
            return back();
        }
        $name= basename($path);
        event( new downloadEvent(['type'=>$type, 'id'=>$id]));
        return ($name && Storage::exists($path)) ? Storage::download($path, $name) : back();
    }
    public function getMovieIndex($Type, $Name)
    {
        $models=$this->getMovieModel($Type, $Name);
        $name = Validator::sanitize($Name);
        $Type= Validator::sanitize($Type);
        $type = strtolower($Type);
        if(!$models)
        {
            return view('movie_not_found')->with(['movie_name'=>$name]);
        }
        $qualityArray=[];
        foreach($models as $model)
        {
            $qualityArray[$model->quality]=[
                'name'=>$name.'-'.$model->quality,
                'id'=>$model->id,
                'link'=>url('download/'.$type.'/'.$model->id),
                'parent_id'=>$model->allmovies_id
            ];
        }
        return response()->json($qualityArray);
        //return view('movie_index')->with($qualityArray);
    }
    /**
    * any view called by this method must implemment a form of replacement
    * of spaces in strings to underscores
    * @param Name
    * @param Type is the type of movie, as described by the list of supported movies in the array
    * @return view 
    */
    public function getSeasonsIndex($Type, $Name)
    {
        $name = Validator::makeInsane($Name);
        $models = $this->getSeasonsList($Type, $Name);
        if(!$models)
        {
            return view('movie_not_found')->with(['movie_name'=>$name]);
        }
        return  response()->json($models);
        //return view('series_index')->with(['seasons'=>$models]);
    
    }
    public function getEpisodesIndex($seasonId, $Name, $Season)
    {
        $models = $this->getSeasonEpisodes($seasonId, $Name, $Season);
        $name = Validator::sanitize($Name);
        $name = Validator::makeInsane($name);
        $season = Validator::sanitize($Season);
        if (!$models)
        {
            return view('movie_not_found')->with(['movie_name'=> $name.'_'.$season]);
        } 
        $episodes = [];
        foreach ($models as $model)
        {
          $episodes[$model->episode_name] = 
          [
            'episode'=>$model->episode_name,
            'link' => url('seriesepisodes/'.$name.'/'.$model->id)
          ];  
        }
        return response()->json($episodes);
        //return view('episode_index')->with(['episodes'=>$episodes]);
    }
    /** 
    * @param Name
    * @param Id
    * expect something like url(episodes/name/id)
    * only the Id is required
    * @return view during production
    * @return json during dev/testing
    */
    public function getEpisode($Name, $Id)
    {
        if (!Validator::isInt($Id))
        {
            abort(404);
        }
        $id = Validator::sanitize($Id);
        $name = Validator::sanitize($Name);
        $qualities = seriesquality::where('episodes_id', $id)->get();
        //any view handling this should add a type of series to the episode link
        return count($qualities) > 1 ? response()->json($qualities) : view('movie_not_found')->with([$movie_name=>$name]);
        //return view('episode_page')->with(['qualities'=>$qualities]);
    }
    /**
    * @param Type
    * @param $Name
    * @return bool or model
    * The Type must be one of the Constants::isSeries Array
    * Name is the name of the file(movie or series)
    */
    private function getMovieModel($Type, $Name)
    {
        $Name = Validator::sanitize($Name);
        $name= preg_replace('~_~', ' ', strtolower($Name));
        $Type = Validator::sanitize($Type);
        $type = strtolower($Type);
        if(!Constants::inMovie($type))
        {
           return false;
        }
        $qualities = allmovies::where('name', $name)->where('type', $type)->first()->quality()->get();
        return $qualities->isNotEmpty() ? $qualities : false;
    }
     /**
    * @param Type
    * @param $Name
    * @return bool or mpaginator model
    * The Type must be one of the Constants::isSeries Array
    * Name is the name of the file(movie or series)
    */
    private function getSeasonsList($Type, $Name)
    {
       $Name = Validator::sanitize($Name);
       $name = preg_replace('~_~', ' ', strtolower($Name));
       $Type = Validator::sanitize($Type);
       $type = strtolower($Type);
       if(!Constants::inSeries($type))
       {
        return false;
       }
       $Seasons = series::where('name', $name)->where('type', $type)->first()->seasons()->paginate(10);
       $Seasons->withPath('series/'.$name);
       return $Seasons->isNotEmpty() ? $Seasons: false;
    }

    /**
    * @param SeasonId
    * @param Name
    * @param Season
    * @return model or bool
    *
    */
    private function getSeasonEpisodes($SeasonId, $Name, $Season)
    {
       $SeasonId = Validator::sanitize($SeasonId);
       $seasonId = strtolower($SeasonId);
       $episodes = episodes::where('season_id', $seasonId)->get();
       return count($episodes) < 1 ? false : $episodes;
    }
    /**
    * @return  Array
    * contents of the recently updated model
    */
    private function getHomeCat()
    {
        $recents = Recents::where('should_show', 1)->orderBy('created_at','desc')->take('10')->get();
        if($recents->isEmpty()){ return false;}
        $recentsArray=[];
        foreach ($recents as $recentVid)
        {
           $recentsArray[$recentVid->video_name] = 
           [
            'name'=>$recentVid->video_name,
            'link'=>$recentVid->video_link,
            'season'=>$recentVid->season,
            'episode'=>$recentVid->episode,
            'updatedAt'=>$recentVid->updatedAt,
            'image_link'=>url($recentVid->image_link)

           ];
        }
        return $recentsArray;
    }

  /** e.g www.udaratv.com/naija/abc
    * here naija is the type whereas abc is the cat
    * for e.g this category exemplified above will return an iterable paginator of models that are naija and which their names
    * start from a, b or c
    * @param String Type
    * @param String Cat
    * @return paginator or bool  
    */
    private function getCategoryModels($Type, $Cat)
    {
        
        $cat = strtolower($Cat);
        $subgroup= $this->getSubgroup($cat);
        $type= strtolower($Type);
        $type = Validator::sanitize($type);
        $cat = Validator::sanitize($cat);
        $accepted = $this::typesOfVideo;
        foreach ($accepted as $accepted1)
        {
            if($accepted1== $type && Constants::inSeries($type)){
                $models = series::where('type', $type)->whereIn('first_letter_of_name',$subgroup)->orderBy('updated_at', 'desc')
                ->paginate(10);
                break;
            }
            if ($accepted1 == $type)
            {
                $models = allmovies::where('type', $type)->whereIn('first_letter_of_name',$subgroup)
                  ->orderBy('updated_at', 'desc')->paginate(10);
                  break;
            } 
        }
            $models->withpath('categories/'.$type.'/'.$cat);
           return $models->isNotEmpty() ? $models : false;
        
    }
    /**
    * @param cat
    * cat is a string less than 3 in length, this method converts the string into an array containing each
    * individual letter of the string to be used to search a model's table
    * @return Array
    */
    private function getSubgroup($cat)
    {
        $sanitizedCat= preg_replace('/\s+/', '', $cat);
        return str_split($sanitizedCat);
    }
    /**
    * @param $cat
    * @param $typeOf
    * @return boolean
    * this method ensures that the parameters of the route are in order to protect the application from breaking
    */
    private function validateRouteParameter($cat, $typeOf)
    {
        $accepted = $this::typesOfVideo;
        $cat = strtolower($cat);
        if ($typeOf=='getParam')
        {
        return strlen($cat)>4? false : true;
        }
        if ($typeOf=='routeParam')
        {
            foreach($accepted as $accepted1){
                if ($accepted1==$cat){ return true; }
            }
        }
        return false;
    }
}
