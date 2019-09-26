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
use App\Services\uploadService;
use Illuminate\Http\File;


class uploadController extends Controller
{
  /**Requirements for a file to be uploaded
   * the file name, the quality of the file, whether it is new or not, the type of video it is(i.e whether naija, naijaseries, naija or hollywood)
   *If series, it should contain the current number of seasons
   *Short description of video if new, the imdb link for the video if new
   *
   *
   */
    private const videoUploadLocation = Constants::videoUploadLocation;
    private const imageUploadLocation = Constants::imageUploadLocation; 
    private const  supportedVideoTypes = Constants::supportedVideoTypes;
    private $uploadService;
    private $tempPaths;
    private $eventArray;
    /**
    * this method returns the basepath of the videoUploadLocation constant
    * @return String file_path 
   **/
    private function videoUploadLocation(){
      return $this::videoUploadLocation;
    }

    private function esc(){
      return " \"";
    }

    private function cleanUp()
    {
      foreach($this->tempPaths as $path){
        unlink($path);
      }
      
    }

    /**
    * this method returns the basepath of the imageUploadLocation constant
    * @return String file_path
    **/
    private function imageUploadLocation(){
      return $this::imageUploadLocation;
    }

   /**
   * the controller's constructor
   * @param uploadService
   **/
   public function __construct(uploadService $uploadService)
   {
    $this->tempPaths = [];
    $this->uploadService = $uploadService;
    $this->eventArray = [];
    
   }

   public function __destruct()
   {
    $this->cleanUp();
   }

    /**
    * @return view of upload
    **/
    public function index(){
      return view('upload');
    }
    /**
    * this method adds a new series to the server, it handles calls to the handler method which populates
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
      $status= array();
      foreach($request->file('files') as $video){
        $videoDetails = $this->getCommonDetails($request, $video);
        array_push($status, $this->handleNewSeries($videoDetails));
      }
      if(!empty($this->eventArray)) event(new uploadEvent($this->eventArray)); 
      return response()->json([$status]);
    }

    private function getCommonDetails($request, $video)
    {
      $details = [];
      $RawVideoName= $video->getClientOriginalName();
      $details['video']=$video;
      $details['name']= strtolower( substr($RawVideoName, 3, (strpos($RawVideoName, '.')-3) ));
      $details['ext']= $video->getClientOriginalExtension();
      $videoID = substr($RawVideoName, 0, 3);
      $json = json_decode($request->input('data'.$videoID));
      $details['quality']= $json->quality;
      $details['type']= $json->type;
      if(isset($json->desc)) $details['short_description']= $this::esc(). $json->desc .$this::esc();
      if(isset($json->imdbLink)) $details['imdb_link']=  $json->imdbLink;
      if(isset($json->runTime)) $details['run_time']= $json->runTime;
      $details['ext_link'] = ($json->haveLink!=false && $json->extLink!='default') ? $json->extLink : null;
      if($json->trailerLink){
        $details['trailer_link'] = $json->trailerLink;
        $details['should_notify'] = $json->shouldnotify;
      }
      $details['compressed']=1;
      $details['should_pull'] = $json->shouldpull;
      $details['first_letter_of_name']=substr($details['name'], 0, 1);
      if(isset($json->should_show)) $details['should_show']= $json->should_show;
      if(isset($json->tags)) $details['tags'] = $json->tags;
      if($image=$request->file('image'.$videoID)){
        $details['image']= $image = $request->file('image'.$videoID);
        $details['image_ext']= $image->getClientOriginalExtension();
      }
      if(isset($json->seasonNumber)){
        $details['number_of_seasons'] = $json->seasonNumber;
        $details['episode_number']= $json->episodeNumber;
        if(isset($json->seasonChanged)) $details['should_touch_season'] = $json->seasonChanged;
      }
      
      return $details;
    }

    /**
    * this method is called by a route, it handles the upload of subsequent updates to already existing series,
    * for example if a series already has an episode uploaded, subsequent episodes will be  updated using this
    * method, it calls methods that uploads the file to the server and also populates the DB with info about the uploaded series
    * the video file is received in an array while the inouts to go witg each video is sent in  JSON marked for each video with a 
    * unique 
    * number that is appended to the beginnig of each filename for the videos uploaded
    * @param Request
    * @return JSON
    **/
    public function updateExistingSeries( Request $request)
    {
      if ($request->file('files')==null){
        return response()->json(['error'=>'there are no video files here.']);
      }
      $status=array();
      foreach ($request->file('files') as $video) {
        $videoDetails = $this->getCommonDetails($request, $video);
        array_push($status, $this::handleOldSeries($videoDetails));
      }
      if(!empty($this->eventArray)) event(new uploadEvent($this->eventArray)); 
      return response()->json([$status]);
    }

