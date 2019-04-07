<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Constants;

class subscribersMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $type;
    public $name;
    public $link;
    public $receiver;

    public function __construct($details)
    {
        $type = $details['type'];
        $this->type = Constants::inSeries($type) ? 'Series' : 'Movie';
        $this->name = $details['name'];
        $this->link = $details['link'];
        $this->receiver = $details['recipient'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('subscriptions@udaratv.com')
                            ->subject('Movie request notification by udaraTv')
                            ->view('emails.subscriptions')
                            ->text('emails.subscription_plain');
    }

   
}
