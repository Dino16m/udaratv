<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\allmovies;
use App\Events\downloadEvent;
use Illuminate\Support\Facades\Storage;
use App\series;
use App\tags;
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
        return view('index')->with(['recents'=>$recents]);
    }
    public function getMoreRecents()
    {
        $recents=$this::getHomeCat('more');
        if(!$recents)
        {
            return back();
        }
        return view('more')->with(['recents'=>$recents]);
    }

    public function getVideosOfTag($Tag)
    {
        $tag = strtolower($Tag);
        $tag = Validator::sanitize($tag);
        $videos = tags::where('tag', $tags)->allmovies()->orderBy('name', 'ASC')->paginate(15);
        $videos->withPath('tags/'.$tag);
        if($videos->isEmpty)
        {
            return back();
        }
        $returnVids =[];
        $i=0;
        foreach ($videos as $video)
        {
          $saneModelName= preg_replace('/\s+/', '_', $video->name);
            $returnVids[$i]=
            [
                'name'=>$video->name,
                'link'=>url('movies/'.$type.'/'.$saneModelName),
                'paginator'=> [
                    'first_page_url'=>$videos->url(1),
                    'previous_page_url'=> $videos->previousPageUrl(), 
                    'next_page_url'=>$videos->nextPageUrl(),
                    'last_page_url'=> $videos->url($videos->lastPage()),
                    'last'=>$videos->lastPage(),
                    'path'=>url('tags/'.$tag.'?page=')
                            ]
            ];
            $i++;
        }
        return view('video_index')->with(['videos'=>$returnVids]);

    }
    public function search(Request $request)
    {
        $name = strtolower($request->get('name'));
        if(!$name)
        {
            return response()->json(['error'=>'empty search']);
        }
        $name = Validator::sanitize($name);
        $queryVids = getSearch($name);
        if(!$queryVids){ return response()->json(['error'=>$name.'not found']);}
        $returnable = [];
        foreach ($queryVids as $queryVid) {
            # code...
            $thisname = $queryVid->name;
            $type = $queryVid->type;
            if(Constants::inSeries($type)){
                $link = url('series/'.$type.'/'.$thisname);
            }
            elseif (Constants::inMovie($type)) {
                $link = url('movies/'.$type.'/'.$thisname);
            }
            else{ return response()->json(['error'=>$name.'not found']);}
            $returnable[$thisname]=[
                'name'=>$thisname,
                'link'=>$link
            ];
            return response()->json($returnable);
        }

    }
    public function getVideosOfType($Type)
    {
        $type = strtolower($Type);
        $type = Validator::sanitize($type);
        $videos =  $this::getVideos($type);
        if (!$videos)
        {
            return back();
        }
        $movOrSer = Constants::inSeries($type) ? 'series' : 'movies';
        $returnVids =[];
        $i=0;
        foreach ($videos as $video)
        {
            $saneModelName= preg_replace('/\s+/', '_', $video->name);
            $returnVids[$i]=
            [
                'name'=>$video->name,
                'link'=>url($movOrSer.'/'.$type.'/'.$saneModelName),
            ];
            $i++;
        }
         $Paginator= [
                    'first_page_url'=>$videos->url(1),
                    'current_page'=>$videos->currentPage(),
                    'previous_page_url'=> $videos->previousPageUrl(), 
                    'next_page_url'=>$videos->nextPageUrl(),
                    'last_page_url'=> $videos->url($videos->lastPage()),
                    'last'=>$videos->lastPage(),
                    'path'=>url('getVideos/'.$type.'?page=')
                            ];
         $paginator= json_encode($Paginator);
        return view('video_index')->with(['videos'=>$returnVids, 'paginator'=>$paginator]);

    }
    public function getCatIndex($Type, $Cat)
    {
        //category e.g movies starting with a, b or c will have category abc
        $category = Validator::sanitize($Cat);
        if(!$this->validateRouteParameter($Type, 'routeParam') || !$this->validateRouteParameter($category, 'getParam')){
            return back();
        }
        $type=strtolower($Type);
        $type = Validator::sanitize($type);
        $models = $this::getCategoryModels($type, $category);
        if(!$models)
            { 
                return back(); 
            }
        $categoryArray=[];
        $movOrSer = Constants::inSeries($type) ? 'series' : 'movies';
        $i=0;
        foreach ($models as  $model) {
            $saneModelName= preg_replace('/\s+/', '_', $model->name);
            $categoryArray[$i]=
            [
                'name'=>$model->name,
                'link'=>url($movOrSer.'/'.$type.'/'.$saneModelName),
            ];
            $i++;
        }
        $Paginator = [
                    'first_page_url'=>$models->url(1),
                    'previous_page_url'=> $models->previousPageUrl(), 
                    'current_page'=>$models->currentPage(),
                    'next_page_url'=>$models->nextPageUrl(),
                    'last_page_url'=> $models->url($models->lastPage()),
                    'last'=>$models->lastPage(),
                    'path'=>url('categories/'.$type.'/'. $category .'?page=')
                            ];
        $paginator=json_encode($Paginator);
        return view('categories')->with(['categories'=>$categoryArray, 'type'=>$type, 'cat'=> $category, 'paginator'=>$paginator]);
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
        $name = Validator::makeInsane($name);
        $Type= Validator::sanitize($Type);
        $type = strtolower($Type);
        if(!$models)
        {
            return view('movie_not_found')->with(['movie_name'=>$name]);
        }
        $qualityArray=[];
        $qualities=$models['qualities'];
        $movie= $models['movie'];
        foreach($qualities as $model)
        {
            $qualityArray[$model->quality]=[
                'name'=>$name,
                'quality'=>$model->quality,
                'id'=>$model->id,
                'views'=> $model->number_downloaded,
                'link'=>url('download/'.$type.'/'.$model->id.'?file='.$model->file_path),
                'parent_id'=>$model->allmovies_id
            ];
        }
        return view('movie_index')->with(['qualities'=>$qualityArray, 'name'=>$name, 'desc'=>$movie->short_description,'image_link'=>$movie->image_link, 'imdb_link'=>$movie->imdb_link,  'run_time'=>$movie->run_time,  'views'=>$movie->views, 'id'=>$movie->id ]);
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
        $urlName = Validator::sanitize($Name);
        $list = $this->getSeasonsList($Type, $Name);
        $models = $list['seasons'];
        $series = $list['series'];
        $type = Validator::sanitize($Type);
        if(!$models)
        {
            return view('movie_not_found')->with(['movie_name'=>$name]);
        }
        $seasons=[];
        $i = 0;
        foreach ($models as $model) {
            $seasons[$i]=[
                'link'=>url('series/'.$model->id.'/'.$urlName.'/'.$model->season_name),
                'number'=> $model->season_name
            ];
            $i++;      
        }
         $Paginator = [
                    'first_page_url'=>$models->url(1),
                    'previous_page_url'=> $models->previousPageUrl(), 
                    'current_page'=>$models->currentPage(),
                    'next_page_url'=>$models->nextPageUrl(),
                    'last_page_url'=> $models->url($models->lastPage()),
                    'last'=>$models->lastPage(),
                    'path'=>url('series/'.$type.'/'. $urlName .'?page=')
                            ];
        $paginator=json_encode($Paginator);
        return view('series_index')->with(['name'=>$urlName,'desc'=>$series->short_description, 'seasons'=>$seasons,'image_link'=>$series->image_link, 'imdb_link'=>$series->imdb_link, 'paginator'=>$paginator, 'run_time'=>$series->run_time, 'number_of_seasons'=>$series->number_of_seasons, 'views'=>$series->views, 'id'=>$series->id]);
    
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
        $i = 0;
        foreach ($models as $model)
        {
          $episodes[$i] = 
          [
            'episode'=>$model->episode_name,
            'link' => url('seriesepisodes/'.$name.'/'.$model->id)
          ];
          $i++;  
        }
        $episodes_number = $i + 1;
        return view('episode_index')->with(['episodes'=>$episodes, 'episodes_number'=> $episodes_number,'name'=>$name ]);
    }
    /** 
    * @param Name
    * @param Id
    * expect something like url(episodes/name/id)
    * only the Id is required
    * @return view during production
    * @return JSON during dev/testing
    */
    public function getEpisode($Name, $Id)
    {
        if (!Validator::isInt($Id))
        {
            abort(404);
        }
        $id = Validator::sanitize($Id);
        $name = Validator::sanitize($Name);
        $qualities = seriesquality::where('episodes_id', $id)->get(['id', 'file_path', 'quality', 'number_downloaded', ]);
        $ArrQuality =[];
        //any view handling this should add a type of series to the episode link
        foreach ($qualities as $quality) {
            $ArrQuality[$quality->quality]=[
                'quality'=>$quality->quality,
                'views'=>$quality->number_downloaded,
                'link'=>url('download/series/'.$quality->id.'?file='.$quality->file_path)
            ];
        }
        return $qualities->isNotEmpty() ? view('episode_page')->with(['qualities'=>$ArrQuality, 'name'=>$name]) : view('movie_not_found')->with([$movie_name=>$name]);
        //return view('episode_page')->with(['qualities'=>$qualities]);
    }
    /**
    * @param Type
    * @param $Name
    * @return bool or array of model and collection
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
        $movies = allmovies::where('name', $name)->where('type', $type)->first();
        if(empty($movies) || $movies==null){
            return false;
        }
        $qualities= $movies->quality()->get();
        return ($qualities->isNotEmpty() && !empty($movies)) ? ['qualities'=>$qualities, 'movie'=>$movies] : false;
    }
    private function getVideos($type)
    {
        if(Constants::inSeries($type))
        {
            $models = series::where('type', $type)->orderBy('name', 'DESC')->paginate(10);
            if(empty($models) || $models==null){
                return false;
            }
        $models->withPath('getVideos/' .$type);
        }
        else if(Constants::inMovie($type))
        {
            $models = allmovies::where('type', $type)->paginate(10);
            if(empty($models) || $models==null){
            return false;
            }
            $modes->withPath('getVideos/'.$type);
        }
        else
        {
            return false;
        }
        return $models->isNotEmpty() ? $models : false;

    }
    /**
    * @param Type
    * @param $Name
    * @return bool or array with paginator model
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
       $series = series::where('type', $type)->where('name', $name)->first(['imdb_link', 'image_link','views', 'run_time', 'number_of_seasons', 'short_description', 'id']);
       if(empty($series) || $series==null){
            return false;
        }
       $Seasons = $series->seasons()->orderBy('season_name', 'desc')->paginate(10);
       $Seasons->withPath('series/'.$type.'/'. $Name);
       return ($Seasons->isNotEmpty() && !empty($series)) ? ['seasons'=>$Seasons, 'series'=>$series]: false;
    }
    private function getSearch($Name)
    {
        $movies = allmovies::where('name', $Name)->orWhere('name', 'like', '%'.$Name.'%')->get();
        $series= series::where('name', $Name)->orWhere('name', 'like', '%'.$Name.'%')->get();
        $returnVids = $movies->merge($series);
        return $returnVids->isNotEmpty() ? $returnVids : false;
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
    private function getHomeCat($more=null)
    {
        $count = $more==null? '10' : '30';
        $recents = Recents::where('should_show', 1)->orderBy('updated_at','desc')->take($count)->get();
        if($recents->isEmpty()){ return false;}
        $recentsArray=[];
        $i = 0;
        foreach ($recents as $recentVid)
        {
           $recentsArray[$i] = 
           [
            'name'=>$recentVid->video_name,
            'link'=>$recentVid->video_link,
            'season'=>$recentVid->season,
            'episode'=>$recentVid->episode,
            'updatedAt'=>$recentVid->updated_at->Format('H:m - d/M '),
            'image_link'=>url($recentVid->image_link)

           ];
           $i++;
        }
        return empty($recentsArray)? false : $recentsArray;
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
        if (!ctype_alnum($cat) && !preg_match('/#/', $cat))
        {
            abort(404);
        }
        $accepted = $this::typesOfVideo;
        foreach ($accepted as $accepted1)
        {
            if($accepted1== $type && Constants::inSeries($type)){
                $models = series::where('type', $type)->whereIn('first_letter_of_name',$subgroup)->orderBy('updated_at', 'desc')
                ->paginate(10);
                if(empty($models) || $models==null){
                    return false;
                }
                $models->withpath('categories/'.$type.'/'.$cat);
                break;
            }
            if ($accepted1 == $type && Constants::inMovie($type))
            {
                $models = allmovies::where('type', $type)->whereIn('first_letter_of_name',$subgroup)
                  ->orderBy('updated_at', 'desc')->paginate(10);
                  if(empty($models) || $models==null){
                    return false;
                  }
                  $models->withpath('categories/'.$type.'/'.$cat);
                  break;
            } 
        }
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
        $num = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '0'];
        $sanitizedCat= preg_replace('/\s+/', '', $cat);
        $returnArr= str_split($sanitizedCat);
        return  preg_match('/#/', $cat) ? array_merge($returnArr, $num) : $returnArr; 
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
