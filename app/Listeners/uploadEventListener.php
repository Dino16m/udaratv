<?php

namespace App\Listeners;

use App\Events\uploadEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\recently_updated as Recents;
use App\Constants;
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
        $type = $model['type'];
        $video_link = url('/movies/'.$type.'/'.$model['name']);
        if(Constants::inSeries($type))
        {
            $video_link = url('/series/'.$type.'/'.$model['name']);
            if($model['season']!=null && $model['episode']!=null){
                $update['season']=$model['season'];
                $update['episode']=$model['episode'];
               
                                                                 }
        } 

        $should_show = $model['should_show'] === null ? true : $model['should_show']; 
        $update['should_show']  = (int) $should_show;
        $update['image_link']= $model['image_link'];
        $update['video_link']=$video_link;  
        $recent = Recents::create($update);
    }

    
}
