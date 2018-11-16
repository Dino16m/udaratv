<?php

namespace App\Listeners;

use App\Events\uploadEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\recently_updated as Recents;
class uploadEventListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  uploadEvent  $event
     * @return void
     */
    public function handle(uploadEvent $event)
    {
        $model=$event->update;
        $update=[];
        $update['video_name']=$model['name'];
        $video_link=url($model['file_path']);
        if($model['season']!=null && $model['episode']!=null){
            $update['season']=$model['season'];
            $update['episode']=$model['episode'];
            $update['should_show']=$model['should_show'];
        }
        $update['video_link']=$video_link;  
        $recent = new Recents($update);
    }

    
}