    /** 
    * this method is called from the route, it adds new movies to the server, it takes care of movies of every category other 
    * than series, it calls methods that uploads these movies and adds info about them to the database
    * the video file is received in an array while the inouts to go witg each video is sent in  JSON marked for each video with a 
    * unique 
    * number that is appended to the beginnig of each filename for the videos uploaded
    * @param Request
    * @return JSON
    **/
    public function addNewMovie(Request $request){
       if ($request->file('files')==null){
        return response()->json(['error'=>'there are no video files here.']);
      }
      $status = array();
      foreach ($request->file('files') as $video) {
        $videoDetails = $this->getCommonDetails($request, $video);
        array_push($status, $this::handleNewMovies($videoDetails));
      }
      if(!empty($this->eventArray)) event(new uploadEvent($this->eventArray)); 
      return response()->json([$status]);
    }

    /**
    * this method gets files and inputs exactly the same way as the other route methods listed above, it has a function of adding new
    * qualities to an already existing movie, e.g a movie already uploaded and in mp4 can have its 3gp values uploaded throught his 
    * method to ensure that both of them persist on the server and can be downloaded according to choice
    * @param Request
    * @return JSON;
    **/
    public function updateExistingMovie(Request $request){
       if ($request->file('files')==null){
        return response()->json(['error'=>'there are no video files here.']);
      }
      $status=array();
      foreach($request->file('files') as $video){
        $videoDetails = $this->getCommonDetails($request, $video);
        array_push($status, $this::handleOldMovies($videoDetails));
      }
      if(!empty($this->eventArray)) event(new uploadEvent($this->eventArray)); 
      return response()->json([$status]);
    }

    /**
    * this method is called fromt the main loop of the addNewMovie method, it handles the uploading of every single file fed to
    * the above mentioned method, it receives this file and its details through an array 
    * @param Array
    * @return String
    **/
    private function handleNewMovies($Details){
      $details = $this->handleCommonDetails($Details, 'new');
      if(is_string($details)) return $details;
      $video = $details['video'];
      $extLink = $details['ext_link'];
      $tags = $details['tags'];
      $type = $details['type'];
      $name = $details['name'];
      $storagePath = $details['storage_path'];
      $fileName=$details['file_name'];
      $filePath = $details['file_path'];
      $quality = $details['quality'];
      if($details['should_pull'] == true){
        if(!$this::fileUpload($fileName, $storagePath, $video, true, $extLink )){
           return  $file_name.' couldn\'t be uploaded';
        }    
      }
      $movie = allmovies::create($details);
      $movie->add($tags);
      $moviequality= $movie->quality()->create(['quality'=>$quality,'file_path'=>$filePath,'number_downloaded'=>0]);
      if(!$moviequality){return $file_name.' not updated successfully';} 
      array_push($this->eventArray, ['name'=>$name, 'should_show'=>1, 'image_link'=>$details['image_link'],
            'type'=>$type, 'should_notify'=>$details['should_notify'], 'trailer_link'=>$details['trailer_link']]);
      return $fileName .' uploaded successfully';
    }

