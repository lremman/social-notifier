<?php

namespace App\Ext\SocialDrivers\Vendor\AbstractClasses;

use App\Ext\SocialDrivers\Vendor\Interfaces\ApiInterface;
use Cache;

abstract class AbstractApi implements ApiInterface
{
	protected $plugin;

	protected $cache = [

		'call' => [
			'raw' => '_call',
			'minutes' => 1,
		]

	];

	/**
	 * 
	 */
	public function __construct($plugin)
	{
		$this->plugin = $plugin;
		$this->boot();
	}

	/**
	 *
	 */
	public function makeCacheKey($data)
	{
		$key = md5(json_encode([$this->plugin->getProvider(), $data]));
		return $key;
	}

	/**
	 * 
	 */
	public function __call($method, $args)
	{
		if (isset($this->cache[$method])) {

			$options = $this->cache[$method];

			$raw = $options['raw'];
			$minutes = $options['minutes'];

			$cacheKey = $this->makeCacheKey($args);

			if(!$data = Cache::get($cacheKey)) {
				$data = json_encode(call_user_func_array([$this, $raw], $args));
				Cache::put($cacheKey, $data, $minutes);
			}

			return json_decode($data, true);
		}
	}

	/**
	 *
	 */
	public function boot()
	{

	}
}