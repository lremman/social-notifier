<?php

namespace App\Ext\SocialDrivers\Plugins\Instagram\Api;

use App\Ext\SocialDrivers\Vendor\AbstractClasses\AbstractApi;
use Guzzle\Http\Client;
use App\InstagramLoginId;

class InstagramApi extends AbstractApi
{

	protected $generalSearchUrl = 'https://www.instagram.com/web/search/topsearch/';

	protected $mediaUrl = 'https://www.instagram.com/{username}/media/';

	protected $cache = [

		'getFromUrl' => [
			'raw' => '_getFromUrl',
			'minutes' => 4,
		],
		'call' => [
			'raw' => '_call',
			'minutes' => 1,
		]

	];

	/**
	 *
	 **/
	public function boot()
	{
		//
	}

	/**
	 * 
	 */
	protected function _call($method, $data)
	{
		return $this->resolveMethod($method, $data);
	}

	/**
	 * 
	 */
	public function resolveMethod($method, $data) 
	{
		try {
			return call_user_func_array([$this, '_m_' . str_replace('.', '_', $method)], [$data]);			
		} catch (\Exception $e) {

		}

		return false;
	}

	/**
	 *
	 */
	public function _m_general_search($data) 
	{
		$url = $this->generalSearchUrl . '?' . http_build_query($data);

		$body = $this->getFromUrl($url);

		return array_get($body, 'users');
	}

	/**
	 *
	 */
	public function _m_user_get($data) 
	{
		if (!array_get($data, 'username') && array_get($data, 'user_id')) {
			$data['username'] = $this->getLoginById(array_get($data, 'user_id'));
		}

		$users = $this->_m_general_search(['query' => array_get($data, 'username')]);

		$user = array_get($users, '0.user');


		if (array_get($user, 'username') == array_get($data, 'username')) {

			InstagramLoginId::firstOrCreate([
				'login' => array_get($user, 'username'),
				'id' => array_get($user, 'pk'),
			]);

			return $user;
		}

		return false;
	}

	/**
	 *
	 */
	public function _m_users_get($data) 
	{
		if (!$users = array_get($data, 'user_ids')) {
			return false;
		}

		$response = [];

		foreach ($users as $user) {
			$response[] = $this->_m_user_get(['user_id' => $user]);
		}

		return $response;
	}

	/**
	 *
	 */
	public function _m_media_get($data) 
	{
		if (!array_get($data, 'username') && array_get($data, 'user_id')) {
			$data['username'] = $this->getLoginById(array_get($data, 'user_id'));
		}

		$url = str_replace('{username}', $data['username'], $this->mediaUrl);

		$body = $this->getFromUrl($url);

		if ($items = array_get($body, 'items') ) {

			$body = collect($items);

			if ($limit = array_get($data, 'limit')) {
				$body = $body->take($limit);
			}

			$body = $body->map(function($photo) use ($data) {
				return array_only($photo, array_get($data,'fields'));
			})->toArray();
		}

		return $body;
	}

	/**
	 *
	 */
	public function _m_users_media_get($data) 
	{
		if (!$users = array_get($data, 'user_ids')) {
			return false;
		}

		$response = [];

		foreach ($users as $user) {
			$response[] = $this->_m_media_get([
				'user_id' => $user,
				'fields' => array_get($data, 'fields', false),
				'limit' => array_get($data, 'limit', false),
			]);
		}

		return $response;
	}

	/**
	 * 
	 */
	protected function getLoginById($id)
	{
		$igloginid = InstagramLoginId::whereId($id)->first();

		return object_get($igloginid, 'login');
	}

	/**
	 * 
	 */
	protected function getIdByLogin($login)
	{
		$igloginid = InstagramLoginId::whereLogin($login)->first();

		return object_get($igloginid, 'id');
	}

	protected function _getFromUrl($url)
	{
		$client = new Client();

		$request = $client->createRequest('GET', $url);

		$response = $client->send($request);

		$body = $response->json();

		return $body;
	}

	/**
	 *
	 */
	protected function prepareData($data) 
	{
		foreach($data as &$dataItem) {
			$dataItem = is_array($dataItem) ? implode(',', $dataItem) : $dataItem;
		}

		$data = array_merge($data, [
			'access_token' => config('socials.Instagram.api.token'),
			'v' => config('socials.Instagram.api.version'),
		]);

		return $data;
	}
}
