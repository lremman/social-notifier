<?php

namespace App\Ext\SocialDrivers\Plugins\Instagram;

use App\Ext\SocialDrivers\Vendor\AbstractClasses\AbstractPlugin;
use App\Ext\SocialDrivers\Plugins\Instagram\Events;

class Instagram extends AbstractPlugin
{
	/**
	 * @var string
	 */
	protected $provider = 'instagram';

	/**
	 *
	 */
	protected $api = [
		\App\Ext\SocialDrivers\Plugins\Instagram\Api\InstagramApi::class
	];

	/**
	 * 
	 */
	protected $events = [
		Events\UserChangeAvatar::class,
		Events\UserPostNewPhoto::class,
	];

	/**
	 *
	 */
	protected function getIdOrShort($url)
	{
		try {

			$parts = explode('instagram.com/', $url);
			$parts = explode('/', $parts[1]);
			$parts = explode('?', $parts[0]);
			$parts = explode('&', $parts[0]);

			return $parts[0];	

		} catch (\Exception $e) {

		}

		return null;

	}

	/**
	 *
	 */
	public function resolveUrl($url)
	{
		if(!$id = $this->getIdOrShort($url)) {
			return null;
		}

		$response = $this->api()->call('user.get', ['username' => $id]);


		$remoteId = array_get($response, 'pk');

		return $remoteId;
	}

	/**
	 * 
	 */
	public function getUserInfo($id)
	{
		$response = $this->api()->call('user.get', [
			'user_id' => $id,
		]);

		return [
			'first_name' => array_get($response, 'full_name'),
			'last_name' => '',
			'image' => array_get($response, 'profile_pic_url'),
		];
	}

}