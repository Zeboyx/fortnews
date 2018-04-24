<?php

/*----------------------------------------------------------*/
/*	FortniteStatus.com
/*	FortniteStatus.com is not affiliated with Epicgames.
/*
/*	Api version: 1.0. 24 April 2018.
/*
/*	Created by Sam from Wenters.com.
/*----------------------------------------------------------*/

class FortniteStatus
{
	private $api = 'https://fortnitestatus.com/api/status';

	public $status = '';
	public $message = '';
	public $version = '';
	public $since = '';
	public $duration = '';

	public function __construct()
	{
		$data = $this->getData();

		$data = json_decode($data);

		$this->status = $data->status;
		$this->message = $data->message;
		$this->version = $data->version;
		$this->since = $data->time->since->seconds;
		$this->duration = $data->time->duration->seconds;
	}

	private function getData()
	{
		$data = $this->post();

		return $data;
	}

	private function post()
	{
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $this->api);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

		$output = curl_exec($ch);

		curl_close($ch);

		return $output;
	}
}

$fStatus = new FortniteStatus;

echo 'Current status: ' . $fStatus->status . '<br/>';
echo 'Message from Epicgames: ' . $fStatus->message . '<br/>';
echo 'Fortnite version: ' . $fStatus->version . '<br/>';
echo 'Up or down since: ' . $fStatus->since . '<br/>';
echo 'Current up- or downtime: ' . $fStatus->duration . '<br/>';

?>
