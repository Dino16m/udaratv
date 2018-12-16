<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use App\Events\downloadEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use App\Constants;
use App\moviequality;
use App\seriesquality;


class downloadEventListener implements ShouldQueue
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
     * @param  object  $event
     * @return void
     */
    public function handle(downloadEvent $event)
    {
        $type = $event->type;
        $id = $event->id;
        if(Constants::inSeries($type))
        {
            $quality = seriesquality::find($id);
        }
        elseif(Constants::inMovie($type))
        {
            $quality = moviequality::find($id);
        }
        else
        {
            Log::debug('an attempt has been  made to tamper with the url, the Type is '. $type .' the QualityId is '. $id);
        }
         $no_of_downloads = (int) $quality->number_downloaded;
         $no_of_downloads++;
         $quality->update(['number_downloaded'=>$no_of_downloads]);

    }
}
