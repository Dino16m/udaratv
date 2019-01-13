<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use \App\Http\Requests\videoRequests;
use \App\series;
use \App\Events\uploadEvent;
use \App\Validator;
use \App\allmovies;
use \App\seasons;
use App\Constants;
use Illuminate\Http\File;


class uploadController extends Controller
{
  /**Requirements for a file to be uploaded
   * the file name, the quality of the file, whether it is new or not, the type of video it is(i.e whether naija, naijaseries, naija or hollywood)
   *If series, it should contain the current number of seasons
   *Short description of video if new, the imdb link for the video if new
   *
   *
   **/
    /**
    *
    **/
    private const videoUploadLocation = Constants::videoUploadLocation;
    private const imageUploadLocation = Constants::imageUploadLocation; 
    private const  supportedVideoTypes = Constants::supportedVideoTypes;
    private const  isMovie = Constants::ismovie;
    /**
    * this method returns the basepath of the videoUploadLocation constant
    * @return file_path
   **/
    private function videoUploadLocation(){
      return $this::videoUploadLocation;
    }
    /**
    * this method returns the basepath of the imageUploadLocation constant
    * @return file_path
    **/
    private function imageUploadLocation(){
      return $this::imageUploadLocation;
    }
    /**
    * @return view of upload
    **/
    public function index(){
      return view('upload');
    }
    /**
    * this metyhod adds a new series to the server, it handles calls to the handler method which populates
    * the DB with information about the videos being uploaded as well as physically moving the file to an upload folder
    * this method is called by the route, it receives the request which contains the user input and
    * uploaded files
    * the video file is received in an array while the inouts to go witg each video is sent in  JSON marked for each video with a unique 
    * number that is appended to the beginnig of each filename for the videos uploaded
    * @param Request 
    * @return json
    **/
    public function addNewSeries(Request $request)
      {
      if ($request->file('files')==null){
        return response()->json(['error'=>'there are no video files here.']);
      }
      //if($request->input('age')!='new'){
        //return response()->json(['error=>there is an error in the upload api, make sure you\'re at the right place']);
      //}
      $status= array();

      foreach($request->file('files') as $video){
        $videoDetails= [];
        $RawVideoName= $video->getClientOriginalName();
        $videoDetails['video']=$video;
        $videoDetails['name']= strtolower( substr($RawVideoName, 3, (strpos($RawVideoName, '.')-3) ));
        $file_name= $videoDetails['name'];
        $videoDetails['ext']= $video->getClientOriginalExtension();
        $videoID = substr($RawVideoName, 0, 3);
        $json = json_decode($request->input('data'.$videoID));
        $videoDetails['quality']= $json->quality;
        $videoDetails['type']= $json->type;;
        $videoDetails['number_of_seasons']= $json->seasonNumber;
        $videoDetails['episodeNumber']=  $json->episodeNumber;
        $videoDetails['short_description']=  $json->desc;
        $videoDetails['imdb_link']=  $json->imdbLink;
        $videoDetails['run_time']= $json->runTime;
        $videoDetails['extLink'] = null;
        if($json->haveLink!=false && $json->extLink!='default'){
          $videoDetails['extLink'] = $json->extLink;
        }
        $videoDetails['tags']=$json->tags;
        $videoDetails['image']= $image = $request->file('image'.$videoID);
        $videoDetails['image_ext']= $image->getClientOriginalExtension();
        $videoDetails['first_letter_of_name']=substr($file_name, 0, 1);
        array_push($status, $this->handleNewSeries($videoDetails));
      }
      return response()->json([$status]);
    }

