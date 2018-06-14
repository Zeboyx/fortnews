<?php

class Fortnite_User
{
	private $windows = ['alltime', 'season4'];
	public $uid = null;

	public function __construct($client)
	{
		$this->Client = $client;
	}

	/*
	 * Get user id out of an username.
	 */
	public function id($username = '')
	{
		if(!empty($username))
		{
			$return = json_decode($this->Client->httpCall('users/id', ['username' => urlencode($username)]));

			if(isset($return->error))
			{
				return $return->errorMessage;
			}
			else
			{
				$this->uid = $return->uid;

				return $return;
			}
		}

		return 'Invalid username.';
	}

	/*
	 * Get username out of an user id (can be multiple in an array)
	 */
	public function getUsernameFromId($ids = null)
	{
		if(!empty($ids) && is_array($ids))
		{
			$return = json_decode($this->Client->httpCall('users/username%20out%20of%20id', ['ids' => $ids]));

			if(isset($return->error))
			{
				return $return->errorMessage;
			}
			else
			{
				return $return;
			}
		}

		return 'Usernames are invalid.';
	}

	/*
	 * Get the user stats.
	 */
	public function stats($platform = 'pc', $window = 'alltime')
	{
		(empty($user_id) && !empty($this->uid)) ? $user_id = $this->uid: '';
		(!in_array($window, $this->windows)) ? $window = 'alltime' : '';

		if(!empty($user_id) && !empty($platform))
		{
			$return = json_decode($this->Client->httpCall('users/public/br_stats', ['user_id' => $user_id, 'platform' => $platform, 'window' => $window]));

			if(isset($return->error))
			{
				return $return->errorMessage;
			}
			else
			{
				return $return;
			}
		}

		return 'Invalid user id.';
	}

	/*
	 * Get the user stats.
	 */
	public function allstats($window = 'alltime', $minify = false) // minify the request (less data) to make te request faster.
	{
		(empty($user_id) && !empty($this->uid)) ? $user_id = $this->uid: '';
		(!in_array($window, $this->windows)) ? $window = 'alltime' : '';

		if(!empty($user_id))
		{
			$return = json_decode($this->Client->httpCall('users/public/br_stats_all', ['user_id' => $user_id, 'minify' => $minify, 'window' => $window]));

			if(isset($return->error))
			{
				return $return->errorMessage;
			}
			else
			{
				return $return;
			}
		}

		return 'Invalid user id.';
	}
}

?>