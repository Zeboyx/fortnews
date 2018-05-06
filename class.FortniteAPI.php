<?php

/*----------------------------------------------------------*/
/*	FortniteAPI.com
/*	aortniteapi.com, wenters.com and fornitestatus.com are not affiliated with Epicgames.
/*
/*	Api version: 1.2. 6 May 2018.
/*
/*	Created by Sam from Wenters.com.
/*----------------------------------------------------------*/

class FortniteAPI 
{
	private $api = 'https://fortniteapi.com/api/';
	private $search = 'https://fortniteapi.com/docs/search/';

	private $key;

	public function setKey()
	{
		$this->key = func_get_arg(0);
	}

	public function getUserID($username)
	{
		return $this->post('getUserID', ['username' => $username]);
	}

	public function getPlayerData($username, $platform, $window = 'alltime')
	{
		// $platform = ps4, xb1 or pc

		$uid = $this->getUserID($username)->uid; // this is required because we need to get the user id.

		$data = $this->getPlayerDataFromID($uid, $platform, $window);

		return $data;
	}

	private function getPlayerDataFromID($uid, $platform, $window = 'alltime')
	{
		return $this->post('playerData', ['user_id' => $uid, 'platform' => $platform, 'window' => $window]);
	}

	public function getStore($language = 'en')
	{
		return $this->post('getStore', ['language' => $language]);
	}

	public function getNews($rows = 5, $language = 'en')
	{
		return $this->post('getNews', ['rows' => $rows, 'language' => $language]);
	}

	public function getStatus()
	{
		return $this->post('getStatus', []);
	}

	public function getLeaderboard($platform = 'pc', $type = 'solo')
	{
		return $this->post('getLeaderboard', ['platform' => $platform, 'type' => $type]);
	}

	public function getPatchNotes()
	{
		return $this->post('getPatchNotes', []);
	}

	public function getUsernameFromId($ids = null) // please enter an array with user ids
	{
		return $this->post('getUsername', ['ids' => $ids]);
	}

	private function post($type, $data)
	{
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $this->api . $type);

		curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: ' . $this->key]);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

		$output = curl_exec($ch);

		curl_close($ch);

		$output = json_decode($output);

		if(isset($output->code)) {
			die('<a href="' . $this->search . $output->code . '" target="_blank" style="color:red;text-decoration:none;">' . $output->code . ' - ' . $output->message . ' (click for more information)</a>');
		}

		return $output;
	}
}

?>