    /**
    * this method is called by a route, it handles the upload of subsequent updates to already existing series,
    * for example if a series already has an episode uploaded, subsequent episodes will be  updated using this
    * method, it calls methods that uploads the file to the server and also populates the DB with info about the uploaded series
    * the video file is received in an array while the inouts to go witg each video is sent in  JSON marked for each video with a 
    * unique 
    * number that is appended to the beginnig of each filename for the videos uploaded
    * @param Request
    * @return response()->json()
    **/
    public function updateExistingSeries( Request $request)
    {
      if ($request->file('files')==null){
        return response()->json(['error'=>'there are no video files here.']);
      }
       //if($request->input('age')!='old'){
        //return response()->json(['error=>there is an error in the upload api, make sure you\'re at the right place']);
      //}
      $status=array();
      foreach ($request->file('files') as $video) {
        $videoDetails= [];
        $RawVideoName= $video->getClientOriginalName();
        $videoDetails['name']= strtolower( substr($RawVideoName, 3, (strpos($RawVideoName, '.')-3) ));
        $videoID= substr($RawVideoName, 0, 3);
        $videoDetails['video']=$video;
        $videoDetails['ext']= $video->getClientOriginalExtension();
        $json= json_decode($request->input('data'.$videoID));
        $videoDetails['should_show']= $json->shouldShow;
        $videoDetails['quality']= $json->quality;
        $videoDetails['type']=$json->type;
        $videoDetails['extLink'] = null;
        if($json->haveLink!=false && $json->extLink!='default'){
          $videoDetails['extLink'] = $json->extLink;
        }
        $videoDetails['number_of_seasons']= $json->seasonNumber;
        $videoDetails['should_touch_season']= $json->seasonChanged;
        $videoDetails['episodeNumber']= $json->episodeNumber;
        array_push($status, $this::handleOldSeries($videoDetails));
      }
      return response()->json([$status]);
    }
    /** 
    * this method is called from the route, it adds new movies to the server, it takes care of movies of every category other 
    * than series, it calls methods that uploads these movies and adds info about them to the database
    * the video file is received in an array while the inouts to go witg each video is sent in  JSON marked for each video with a 
    * unique 
    * number that is appended to the beginnig of each filename for the videos uploaded
    * @param Request
    * @return response()->json()
    **/
    public function addNewMovie(Request $request){
       if ($request->file('files')==null){
        return response()->json(['error'=>'there are no video files here.']);
      }
     //  if($request->input('age')!='new'){
       // return response()->json(['error=>there is an error in the upload api, make sure you\'re at the right place']);
      //}
      $status = array();
      foreach ($request->file('files') as $video) {
        $videoDetails=[];
        $RawVideoName= $video->getClientOriginalName();
        $videoID= substr($RawVideoName, 0, 3);
        $videoDetails['name']=$file_name=strtolower( substr($RawVideoName, 3, (strpos($RawVideoName, '.')-3) ));
        $videoDetails['video']=$video;
        $videoDetails['ext']= $video->getClientOriginalExtension();
        $json = json_decode($request->input('data'.$videoID));
        $videoDetails['quality'] = $json->quality;
        $videoDetails['type'] = $json->type;
        $videoDetails['short_description']=$json->desc;
        $videoDetails['tags']= $json->tags;
        $videoDetails['run_time']= $json->runTime;
        $videoDetails['extLink']=null;
        if($json->haveLink!=false && $json->extLink!='default'){
          $videoDetails['extLink'] = $json->extLink;
        }
        $videoDetails['imdb_link']= $json->imdbLink;
        $videoDetails['image']= $request->file('image'.$videoID);
        $videoDetails['first_letter_of_name']=substr($file_name,0 ,1);
        array_push($status, $this::handleNewMovies($videoDetails));
      }
      return response()->json([$status]);
    }
    /**
    * this method gets files and inputs exactly the same way as the other route methods listed above, it has a function of adding new
    * qualities to an already existing movie, e.g a movie already uploaded and in mp4 can have its 3gp values uploaded throught his 
    * method to ensure that both of them persist on the server and can be downloaded according to choice
    * @param Request
    * @return response()->json();
    **/
    public function updateExistingMovie(Request $request){
       if ($request->file('files')==null){
        return response()->json(['error'=>'there are no video files here.']);
      }
      // if($request->input('age')!='old'){
       // return response()->json(['error=>there is an error in the upload api, make sure you\'re at the right place']);
      //}
      $status=array();
      foreach($request->file('files') as $video){
        $videoDetails=[];
        $RawVideoName= $video->getClientOriginalName();
        $videoID= substr($RawVideoName, 0, 3);
        $videoDetails['name']= strtolower( substr($RawVideoName, 3, (strpos($RawVideoName, '.')-3) ));
        $videoDetails['video']=$video;
        $videoDetails['ext']= $video->getClientOriginalExtension();
        $json = json_decode($request->input('data'.$videoID));
        $videoDetails['should_show']= $json->shouldShow;
        $videoDetails['extLink'] = null;
        if($json->haveLink!=false && $json->extLink!='default'){
          $videoDetails['extLink'] = $json->extLink;
        }
        $videoDetails['quality'] = $json->quality;
        $videoDetails['type'] = $json->type;
        array_push($status, $this::handleOldMovies($videoDetails));
      }
      return response()->json([$status]);
    }
    /**
    * this method is called fromt the main loop of the addNewMovie method, it handles the uploading of every single file fed to
    * the above mentioned method, it receives this file and its details through an array 
    * @param Array
    * @return String
    **/
    private function handleNewMovies($Details){
      $details = $Details;
      $video=$details['video'];
      $extLink= $details['extLink'] ==null? false : $details['extLink'];
      $name= $details['name'];
      $ext= $extLink == false? $details['ext'] : pathinfo(parse_url($extLink, PHP_URL_PATH), PATHINFO_EXTENSION);
      $type=$details['type'];
      $tags = $details['tags'];
      $tags = is_array($tags) ? $tags: json_decode($tags);
      $reqs=$this::getTypeRequirement($type);
      if(!$reqs){
        return $name.' is of a file type that is not featured here yet, please contact Admin';
      }
      $file_name=$name.'.'.$ext;
      $file_path=$reqs.$file_name;
      $storage_path= $reqs;
      $details['file_path'] = $file_path;
      $image_name = Validator::sanitize(preg_replace('/\s+/', '_',  $name.'_image'));
      $image_link = url($this::imageUploadLocation().$image_name);
      $imageUploadStatus = $this::fileUpload($image_name, $this::imageUploadLocation(), $details['image'], false);
      $details['image_link'] = $imageUploadStatus==true ? $image_link: $details['imdb_link'];
      
      if(!$this::fileUpload($file_name, $storage_path, $video, true, $extLink )){
        return  $file_name.' couldn\'t be uploaded';
      }
      $model = allmovies::create($details);
      $movie = $model->add($tags);
      $moviequality= $movie->quality()->create(['quality'=>$details['quality'],'file_path'=>$file_path,'number_downloaded'=>0]);
      if ($moviequality == null){return $file_name.' not updated successfully';} 
      event( new uploadEvent(['name'=>$name, 'should_show'=>1, 'image_link'=>$details['image_link'],'type'=>$type]));

      return $file_name .' uploaded successfully';
    }
    /**
    * this method is called from the main loop of the updateExistingMovie method, it handles upload of the file and the DB
    * call necessary for this update to go on. 
    * @param Array
    * @return String
    **/
    private function handleOldMovies($Details){
      $details=$Details;
      $video=$details['video'];
      $quality = $details['quality'];
      $name= $details['name'];
      $extLink= $details['extLink'] ==null? false : $details['extLink'];
      $ext= $extLink ==false? $details['ext'] : pathinfo(parse_url($extLink, PHP_URL_PATH), PATHINFO_EXTENSION);
      $type=$details['type'];
      $movie=$this::getMovieModelandPath($type, $name);
      if(!$movie){return $name.' has an error in the type designated for it, we have no record of the name and type';}
      $model= $movie['model'];
      $image_path = $model->image_link;
      $file_name=$name.'-'.$quality.'.$ext';
      $storage_path=$movie['path'];
      $should_show=$details['should_show'];
      $file_path= $movie['path'].stripslashes($file_name);
      if(!$this::fileUpload($file_name, $storage_path, $video, true, $extLink)){
        return  $file_name.' couldn\'t be uploaded';
      }
      $moviequality=$model->quality()->firstOrCreate(['quality'=>$details['quality'],'file_path'=>$file_path,'number_downloaded'=>0]);
      if($moviequality == false)
      {
        return $file_name.' not updated successfully';
      }
      event( new uploadEvent(['name'=>$name, 'type'=>$type, 'image_link'=>$image_path, 'should_show'=>$should_show]));

      return $moviequality==null? $file_name.' not updated successfully' : $file_name.' updated successfully';
    }
    /**
    * this method is called from the main loop of the updateExistingSeries method, it adds series to the server
    * @param Array
    * @return String
    **/
    private function handleOldSeries($Details){
      $details = $Details;
      $video=$details['video'];
      $extLink= $details['extLink'] ==null? false : $details['extLink'];
      $name= $details['name'];
      $quality=$details['quality'];
      $episode= $details['episodeNumber'];
      $season=$details['number_of_seasons'];
      $should_show=$details['should_show'];
      $ext= $extLink == false? $details['ext'] : pathinfo(parse_url($extLink, PHP_URL_PATH), PATHINFO_EXTENSION);
      $type = $details['type'];
      $series= series::where('type',$type)->where('name', $name)->first();
      if($series==null){
        return $name.' couldn\'t be commited please check you have the right name and type for this series';
      }
      $upload_path=$series->series_path;
      $storage_path =$upload_path;
      $file_name= $name.'-'.$quality.'-'.$season.'-'.$episode.'.'.$ext;
      $image_path = $series->image_link;
      $file_path= $upload_path.'/'.stripslashes($file_name);
        if(!$this::fileUpload($file_name, $upload_path, $video, true, $extLink)){
        return  $file_name.' couldn\'t be uploaded';
      }
     if( $details['should_touch_season'] == 1) {
      $series->update(['number_of_seasons'=>$season]);
    }
    $newSeason = $series->seasons()->firstOrCreate(['season_name'=>$season]);
    $episodes= $newSeason->episodes()->firstOrCreate(['series_id'=>$series->id,'episode_name'=>$episode]);
    $quality=$episodes->quality()->firstOrCreate(['series_id'=>$series->id,'quality'=>$quality, 'file_path'=>$file_path, 
      'season_number'=>$season,'season_id'=>$newSeason->id,'number_downloaded'=>0]);
    if($quality == null){ return file_name.' not updated'; }
    event( new uploadEvent(['name'=>$name, 'type'=>$series->type, 'image_link'=>$image_path, 'episode'=>$episode, 'season'=>$season, 'should_show'=>$should_show]));

    return $quality==null ? $file_name.' not updated':  $file_name.' updated successfully';
    }
    /**
    * this is called from the main loop of the addNewSeries method, it adds new seeries to the serevr
    * @param Array
    * @return String
    **/
    private function handleNewSeries($Details){
      $videoDetails=$Details;
      $type = $videoDetails['type'];
      $tags = $videoDetails['tags'];
      $extLink= $Details['extLink'] ==null? false : $Details['extLink'];
      $ext= $extLink ==false? $Details['ext'] : pathinfo(parse_url($extLink, PHP_URL_PATH), PATHINFO_EXTENSION);
      $tags = is_array($tags) ? $tags: json_decode($tags);
      $file_name = $videoDetails['name'].'.'.$ext;
      $upload_path= $this::videoUploadLocation().'series/'.stripslashes($videoDetails['name']);
        if(!is_dir(base_path('/storage/app'.$upload_path))){
        if (!mkdir(base_path('/storage/app'.$upload_path), 0763)){
        return 'there was an error creating a folder for the new series '.$videoDetails['name'];
        }}
      $video = $Details['video'];
      // Attempt to upload the video
      if(!$this::fileUpload($file_name, $upload_path, $video, true, $extLink)){
        return  $file_name.' couldn\'t be uploaded';
      }
      $videoDetails['series_path']=$upload_path;
      $videoDetails['file_path']= $upload_path.'/'.stripslashes($file_name);
      $image_name =stripslashes(preg_replace('/\s+/', '_', $videoDetails['name'].'_image.'.$videoDetails['image_ext']));
      $image_link = url($this::imageUploadLocation().$image_name);
      // Attempt to upload the image 
      $imageUploadStatus = $this::fileUpload($image_name, $this::imageUploadLocation(), $Details['image'], false);
      $videoDetails['image_link' ] = $imageUploadStatus == true ? $image_link : $videoDetails['imdb_link'];
      if(series::where('type', $type)->where('name', $videoDetails['name'])->get()->isNotEmpty()){ return 'There is a video with the same name and type in existense here';}
      $Series = series::create($videoDetails);
      $series = $Series->add($tags);
      if( $series->makeNew($videoDetails) != false){
       event( new uploadEvent(['name'=>$videoDetails['name'], 'type'=>$type, 'episode'=>$videoDetails['episodeNumber'], 'image_link'=>$videoDetails['image_link'], 
        'should_show'=>'1',
        'season'=>$videoDetails['number_of_seasons']]));
      return $file_name.' uploaded successfully';
     }
     return $file_name.' not uploaded';
    }
    /**
    * this function wraps the Laravel move function, it is used in this app to upload files to the storage
    * @param String $filename
    * @param String $filePath
    * @param File
    * @return Boolean
    **/
    private function fileUpload($filename, $filePath, $file, $bool, $extLink=null){
      //please for the love of God uncomment the file move function below before pushing to production
      if($extLink == null || $extLink ==false){
        if($bool)
        {
        return Storage::putFileAs($filePath, $file, $filename);
        }
        else 
          {
          $base = base_path($filePath);
          return $file->move($base, $filename);
        }
      }
      if($extLink!=null && $extLink!=false){
        $stream = file_get_contents($extLink);
        $tmpPath = Constants::getTmp().$filename;
        $newFile = file_put_contents($tmpPath, $stream);
        $File = new File($tmpPath);
        return Storage::putFileAs($filePath, $File, $filename );
      }
    }
    /**
    * this method gets the record from the movie model matching the Name and type being uploaded
    * @param String $Type
    * @param String $Name
    * @return Array ['model', 'path'] | false if the name or type doesn't exist
    **/
    private function getMovieModelandPath($Type,$Name){
      $type=strtolower($Type);
      $name=strtolower($Name);
      $movie_path=$this::videoUploadLocation().'movies/';
      $accepted = $this::isMovie;
      foreach($accepted as $accepted1){
        if($accepted1 == $type){
          $model = allmovies::where('name', $name)->where('type',$type)->first();
          if(!$model){ break; }
          $path = $movie_path.$type.'/';
          return ['model'=>$model, 'path'=>$path];
      }
      }
      return false;
      }
    private function getTypeRequirement($Type){
      $movie_path=$this::videoUploadLocation().'movies/';
      $type=strtolower($Type);
      $accepted= $this::isMovie;
      foreach ($accepted as $accepted1 ) {
        if($accepted1 == $type){
          return $movie_path.$type.'/';
        }
      }
      return false;
    }
    
}

