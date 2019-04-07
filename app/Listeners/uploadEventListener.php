<?php

namespace App\Listeners;

use App\Events\uploadEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\recently_updated as Recents;
use App\Constants;
use App\Jobs\mailSubscribers as mailer;

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
        if ($this->recentIsUnique($update, $type))
        {
            $recent = Recents::create($update);
            dispatch(new mailer(['link'=>$video_link, 'name'=>$model['name'], 'type'=>$type]));
            
        }

    }

    private function recentIsUnique($update, $type)
    {
        if(Constants::inSeries($type))
        {
            $rec = Recents::where('should_show', $update['should_show'])->where('video_name',$update['video_name'])->where('season',$update['season'])->where('episode', $update['episode'])->where('video_link', $update['video_link'])->where('image_link', $update['image_link'])->get();
            return ($rec == null || $rec->isEmpty()) ? true : false;
        }

        $rec =  Recents::where('should_show', $update['should_show'])->where('video_name',$update['video_name'])->where('season',null)->where('episode', null)->where('video_link', $update['video_link'])->where('image_link', $update['image_link'])->get();
        return ($rec == null || $rec->isEmpty()) ? true : false;

    }

    
}
