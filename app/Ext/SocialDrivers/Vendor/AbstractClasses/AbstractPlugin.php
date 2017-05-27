<?php

namespace App\Ext\SocialDrivers\Vendor\AbstractClasses;

use App\Ext\SocialDrivers\Vendor\Interfaces\PluginInterface;

abstract class AbstractPlugin implements PluginInterface
{

	/**
	 * 
	 */
	private $builded = [
		'api' => [],
	];

	/**
	 *
	 */
	protected $api = [];

	/**
	 *
	 */
	public function __construct()
	{
		$this->registerApi();
		$this->registerEvents();
		$this->boot();
	}

	/**
	 * 
	 */
	private function registerApi()
	{
		foreach($this->api as $type => $class) {
			$this->builded['api'][$type] = new $class($this);
		}
	}

	/**
	 * 
	 */
	public function boot()
	{

	}

	/**
	 * 
	 */
	public function listen()
	{
		foreach ($this->events as $event) {
			$event->listen();
		}
	}

	/**
	 * 
	 */
	public function registerEvents()
	{
		foreach ($this->events as &$event) {
			$event = new $event($this);
		}
	}

	/**
	 * 
	 */
	public function getSettingsData($user = null) 
	{
		$data = [];

		foreach ($this->events as $event) {
			$data[$event->getMorphClass()] = [
				'title' => $event->getSettingTitle(),
				'description' => $event->getSettingDescription(),
				'icon' => $event->getSettingIcon(),
				'ability' => $event->checkAbilityForUser($user),
			];
		}

		return $data;
	}
	
	/**
	 * 
	 */
	public function api($type = null)
	{
		if (!$type) {
			foreach($this->builded['api'] as $api) {
				return $api;
			}
		} elseif (isset($builded['api'][$type])) {
			return $builded['api'][$type];
		}
		throw new \Exception('Api not found');
	}

	/**
	 *
	 */
	public function getProvider()
	{
		return $this->provider;
	}
}