<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Services\uploadService;
use FFMpeg;
use FFMpeg\Format\Video\X264;
use Illuminate\Http\File;
use App\Constants;
use \App\series;
use \App\allmovies;
use \App\episodes;
use \App\Events\uploadEvent;
use \App\seriesquality;
use \App\moviequality;

class videoCompressionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    private const compressionDir = Constants::compressionDirectory;
    private const waterMark = Constants::waterMark; //file path for the water mark image
    private $uploadService, $fileName, $rawPath, $truePath, $details, $comprPath; //$comprPath is the file in which the compressor stores the file as its being compressed.
    private $type;
    private $event;

    public function __construct(uploadService $uploader, $details)
    {
        $this->uploadService = $uploader;
        $this->fileName = $details['name'];
        $this->rawPath = $details['raw_path'];
        $this->truePath = $details['true_path'];
        $this->details = $details;
        $this->type = $details['type'];
        $this->event = $details['eventDetails'];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $this->compress();
        $this->commit();
    }

    private function compress()
    {
        
    }

    /**
    * This method will probably be unused in production environment as Laravel-ffmpeg has the ability to stream file being compressed to my remote server
    */
    private function storeCompressedFile()
    {
       $video = new File($comprPath);
       $this->uploadService->saveVideo($this->name, $this->truePath, $video);

    }

    private function commit()
    {
        if(isset($this->details['series_id']) || isset($this->details['episode_id'])) {
            episodes::find($this->details['episode_id'])->update(['compressed'=>1]);
            seriesquality::find($this->details['quality_id'])->update(['compressed'=>1, 'file_path'=>$this->truePath]);
        }
        if(isset($this->details['movie_id'])){
            allmovies::find($this->details['movie_id'])->update(['file_path'=>$this->truePath, 'compressed'=>1]);
        }
        event(new uploadEvent($this->event));
    }
}
