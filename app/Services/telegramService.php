<?php
namespace App\Services;
use App\Constants;
use App\series;
use App\allmovies;
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
				'name'=>$this->escapeShellString($detail['video_name']), 'trailer_link'=>$detail['trailer_link']];
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
		$cmd = $this->getShellCmd($Arguments);
		$pydata = shell_exec($cmd);
		$result = json_decode($pydata);
		if($result){
			$status = $result->status ? 'success' : 'fail';
			Log::info("the status of this telegram dispatch is $status");
		}
		else{
			Log::info("the telegram dispatch failed with error $pydata");
			Log::info($cmd);
		}
		
	}

	private function escapeShellString($var)
	{
		$var = str_replace('"', '', $var);
		$var = ltrim(rtrim($var));
		return str_replace(' ', '+', $var);
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
		return ($model)? $this->escapeShellString($model->short_description) : '';
	}

	private function getShellCmd($args)
	{
		$jsonArgs = json_encode($args);
		$jsonArgs = str_replace('"', '\"', $jsonArgs);
		$executor = env('EXECUTOR_PATH', 'python ');
		$executable = env('EXECUTABLE_PATH', base_path('scripts/udaraTele.py'));
		$cmd = escapeshellcmd("$executor $executable ") .$jsonArgs;
		return  $this->sanitizeCmd($cmd);
	}

	private function sanitizeCmd($cmd)
	{
		foreach (Constants::unixSpecialChars as $key) {
			$cmd = str_replace($key, "\$key", $cmd);
		}
		return $cmd;
		
	}
}