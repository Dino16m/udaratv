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
        $videos = $this->getTags($tag);
        if($videos==false)
        {
            return back();
        }
        $returnVids =[];
        $i=0;
        foreach ($videos as $video)
        {
            $type = $video->type;
            $thisname = preg_replace('/\s+/', '_', $video->name);
            if(Constants::inSeries($type)){
                $link = url('series/'.$type.'/'.$thisname);
            }
            elseif (Constants::inMovie($type)) {
                $link = url('movies/'.$type.'/'.$thisname);
            }
            else{ 
                return view('movie_not_found')->with(['movie_name'=>$tag]);
            }
            $returnVids[$i]=
            [
                'name'=>$video->name,
                'link'=>$link,
            ];
            $i++;
        }
        
        return view('video_index')->with(['videos'=>$returnVids,'paginator'=>'empty', 'type'=>$tag]);

    }
    public function search(Request $request)
    {
        $name = strtolower($request->get('name'));
        if(!$name)
        {
            return response()->json(['error'=>'empty search']);
        }
        $name = Validator::sanitize($name);
        $queryVids = $this::getSearch($name);
        if(!$queryVids){ return response()->json(['error'=>$name.' not found']);}
        $returnable = [];
        $count =0;
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
            else{ return response()->json(['error'=>$name.' not found']);}
            $returnable[$count]=[
                'name'=>$thisname,
                'link'=>$link
            ];
            $count++;
            
        }
        return response()->json($returnable);
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
                    'path'=>url('types/'.$type.'?page=')
                            ];
         $paginator= json_encode($Paginator);
        return view('video_index')->with(['videos'=>$returnVids, 'paginator'=>$paginator, 'type'=>$type]);

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
        $base_path = base_path('storage/app'.$path);
        if(!Validator::isInt($id) || (preg_match('~/videos/~', $path)==0 || !file_exists($base_path) ) )
        {
            return back();
        }
        $name= basename($path);
        $UA = strtolower($request->header('User-Agent'));
            $mime_type = mime_content_type($base_path);
            $mime = $mime_type === false ? 'video/mp4' : $mime_type;
            $file_size = file_exists($base_path) ? filesize($base_path) : 0; 
            ob_end_clean();
            $headers = array('Content-Type'=>$mime,
                           'Content-Length'=>$file_size);
            event( new downloadEvent(['type'=>$type, 'id'=>$id]));
            if(strpos($UA, 'ucbrowser') !==false && strpos($UA, 'mobile')!==false){
                $to = url('storage/app'.$path);
                return redirect()->away($to);
            }
        return ($name && Storage::exists($path)) ? Storage::download($path, $name, $headers) : back();
        
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
            'link' => url('seriesepisodes/'.$name.'/'.$model->id.'?S='.$season.'&E='.$model->episode_name)
          ];
          $i++;  
        }
        $episodes_number = $i;
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
    public function getEpisode($Name, $Id, Request $request)
    {
        if (!Validator::isInt($Id))
        {
            abort(404);
        }
        $Season = ( Validator::isInt($request->get('S')) && $request->get('S') !==null) ? Validator::sanitize($request->get('S')) : 'none';
        $Episode = ( Validator::isInt($request->get('E')) && $request->get('E') !==null) ? Validator::sanitize($request->get('E')) : 'none';
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
        return $qualities->isNotEmpty() ? view('episode_page')->with(['qualities'=>$ArrQuality, 'season'=>$Season,'episode'=>$Episode,'name'=>$name]) : view('movie_not_found')->with(['movie_name'=>$name]);
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
        //$models->withPath('types/' .$type);
        }
        else if(Constants::inMovie($type))
        {
            $models = allmovies::where('type', $type)->paginate(10);
            if(empty($models) || $models==null){
            return false;
            }
           // $models->withPath('types/'.$type);
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
       //$Seasons->withPath('series/'.$type.'/'. $Name);
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
       $episodes = episodes::where('season_id', $seasonId)->orderBy('episode_name', 'desc')->get();
       //this second sorting is necessary because the episode_name column is a varchar not an int, therefore numbers like 11 come before 9, this sorting changes that
       $sorted = $episodes->sortByDesc('episode_name');
       $episodes = $sorted;
       return count($episodes) < 1 ? false : $episodes;
    }
    /**
    * @return  Array
    * contents of the recently updated model
    */
    private function getHomeCat($more=null)
    {
        $count = $more==null? '10' : '30';
        $movies = collect([]);
        $series = collect([]);
        $movies = Recents::where('should_show', 1)->where('season', null)->orderBy('updated_at','desc')->take($count)->get();
        $series = Recents::where('should_show', 1)->where('season', '!=', null)->orderBy('updated_at','desc')->take($count)->get();
        $recents = $movies->merge($series);
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
                //$models->withpath('categories/'.$type.'/'.$cat);
                break;
            }
            if ($accepted1 == $type && Constants::inMovie($type))
            {
                $models = allmovies::where('type', $type)->whereIn('first_letter_of_name',$subgroup)
                  ->orderBy('updated_at', 'desc')->paginate(10);
                  if(empty($models) || $models==null){
                    return false;
                  }
                  //$models->withpath('categories/'.$type.'/'.$cat);
                  break;
            } 
        }
           return $models->isNotEmpty() ? $models : false;    
    }

    private function getTags($tag)
    {
        $tagModels = tags::where('tag', $tag)->get();
        if(empty($tagModels)){
            return view('movie_not_found')->with(['movie_name'=>$tag]);
        }
        $counter = 0;
        $videos = collect([]);
        foreach ($tagModels as $tagModel) {
            $movies= $tagModel->allmovies()->orderBy('name', 'ASC')->get();
            $series = $tagModel->series()->orderBy('name', 'ASC')->get();
            if($series->isNotEmpty() || $movies->isNotEmpty()){
               $videos=  $counter === 0 ? $movies->merge($series) :  $videos->merge($movies->merge($series)); 
            }
            $counter++;
        }

        return $videos->isNotEmpty() ? $videos : false;
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
