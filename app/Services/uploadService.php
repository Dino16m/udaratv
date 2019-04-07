<?php

namespace App\Services;

use App\Constants;
use App\Repositories\uploadRepository as upRepo;
use App\Jobs\videoCompressionJob as compress;
use Illuminate\Support\Facades\Storage;
use \App\Events\uploadEvent;
use \App\Validator;
use \App\Exceptions\seriesExistException;
use \App\Exceptions\seriesNotCreatedException;
use \App\Exceptions\seriesNotUpdatedException;
use \App\Exceptions\movieNotCreatedException;
use \App\Exceptions\movieNotUpdatedException;
use Illuminate\Http\File;

/**
 *
 */
class uploadService
{


   /**Requirements for a file to be uploaded
   * the file name, the quality of the file, whether it is new or not, the type of video it is(i.e whether naija, naijaseries, naija or hollywood)
   *If series, it should contain the current number of seasons
   *Short description of video if new, the imdb link for the video if new
   *
   *
   */
    private $upRepo;
    private const videoUploadLocation = Constants::videoUploadLocation;
    private const imageUploadLocation = Constants::imageUploadLocation; 
    private const  supportedVideoTypes = Constants::supportedVideoTypes;
    private const  isMovie = Constants::ismovie;
    private $tempPath;
    /**
    * this method returns the basepath of the videoUploadLocation constant
    * @return file_path
   **/
    private function videoUploadLocation(){
      return $this::videoUploadLocation;
    }
    private function esc(){
      return " \"";
    }
    /**
    * this method returns the basepath of the imageUploadLocation constant
    * @return file_path
    **/
    private function imageUploadLocation(){
      return $this::imageUploadLocation;
    }
    
    public function __construct(upRepo $upRepo)
    {
        $this->upRepo = $upRepo;
    }
    /**
    * @param details | an Array containing the details of the upload ranging from the name to the video file proper 
    * @return String | a success message which will be returned tro the client
    **/
    public function newSeries($details)
    {
        $name = $details['name'];
        $fileName = $details['fileName'];
        $type = $details['type'];
        $tags = $details['tags'];
        $filePath= $details['file_path'];
        $shouldPull = $details['shouldpull'];
        $storeLocally = $details['store_local'];
        $extLink= $details['extLink'] ==null? false : $details['extLink'];
        $video =  $details['video'];  
        $details['compressed'] = 1; // defaults to say that the video has been compressed, this is in case an already compressed file  is uploased
        $details['image_link'] = url($this->imageUploadLocation().$details['image_name']);
        $shouldCompress = $details['should_compress']; 
        $eventDetails = ['name'=>$name, 'type'=>$type, 'image_link'=>$details['image_link'], 'episode'=>$details['episodeNumber'], 'season'=>$details['number_of_seasons'], 'should_show'=>1];
        if ($this->upRepo->checkVideoExists($name,  $type, 'series')!==false)
        {
            return 'This series with name '. $name. ' already exists, try to update it instead';
        }
        $imageUploadStatus = $this->saveImage($details['image_name'], $details['image']);

        if ($shouldCompress && $shouldPull){
           $dispatched = $this->handleCompression($details, $eventDetails);
        }
        if ( $shouldPull && !$shouldCompress) { 
            $saveStatus = $this->saveVideo($filename, $filepath, $file, $extLink, $storeLocally);
            if (!$saveStatus){return $fileName. 'could not be stored';}
        }
        try {
               $dbInfo = $this->upRepo->createSeries($details, $tags);  
        } catch (seriesNotCreatedException $e) {
                return $e->getMessage();
            }
        if (!$dispatched) {
            event( new uploadEvent($eventDetails));
        }
        $this->cleanuP();
        return (isset($dispatched ) && $dispatched == true) ? $fileName.'has been dispatched for compression' : $fileName. 'uploaded successfully';

    }