    public function handleCommonDetails($details, $status)
    {
      $numberOfSeasons  = isset($details['number_of_seasons']) ?  $details['number_of_seasons'] : '';
      $episodeNumber = isset($details['episode_number']) ? $details['episode_number'] : '';
      $extLink = (!$details['ext_link']) ? false : $details['ext_link'];
      $provisionalExtension = ($extLink == false)? $details['ext'] : pathinfo(parse_url($extLink, PHP_URL_PATH), PATHINFO_EXTENSION);
      $ext = Validator::isValidExtension($provisionalExtension) ? $provisionalExtension : $details['ext'];
      $modelAndPath = $this->getVideoModelandPath($details['name'], $details['type'], $status);
      if(is_string($modelAndPath)) return $modelAndPath;

      $details = array_merge($details, $modelAndPath);
      $details['file_name'] = $this->buildFileName($details['name'],
                 $details['quality'], $numberOfSeasons, $episodeNumber, $ext);
      $details['file_path'] = $details['should_pull'] ? 
                    $details['storage_path'].'/'.stripslashes($details['file_name']) : $extLink;
      $details['ext_link']  = $extLink;
      $details['ext'] = $ext;
      if(isset($details['tags'])){
        $tags = is_array($details['tags']) ? $details['tags']: json_decode($details['tags']);
        $details['tags'] = $tags;
      }
      if(isset($details['image'])){
         $details['image_link'] = $this->handleImages($details['name'], $details['image'], $details['image_ext']);
      }
      return $details;
    }
    /**
    * this method is called from the main loop of the updateExistingMovie method, it handles upload of the file and the DB
    * call necessary for this update to go on. 
    * @param Array
    * @return String
    **/
    private function handleOldMovies($Details){
      $details= $this->handleCommonDetails($Details, 'old');
      if(is_string($details)) return $details;
      $video = $details['video'];
      $quality = $details['quality'];
      $name= $details['name'];
      $fileName = $details['file_name'];
      $extLink= $details['ext_link'];
      $type = $details['type'];
      $movie=$details['model'];
      $movie->touch();
      $imageLink = $movie->image_link;
      $storagePath=$movie['storage_path'];
      $shouldShow = $details['should_show'];
      $filePath= $details['file_path'];
      if($details['should_pull'] == true){
        if(!$this::fileUpload($filename, $storagePath, $video, true, $extLink)){         
          return  $file_name.' couldn\'t be uploaded';
        }    
      }
      $moviequality=$movie->quality()->firstOrCreate(['quality'=>$quality,'file_path'=>$filePath,'number_downloaded'=>0]);
      if(!$moviequality)
      {
        return $fileName.' not updated successfully';
      }
      array_push($this->eventArray, ['name'=>$name, 'type'=>$type, 'image_link'=>$imageLink,
      'should_notify'=>$details['should_notify'], 'trailer_link'=>$details['trailer_link'], 'should_show'=>$shouldShow]);
      return  $fileName.' updated successfully';
    }

    /**
    * this method is called from the main loop of the updateExistingSeries method, it adds series to the server
    * @param Array
    * @return String
    **/
    private function handleOldSeries($Details){
      $details= $this->handleCommonDetails($Details, 'old');
      if(is_string($details)) return $details;
      $video = $details['video'];
      $extLink= $details['ext_link'];
      $name = $details['name'];
      $quality = $details['quality'];
      $episode= $details['episode_number'];
      $season=$details['number_of_seasons'];
      $shouldShow=$details['should_show'];
      $type = $details['type'];
      $series= $details['model'];
      $series->touch();
      $storagePath=$details['storage_path'];
      $fileName= $details['file_name'];
      $imageLink = $series->image_link;
      $filePath= $details['file_path'];
      if($details['should_pull'] == true){
        if(!$this::fileUpload($fileName, $storagePath, $video, true, $extLink)){
          return  $file_name.' couldn\'t be uploaded';
        }   
      }
     if( $details['should_touch_season'] == 1) {
      $series->update(['number_of_seasons'=>$season]);
    }
    $newSeason = $series->seasons()->firstOrCreate(['season_name'=>$season]);
    $episodes= $newSeason->episodes()->firstOrCreate(['series_id'=>$series->id,'episode_name'=>$episode]);
    $quality=$episodes->quality()->firstOrCreate(['series_id'=>$series->id,'quality'=>$quality, 'file_path'=>$filePath, 
      'season_number'=>$season,'season_id'=>$newSeason->id,'number_downloaded'=>0]);
    if(!$quality){ return fileName.' not updated'; }
    array_push($this->eventArray, ['name'=>$name, 'type'=>$series->type,'image_link'=>$imageLink, 'episode'=>$episode,
       'season'=>$season, 'should_notify'=>$details['should_notify'], 'trailer_link'=>$details['trailer_link'], 'should_show'=>$shouldShow]);
    return $fileName.' updated successfully';
    }
    
