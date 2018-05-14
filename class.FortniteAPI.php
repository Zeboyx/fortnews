<?php

/*----------------------------------------------------------*/
/*	FortniteAPI.com
/*	fortniteapi.com, wenters.com and fornitestatus.com are not affiliated with Epicgames.
/*
/*	Api version: 2. 14 May 2018.
/*
/*	Created by Sam from Wenters.com.
/*----------------------------------------------------------*/

class FortniteAPI 
{
	private $api = 'https://fortniteapi.com/api/';
	private $search = 'https://fortniteapi.com/docs/search/';

	private $key;

	/**
	 * Get Fortnite user stats
	 * @param  string $key 		(Fortnite API.com API key)
	 */
	public function setKey()
	{
		$this->key = func_get_arg(0);
	}

	/**
	 * Get Epic Games user id out of an username.
	 * @param  string $username     (Fortnite username)
	 * @return object               Decoded JSON response body
	 */
	public function getUserID($username)
	{
		return $this->post('getUserID', ['username' => $username]);
	}

	/**
	 * Get Fortnite user stats
	 * @param  string $uid          (Epic Games user id)
	 * @param  string $platform     (pc, ps4 or xb1)
	 * @return object               Decoded JSON response body
	 */
	private function getPlayerDataFromID($uid, $platform, $window = 'alltime')
	{
		return $this->post('playerData', ['user_id' => $uid, 'platform' => $platform, 'window' => $window]);
	}

	/**
	 * Get Epic Games user id out of an username.and the stats of the user in one function instead of two.
	 * @param  string $username      (Fortnite username)
	 * @param  string $platform      (pc, ps4 or xb1)
	 * @return object                Decoded JSON response body
	 */
	public function getPlayerData($username, $platform, $window = 'alltime')
	{
		$uid = $this->getUserID($username)->uid; // this is required because we need to get the user id.

		$data = $this->getPlayerDataFromID($uid, $platform, $window);

		return $data;
	}

	/**
	 * Get Fortnite store (in-game store)
	 * @param  string $language      (only EN supported at this moment)
	 * @return object                Decoded JSON response body
	 */
	public function getStore($language = 'en')
	{
		return $this->post('getStore', ['language' => $language]);
	}

	/**
	 * Get Fortnite news (in-game news)
	 * @param  string $rows          (amount of news messages)
	 * @param  string $language      (only EN supported at this moment)
	 * @return object                Decoded JSON response body
	 */
	public function getNews($rows = 5, $language = 'en')
	{
		return $this->post('getNews', ['rows' => $rows, 'language' => $language]);
	}

	/**
	 * Get the Fortnite server status
	 * @return object                Decoded JSON response body
	 */
	public function getStatus()
	{
		return $this->post('getStatus', []);
	}

	/**
	 * Get leaderboard (top 50)
	 * @param  string $platform      (pc, ps4 or xb1)
	 * @param  string $type          (solo, duo or squad)
	 * @return object                Decoded JSON response body
	 */
	public function getLeaderboard($platform = 'pc', $type = 'solo')
	{
		return $this->post('getLeaderboard', ['platform' => $platform, 'gamemode' => $type, 'window' => 'top_1_wins']);
	}

	/**
	 * Get the top players of the world (top 10)
	 * @param  string $window        (top_10_kills, total_wins or total_score)
	 * @return object                Decoded JSON response body
	 */
	public function getTop10($window = 'top_10_kills')
	{
		return $this->post('getLeaderboard', ['window' => $window]);
	}

	/**
	 * Get update patchnotes
	 * @return object                Decoded JSON response body
	 */
	public function getPatchNotes()
	{
		return $this->post('getPatchNotes', []);
	}

	/**
	 * Get Fortnite username out of an user id
	 * @param  string $uid 	         (Epic Games user id)
	 * @return object                Decoded JSON response body
	 */
	public function getUsernameFromId($ids = null) // please enter an array with user ids
	{
		return $this->post('getUsername', ['ids' => $ids]);
	}

	/**
	 * POST function to the FortniteAPI servers.
	 * @return object                Decoded JSON response body
	 */
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
