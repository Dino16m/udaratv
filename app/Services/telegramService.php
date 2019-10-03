<?php
namespace App\Services;
use App\Constants;
use App\series;
use App\allmovies;
use \GuzzleHttp\Client;
use Log;

class telegramService
{
	private $recipients;

	public  function __construct()
	{
		
	}

	public function handle($details)
	{	
		$recipients = [];
		$messages = [];
		foreach ($details as $detail) {
			array_walk($detail['recipients'], function($val) use (&$recipients)
				{
					in_array($val, $recipients)? '' : array_push($recipients, $val);
				});
			$msg = ['download_link'=>$detail['download_link'], 'description'=> $this->getDesc($detail['video_name'], $detail['type']), 
				'name'=>$detail['video_name'], 'trailer_link'=>$detail['trailer_link']];
			array_push($messages, $msg);
		}
		$this->sendMessage($messages, $recipients);
	}

	private function sendMessage($messages, $recipients)
	{
		$Arguments = [
			"recipients" => $recipients,
			"messages"=>  $messages
		];
		
		$payload = json_encode($Arguments);
		$client = new Client();
		$uri = env('TEL_SERVICE', 'http://localhost:8085/');
		$uri = $uri .'sendmessage';
		$response = $client->request('POST', $uri, ['form_params'=>['payload'=>$payload]]);
		$body = (string) $response->getBody();
		$result = json_decode($body);
		if($result){
			$status = $result->status ? 'success' : 'fail';
			Log::info("the status of this telegram dispatch is $status");
		}
		else{
			Log::info("the telegram dispatch failed with error $body");
		}
		
	}


	private function getDesc($name, $type)
	{
		$model = null;
		switch ($type) {
			case Constants::inSeries($type):
				$model = series::where('name', $name)->where('type', $type)->first(['short_description']);
				break;
			case Constants::inMovie($type):
				$model = allmovies::where('name', $name)->where('type', $type)->first(['short_description']);
				break;

			default:
				break;
		}
		return ($model)? $model->short_description : '';
	}
}