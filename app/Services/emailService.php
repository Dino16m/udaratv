<?php
namespace App\Services;

use \App\subscribers;
use Illuminate\Support\Facades\Mail;
use \App\Mail\subscribersMail;

class emailService
{   
    private $name;
    private $link;
    private $type;
    private $details;
    private $subscribers;
    private $sent;
    public function __construct($details)
    {
        $this->name = $details['name'];
        $this->link = $details['link'];
        $this->type = $details['type'];
        $this->sent = [];
        $this->details = $details;
    }

    public function handle()
    {
        return  $this->handleMail();
    }

    private  function handleMail()
    {   
        $subscribers = $this->hasSubscribers();
        if (!$subscribers) {
            return false;
        }
        $this->subscribers = $subscribers;
        return $subscribers ? $this->sendMail($subscribers) : false;
    }

    private function hasSubscribers()
    {
        $name = $this->name;
        $subs = subscribers::where('dispatched', 0)->where('movie_name', $name)->orWhere('movie_name', 'like', '%'.$name.'%')->get();
        return $subs->isNotEmpty() ? $subs : false;
    }

    private function sendMail($subscribers)
    {
        
        foreach ($subscribers as $subscriber) {
             $this->details['recipient'] = $subscriber->name;
             Mail::to($subscriber)->send(new subscribersMail($this->details));
             array_push($this->sent, $subscriber);
         } 
        $this->unlink();
        return;
    }

    private function unlink()
    {
        foreach ($this->sent as $received) {
            $received->update(['dispatched'=>1]);
        }
    }


}