    /**
    * @param details  array containing the details of the upload, it is passed by REFERENCE please note
    **/
    private function handleCompression( &$details, $eventDetails)
    {
        $details['compressed'] = 0; // this indicates that the file is uncompressed and the value of this will be updated to 1 when the file is ccompressed
        $details['file_path'] = 'uncom'; // this is a  default string stored in the videoquality database, it indicates that the file is being compressed. it will be updated when the file is compressed
        $rawStoragePath = $this->initCompress($details);
        $details['raw_path'] = $rawStoragePath;    
        $compressionDetails = ['name'=>$name, 'type'=>$type, 'raw_path'=>$rawStoragePath,'true_path'=> $file_path, $eventDetails ];
        compress::dispatch($this, array_merge($dbInfo, $compressionDetails));
        return true;
    }
    public function updateSeries($details)
    {
        

    }

    public function newMovies()
    {

    }

    public function updateMovie()
    {
        
    }
    /**
    * @return false || file path of the file for compression on the server
    * return value is actually another method, saveFileForCompression()
    */
    private function initCompress($details, $type)
    {
        $fileName = $details['fileName'];
        $filePath = $details['file_path'];
        $extLink= $details['extLink'] ==null? false : $details['extLink'];
        $video =  $details['video'];
        if ($extLink !== false && $extLink !==null){
            $video = $this->pullFileLink($extLink, $fileName);
            return $video == false ? false : $this->saveVideoForCompression($fileName, $video);
        }
        return  $this->saveVideoForCompression($fileName, $video);
    }

    private function pullFileLink($extLink, $fileName)
    {
        $tmpName = stripslashes(str_random($length = 3).time().str_random($length = 2)).'.'.$fileName;
        $curl = curl_init(); 
        curl_setopt($curl, CURLOPT_URL, $extLink);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        $stream = curl_exec($curl);
        curl_close($curl);

        $this->tempPath = $tmpPath = Constants::getTmp().$tmpName;
        $newFile = file_put_contents($tmpPath, $stream);

        return $newFile === false ? false : new File($tmpPath);
    }

    private function saveVideo($filename, $filepath, $file, $extLink = false, $store_local = false)
    {
        if ($store_local) {
            return $this->storeLocalFile($filename, $filepath, $file, $extLink);
        }
        return $this->storeCloudFile($filename, $filepath, $file, $extLink);

    }

    private function storeLocalFile($filename, $filepath, $file, $extLink = false)
    {
        if($extLink === false || $extLink===null){
            return $this->fileUpload($filename, $filepath, $file);
        }
        if($extLink !== false && $extLink!==null){
            $pulledFile = $this->pullFileLink($extLink, $fileName);
            return $pulledFile === false? false : $this->fileUpload($filename, $filepath, $pulledFile);
        }
    }

    private function storeCloudFile($filename, $filepath, $file, $extLink = false)
    {
        if($extLink === false || $extLink===null){
            return Storage::disk('ext0')->putFileAs($filePath, $file, $filename, 'public');
        }
        if($extLink !== false && $extLink!==null){
            $pulledFile = $this->pullFileLink($extLink, $fileName);
            return $pulledFile === false? false : Storage::disk('ext0')->putFileAs($filePath, $file, $filename, 'public');
        }
    }

    private function makeLocalDir($path)
    {
         if(!is_dir(base_path('/storage/app'.$path))){
            if (!mkdir(base_path('/storage/app'.$path), 0763)){
                return false;
             }
        }
        return true;
    }

    private function saveVideoForCompression($filename, $file)
    {
        if ( !$this->makeLocalDir('/raw') ){
            return false;
        }
        $path = Constants::rawStoragePath;
        $rawfilename = stripslashes(str_random($length = 3).time().str_random($length = 2)) .'(||)'.$filename;
        return $this->fileUpload($rawfilename, $path, $file, false)? $path.$rawfilename : false;
    }

    private function saveImage($filename, $file)
    {
        $filepath = $this->imageUploadLocation();
        return $this->fileUpload($filename, $filepath, $file, false) ? '' : 'the image for file '.$filename. " wasn't uploaded however the path to the image is Stored by DB as ".$filepath.$filename;
    }

    private function fileUpload($filename, $filepath, $file, $isVideo = true)
    {
        if($isVideo)
        {
        return Storage::putFileAs($filepath, $file, $filename);
        }
        else 
        {
          $base = base_path($filepath);
          return $file->move($base, $filename);
        }
    }

    private function cleanUp()
    {
        $tempFile  = $this->tempPath;
        if($tempFile!=null){
            unlink($tempFile);
        }
    }

}