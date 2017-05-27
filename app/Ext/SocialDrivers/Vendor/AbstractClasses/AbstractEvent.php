<?php

namespace App\Ext\SocialDrivers\Vendor\AbstractClasses;

use App\ListenedEvent;

abstract class AbstractEvent
{
	protected $social;

	protected $response;

	protected $user;

	protected $lastState;

	public function __construct($social)
	{
		$this->social = $social;
		$this->boot();
	}

	public function boot()
	{

	}

	public function listen()
	{
		$users = $this->loadUsers($this->getMorphClass());

		$this->response = $this->getResponse($users);

		foreach ($this->response as $responseUser) {

			$lastState = $this->getLastState($responseUser);

			if ($this->isIntercepted($responseUser, $lastState)) {
				$this->saveTimeLine($responseUser);
				$this->saveState($responseUser);
			}

		}
	}

	/**
	 *
	 */
	public function getLastState($responseUser)
	{
		return $this->loadLastState($responseUser);
	}

	/**
	 * 
	 */
	public function loadUsers($morphClass)
	{
		$users = ListenedEvent::query()
			->where('event', $morphClass)
			->where('provider', $this->social->getProvider())
			->pluck('friend_remote_id')
			->toArray()
		;

		return $users;
	}

	/**
	 * 
	 */
	public function checkAbilityForUser($user = null)
	{
		return false;
	}

	/**
	 *
	 */
	public function api($type = null)
	{
		return $this->social->api($type);
	}

	/**
	 * 
	 */
	public function getSettingTitle()
	{
		return '';
	}

	/**
	 * 
	 */
	public function getSettingDescription()
	{
		return '';
	}

	/**
	 * 
	 */
	public function getSettingIcon()
	{
		return '';
	}

	/**
	 * 
	 */
	public function isIntercepted($response, $lastState)
	{
		return false;
	}

	public function databaseLastState()
	{
		return null;
	}

	/**
	 * 
	 */
	public function saveState($response)
	{

	}

	/**
	 *
	 */
	public function saveTimeLine($response)
	{

	}

	/**
	 *
	 **/
	public function sendSms($response, $timeline = null)
	{
		
	}

	/**
	 * 
	 */
	public function getMorphClass()
	{
		return studly_case($this->social->getProvider()) . strrchr(get_class($this), '\\');
	}
}