<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Http\Requests\videoRequests;
use \App\series;
use \App\Events\uploadEvent;
use \App\allmovies;
use \App\seasons;
use App\Constants;


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
    private const supportedVideoTypes = Constants::supportedVideoTypes;
    private const isMovie = Constants::ismovie;
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
    * @return response()->json()
    **/
    public function addNewSeries(Request $request)
      {
      if ($request->file('files')==null){
        return response()->json(['error'=>'there are no video files here.']);
      }
      if($request->input('age')!='new'){
        return response()->json(['error=>there is an error in the upload api, make sure yo\'re at the right place']);
      }
      $status= array();
      foreach($request->file('files') as $video){
        $videoDetails= [];
        $RawVideoName= $video->getClientOriginalName();
        $videoDetails['video']=$video;
        $videoDetails['name']= strtolower(substr($RawVideoName, 3));
        $file_name= $videoDetails['name'];
        $videoDetails['ext']= $video->getClientOriginalExtension();
        $videoID = substr($RawVideoName, 0, 3);
        $videoDetails['quality']= $request->input('files'.$videoID.'quality');
        $videoDetails['type']= $request->input('files'.$videoID.'type');
        $videoDetails['number_of_seasons']=$request->input('files'.$videoID.'seasonNumber');
        $videoDetails['episodeNumber']= $request->input('files'.$videoID.'episodeNumber');
        $videoDetails['short_description']= $request->input('files'.$videoID.'desc');
        $videoDetails['imdb_link']= $request->input('files'.$videoID.'imdblink');
        $videoDetails['image']= $request->input('files'.$videoID.'image');
        $videoDetails['first_letter_of_name']=substr($file_name, 1);
        array_push($status, $this::handleNewSeries($videoDetails));
      }
      return response()->json([$status]);
    }

    /**
    * this method is called by a rote, it handles the upload of subsequent updates to already existing series,
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
       if($request->input('age')!='old'){
        return response()->json(['error=>there is an error in the upload api, make sure you\'re at the right place']);
      }
      $status=array();
      foreach ($request->file('files') as $video) {
        $videoDetails= [];
        $RawVideoName= $video->getClientOriginalName();
        $videoDetails['name']= strtolower( substr($RawVideoName, 3));
        $videoID= substr($RawVideoName, 0, 3);
        $videoDetails['video']=$video;
        $videoDetails['ext']= $video->getClientOriginalExtension();
        $videoDetails['should_show']= $request->input('files'.$videoID.'should_show');
        $videoDetails['quality']= $request->input('files'.$videoID.'quality');
        $videoDetails['number_of_seasons']=$request->input('files'.$videoID.'seasonNumber');
        $videoDetails['should_touch_season']=$request->input('files'.$videoID.'seasonChanged', true);
        $videoDetails['episodeNumber']= $request->input('files'.$videoID.'quality');
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
       if($request->input('age')!='new'){
        return response()->json(['error=>there is an error in the upload api, make sure you\'re at the right place']);
      }
      $status = array();
      foreach ($request->file('files') as $video) {
        $videoDetails=[];
        $RawVideoName= $video->getClientOriginalName();
        $videoID= substr($RawVideoName, 0, 3);
        $videoDetails['name']=strtolower(substr($RawVideoName, 3));
        $videoDetails['video']=$video;
        $videoDetails['ext']= $video->getClientOriginalExtension();
        $videoDetails['quality'] = $request->input('files'.$videoID.'quality');
        $videoDetails['type'] = $request->input('files'.$videoID.'type');
        $videoDetails['short_description']= $request->input('files'.$videoID.'desc');
        $videoDetails['tags']= $request->input('files'.$videoID.'tags');
        $videoDetails['imdb_link']= $request->input('files'.$videoID.'imdblink');
        $videoDetails['image']= $request->input('files'.$videoID.'image');
        $videoDetails['first_letter_of_name']=substr($file_name, 1);
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
       if($request->input('age')!='new'){
        return response()->json(['error=>there is an error in the upload api, make sure you\'re at the right place']);
      }
      $status=array();
      foreach($request->file('files') as $video){
        $videoDetails=[];
        $RawVideoName= $video->getClientOriginalName();
        $videoID= substr($RawVideoName, 0, 3);
        $videoDetails['name']= $strtolower(substr($RawVideoName, 3));
        $videoDetails['video']=$video;
        $videoDetails['ext']= $video->getClientOriginalExtension();
        $videoDetails['should_show']= $request->input('files'.$videoID.'should_show');
        $videoDetails['quality'] = $request->input('files'.$videoID.'quality');
        $videoDetails['type'] = $request->input('files'.$videoID.'type');
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
      $name= $details['name'];
      $ext= $details['ext'];
      $type=$details['type'];
      $reqs=$this::getTypeRequirement($type);
      if(!$reqs){
        return $name.' is of a file type that is not featured here yet, please contact Admin';
      }
      $file_name=$name.'.'.$ext;
      $file_path=$reqs.$file_name;
      $details['file_path'] = $file_path;
      $image_name = $name.'_image';
      $image_link = url($this::imageUploadLocation().$name);
      $imageUploadStatus = $this::fileUpload($image_name, $this::imageUploadLocation(), $details['image']);
      $imageUploadStatus ? $details['image_link']=$image_link: $details['image_link']=$details['imdb_link'];
      if(!$this::fileUpload($file_name, $upload_path, $video)){
        return  $file_name.' couldn\'t be uploaded';
      }
      $model = new allmovies();
      $movie = $model->add($details);
      $moviequality= $movie->quality()->create(['quality'=>$details['quality'],'file_path'=>$file_path,'number_downloaded'=>0]);
      event( new uploadEvent(['name'=>$name, 'file_path'=>$file_path]));

      return $moviequality==null ? $file_name.' not updated successfully': $file_name.' updated successfully'; 
    }
    /**
    * this method is called from the main loop of the updateExistingMovie emthod, it handles upload of the file and the DB
    * call necessary for this update to go on. 
    * @param Array
    * @return String
    **/
    private function handleOldMovies($Details){
      $details=$Details;
      $video=$details['video'];
      $name= $details['name'];
      $ext= $details['ext'];
      $type=$details['type'];
      $movie=$this::getMovieModelandPath($type, $name);
      if(!$movie){return $name.' has an error in the type designated for it, we have no record of the name and type';}
      $model= $movie['model'];
      $file_name=$name.'.'.$ext;
      $upload_path=$movie['path'];
      $should_show=$videoDetails['should_show'];
      $file_path= $movie['path'].stripslashes($file_name);
      if(!$this::fileUpload($file_name, $upload_path, $video)){
        return  $file_name.' couldn\'t be uploaded';
      }
      $moviequality=$model->quality()->firstOrCreate(['quality'=>$details['quality'],'file_path'=>$file_path,'number_downloaded'=>0]);
      event( new uploadEvent(['name'=>$name, 'file_path'=>$file_path, 'should_show'=>$should_show]));

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
      $name= $details['name'];
      $quality=$details['quality'];
      $episode= $details['episodeNumber'];
      $season=$details['number_of_seasons'];
      $should_show=$videoDetails['should_show'];
      $ext= $details['ext'];
      $series= series::where('name',$name)->first();
      $upload_path=$series->series_path;
      $file_name= $name.'.'.$ext;
      $file_path= $upload_path.'/'.stripslashes($file_name);
        if(!$this::fileUpload($file_name, $upload_path, $video)){
        return  $file_name.' couldn\'t be uploaded';
      }
     if( $videoDetails['should_touch_season'] ) {
      $series->update(['number_of_seasons'=>$season]);
    }
    $newSeason = $series->seasons()->firstOrCreate(['season_name'=>$season]);
    $episode= $newSeason->episodes()->firstOrCreate(['episode_name'=>$episode]);
    $quality=$episode->quality()->firstOrCreate(['series_id'=>$series->id,'episodes_id'=>$episode->id,'quality'=>$quality, 'file_path'=>$file_path, 
      'season_number'=>$season,'season_id'=>$newSeason->id,'number_downloaded'=>0]);
    event( new uploadEvent(['name'=>$name, 'file_path'=>$file_path, 'episode'=>$episode, 'season'=>$season, 'should_show'=>$should_show]));

    return $quality==null ? $file_name.' not updated':  $file_name.' updated successfully';
    }
    /**
    * this is called from the main loop of the addNewSeries method, it adds new seeries to the serevr
    * @param Array
    * @return String
    **/
    private function handleNewSeries($Details){
      $videoDetails=$Details;
      $file_name= $videoDetails['name'].'.'.$videoDetails['ext'];

      $upload_path=$this::videoUploadLocation().'series/'.stripslashes($videoDetails['name']);
      if (!mkdir($upload_path, 0763)){
        return 'there was an error creating a folder for the new series '.$videoDetails['name'];
      }
      $video = $videoDetails['video'];
      if(!$this::fileUpload($file_name, $upload_path, $video)){
        return  $file_name.' couldn\'t be uploaded';
      }
      $videoDetails['series_path']=$upload_path;
      $videoDetails['file_path']= $upload_path.'/'.stripslashes($file_name);
      $image_name =stripslashes($file_name.'_image');
      $image_link = url($this::imageUploadLocation().$file_name);
      $imageUploadStatus = $this::fileUpload($image_name, $this::imageUploadLocation(), $videoDetails['image']);
      $imageUploadStatus ? $videoDetails['image_link']=$image_link: $videoDetails['image_link']=$videoDetails['imdb_link'];
      $series = new series($videoDetails);
      event( new uploadEvent(['name'=>$videoDetails['name'], 'file_path'=>$videoDetails['file_path'], 'episode'=>$videoDetails['episodeNumber'], 
        'season'=>$videoDetails['number_of_seasons']]));
     if($series->makeNew($videoDetails)){
      return $file_name.' uploaded successfully';
     }
     return $file_name.' not uploaded';
    }
    /**
    * this file wraps the Laravel move function, it is used in this app to upload files to the storage
    * @param String $filename
    * @param String $filePath
    * @param File
    * @return Boolean
    **/
    private function fileUpload($filename, $filePath, $file){
      return $file->move($filepath, $filename);
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
          if(!model){ break; }
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
     private function checkArray($array){
      foreach($array as $element){
        if ($element==null){
          return function(){
            return 'you have empty input in your array';
          };
        }
      }
    }
}

