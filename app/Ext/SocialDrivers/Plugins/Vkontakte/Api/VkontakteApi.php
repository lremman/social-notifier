<?php

namespace App\Ext\SocialDrivers\Plugins\Vkontakte\Api;

use App\Ext\SocialDrivers\Vendor\AbstractClasses\AbstractApi;
use Guzzle\Http\Client;

class VkontakteApi extends AbstractApi
{

	protected $url = 'https://api.vk.com/method';

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
		$data = $this->prepareData($data);

		$url = $this->url . '/' . $method;

		$client = new Client();

		$request = $client->createRequest('POST', $url, [], $data);

		$response = $client->send($request);

		$body = $response->json();

		return array_get($body, 'response');
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
			'access_token' => config('socials.vkontakte.api.token'),
			'v' => config('socials.vkontakte.api.version'),
		]);

		return $data;
	}
}
