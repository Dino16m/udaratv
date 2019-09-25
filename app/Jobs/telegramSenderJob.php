<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Services\telegramService;

class telegramSenderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $details;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($videoDetails)
    { 
     $this->details = $videoDetails;   
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $telegrammer = new telegramService();
        $telegrammer->handle($this->details);
    }
}
