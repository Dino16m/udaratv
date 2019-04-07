<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Services\emailService;
use Illuminate\Foundation\Bus\Dispatchable;

class mailSubscribers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    private $details;

    public function __construct($details)
    {
        $this->details= $details;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $mailer = new emailService($this->details);
        $mailer->handle();
    }
}
