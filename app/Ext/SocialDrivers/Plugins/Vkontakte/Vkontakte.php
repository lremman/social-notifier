<?php

namespace App\Ext\SocialDrivers\Plugins\Vkontakte;

use App\Ext\SocialDrivers\Vendor\AbstractClasses\AbstractPlugin;
use App\Ext\SocialDrivers\Plugins\Vkontakte\Events;

class Vkontakte extends AbstractPlugin
{
	/**
	 * @var string
	 */
	protected $provider = 'vkontakte';

	/**
	 *
	 */
	protected $api = [
		\App\Ext\SocialDrivers\Plugins\Vkontakte\Api\VkontakteApi::class
	];

	/**
	 * 
	 */
	protected $events = [
		Events\UserIsOnline::class,
		Events\UserIsOffline::class,
		Events\UserChangeAvatar::class,
	];

	/**
	 *
	 */
	protected function getIdOrShort($url)
	{
		try {

			$parts = explode('vk.com/', $url);
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

		$response = collect($this->api()->call('users.get', ['user_ids' => $id]));

		$remoteId = array_get($response->first(), 'id');

		return $remoteId;
	}

	/**
	 * 
	 */
	public function getUserInfo($id)
	{
		$response = collect($this->api()->call('users.get', [
			'user_ids' => $id,
			'fields' => ['first_name', 'last_name', 'photo_100']
		]))->first();

		return [
			'first_name' => array_get($response, 'first_name'),
			'last_name' => array_get($response, 'last_name'),
			'image' => array_get($response, 'photo_100'),
		];
	}

}