    /**
    * this is called from the main loop of the addNewSeries method, it adds new seeries to the serevr
    * @param Array
    * @return String
    **/
    private function handleNewSeries($Details){
      $details= $this->handleCommonDetails($Details, 'new');
      if(is_string($details)) return $details;
      $type = $details['type'];
      $video = $details['video'];
      $tags = $details['tags'];
      $extLink= $details['ext_link'];
      $filePath  = $details['file_path'];
      $fileName = $details['file_name'];
      $storagePath= $details['storage_path'];
      $details['series_path']=$storagePath;
      if(!is_dir(base_path('/storage/app'.$storagePath))){
        if (!mkdir(base_path('/storage/app'.$storagePath), 0763, true)){
          return 'there was an error creating a folder for the new series '.$videoDetails['name'];
        }
      }
      // Attempt to upload the video
      if($details['should_pull']==true){
         if(!$this::fileUpload($fileName, $storagePath, $video, true, $extLink)){
            return  $fileName.' couldn\'t be uploaded';
         }
      }
      $series = series::create($details);
      $series->add($tags);
      if( $series->makeNew($details) != false){
        array_push($this->eventArray, ['name'=>$details['name'], 'type'=>$type, 'episode'=>$details['episode_number'], 
          'image_link'=>$details['image_link'], 'should_show'=>'1', 'should_notify'=>$details['should_notify'], 
          'trailer_link'=>$details['trailer_link'], 'season'=>$details['number_of_seasons']]);
      return $fileName.' uploaded successfully';
     }
     
     return $fileName.' not uploaded';
    }
    /**
    * this function wraps the Laravel move function, it is used in this app to upload files to the storage
    * @param String $filename
    * @param String $filePath
    * @param File   $file
    * @return Boolean $bool
    **/
    private function fileUpload($filename, $filePath, $file, $bool, $extLink=null)
    { 
      if($extLink == null || $extLink ==false){
        if($bool)
        {
          return false; //this currently returns false because we don't have a storage server
          Storage::disk('ext0')->putFileAs($filePath, $file, $filename, 'public');
        }
        else 
        {
          $base = base_path($filePath);
          return file_exists($base.$filePath) ? true : $file->move($base, $filename);
        }
      }
      if($extLink!=null && $extLink!=false){
        return false; //this currently returns false because we don't have a storage server
	      $curl = curl_init(); 
        curl_setopt($curl, CURLOPT_URL, $extLink);
	      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	      curl_setopt($curl, CURLOPT_HEADER, false);
	      $stream = curl_exec($curl);
 	      curl_close($curl);
        $tmpPath = Constants::getTmp().$filename;
        array_push($this->tempPaths, $tmpPath);
        $newFile = file_put_contents($tmpPath, $stream);
        $File = new File($tmpPath);
        return Storage::disk('ext0')->putFileAs($filePath, $File, $filename, 'public');
      }
    }
    /**
    * this method gets the record from the movie model matching the Name and type being uploaded
    * @param String $Type
    * @param String $Name
    * @param String $status
    * @return Array ['model', 'path'] | false if the name or type doesn't exist
    **/
    private function getVideoModelandPath($Name, $Type, $status)
    {
      $status = strtolower($status);
      $name = strtolower($Name);
      $type = strtolower($Type);
      if(Constants::inSeries($Type) && $status === 'new')
      {
        $storagePath = $this->guessStoragePath($Type);
        $model = series::where('type', $type)->where('name', $name)->get();
        return $model->isEmpty() ? ['model'=>null, 'storage_path'=>$storagePath] : "series  $name with type $type already exists";
      }
      if(Constants::inSeries($Type) && $status === 'old')
      {
        $model = series::where('type',$type)->where('name', $name)->first();
        return $model ? ['model'=>$model, 'storage_path'=>$model->series_path] : "series $name with type $type does not exist";
      }
      if(Constants::inMovie($Type) && $status === 'new')
      {
        $storagePath = $this->guessStoragePath($Type);
        return ['model'=>null, 'storage_path'=>$storagePath];
      }
      if(Constants::inMovie($Type) && $status === 'old')
      {
        $model = allmovies::where('name', $name)->where('type',$type)->first();
        $storagePath = $this->guessStoragePath($Type);
        return $model ? ['model'=>$model, 'storage_path'=> $storagePath] : "movie $name with type $type does not exist";
      }
      return "their is a type and/or name mismatch with type $type and name $name";
    }

    private function guessStoragePath($Type)
    {
      $type = strtolower($Type);
      switch ($type) {
        case Constants::inSeries($type):
          return $this::videoUploadLocation().'series/';
          break;
        case Constants::inMovie($type):
          return $this::videoUploadLocation().'movies/';
          break;
        default:
          return false;
          break;
      }
    }
    
    private function buildFileName($name, $quality, $season='', $episode='', $ext)
    {
      $name = strtolower($name);
      $quality = '-'.$quality;
      $season = $season == '' ? $season : "-S$season";
      $episode = $episode == '' ? $episode : "-E$episode";
      $fileName = $name.$quality.$season.$episode.'-(UdaraTv.com)'.'.'.$ext;
      return $fileName;
    }

    private function handleImages($videoName, $imageFile, $imageFileExt)
    {
      $imageName =stripslashes(preg_replace('/\s+/', '_', $videoName.'_image.'.$imageFileExt));
      $imageLink = url($this::imageUploadLocation().$imageName);
      // Attempt to upload the image 
      $imageUploadStatus = $this::fileUpload($imageName, $this->imageUploadLocation(), $imageFile, false);
      return $imageUploadStatus == true ? $imageLink : Constants::defaultPicture;
    }
}

