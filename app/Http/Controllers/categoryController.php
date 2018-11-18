<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\naija;
use App\hollywood;
use App\series;
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
      public function getCatIndex($Type, Request $request)
    {
        //category e.g movies starting with a, b or c will have category abc
        $category = $request->get('cat');
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
        foreach ($models as  $model) {
            $saneModelName= preg_replace('/\s+/', '_', $model->name);
            $categoryArray[$model->name]=
            [
                'name'=>$model->name,
                'link'=>$this->baseMovieUrl().$type.$this::slash.$saneModelName,
                'paginator'=> $models
            ];

        }
        return view('categories')->with($categoryArray);
    }


    public function getMovieIndex($Type, $Name)
    {
        $models=$this->getMovieModel($Type, $Name);
        $name = Validator::sanitize($Name);
        if(!$models)
        {
            return view('movie_not_found')->with(['movie_name'=>$name]);
         }
        $qualityArray=[];
        foreach($models as $model)
        {
            $qualityArray[$model->quality]=[
                'name'=>$name.' '.$model->quality,
                'id'=>$model->id,
                'link'=>url($model->file_path),
                'parent_id'=>$model->allmovies_id
            ];
        }
        return view('movie_index')->with($qualityArray);
    }
    public function getSeasonsIndex($Type, $Name)
    {
        $models = $this->getSeasonsList($Type, $Name);
        $name = Validator::sanitize($Name);
        if(!$models)
        {
            return view('movie_not_found')->with(['movie_name'=>$name]);
        }
        return view('series_index')->with(['seasons'=>$models]);
       
    }
    public function getEpisodesIndex($seasonId, $Name, $Season)
    {
        $models = $this->getSeasonEpisodes($seasonId, $Name, $season);
        $name = Validator::sanitize($Name);
        $season = Validator::sanitize($Season);
        if (!$models)
        {
            return view('movie_not_found')->with(['movie_name'=> $name.'_'.$season]);
        } 
        return view('episode_index')->with(['episodes'=>$models]);
    }
    public function getEpisode($Id)
    {
        $id = Validator::sanitize($Id);
        $qualities = episodes::find($id)->quality()->get();
        return view('episode_page')->with(['qualities'=>$qualities]);
    }

  
    private function getMovieModel($Type, $Name)
    {
        $Name = Validator::sanitize($Name);
        $name= preg_replace('_', ' ', strtolower($Name));
        $Type = Validator::sanitize($Type);
        $type = strtolower($Type);
        if(!Constants::inMovie($type))
        {
           return false;
        }
        $qualities = allmovies::where('name', $name)->where('type', $type)->first()->quality()->get();
        $qualities->withPath('movies/'.$name);
        return $qualities ? $qualities : false;
    }

    private function getSeasonsList($Type, $Name)
    {
       $Name = Validator::sanitize($Name);
       $name = preg_replace('_', ' ', strtolower($Name));
       $Type = Validator::sanitize($Type);
       $type = strtolower($Type);
       if(!Constants::inSeries($type))
       {
        return false;
       }
       $Seasons = series::where('name', $name)->where('type', $type)->seasons()->paginate(10);
       $Seasons->withPath('series/'.$name);
       return $Seasons ? $Seasons: false;
    }
    private function getSeasonEpisodes($SeasonId, $Name, $Season)
    {
       $SeasonId = Validator::sanitize($SeasonId);
       $seasonId = strtolower($SeasonId);
       $episodes = episodes::where('season_id', $seasonId)->get();
       return $episodes? $episodes: false;
    }

    private function getHomeCat()
    {
        $recents = Recents::where('should_show', 1)->orderBy('created_at','desc')->take('10')->get();
        if($recents==null){ return false;}
        $recentsArray=[];
        foreach ($recents as $recentVid)
        {
           $recentsArray[$recentVid->video_name] = 
           [
            'name'=>$recentVid->video_name,
            'link'=>$recentVid->video_link,
            'season'=>$recentVid->season,
            'episode'=>$recentVid->episode,
            'updatedAt'=>$recentVid->updatedAt

           ];
        }
        return $recentsArray;
    }
  /** e.g www.udaratv.com/naija/abc
    * here naija is the type whereas abc is the cat
    * for e.g this category exemplified above will return an iterable of models that are naija and which their names
    * start from a, b or c
    * @param String Type
    * @param String Cat
    * @return  
    **/
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
            $models->withpath('/type/cat');
           return $models ? $models : false;
        
    }
    private function getSubgroup($cat)
    {
        $sanitizedCat= preg_replace('/\s+/', '', $cat);
        return str_split($sanitizedCat);
    }
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
