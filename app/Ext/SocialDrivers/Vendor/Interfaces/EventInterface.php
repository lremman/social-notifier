
<?php

namespace App\Ext\SocialDrivers\Vendor\Interfaces;

interface EventInterface
{

	/**
	 * 
	 */
	public function getSettingTitle();


	/**
	 * 
	 */
	public function getSettingDescription();


	/**
	 * 
	 */
	public function getSettingIcon();


	/**
	 * 
	 */
	public function getResponse();


	/**
	 * 
	 */
	public function isIntercepted($response, $lastState);


	/**
	 * 
	 */
	public function saveState($response);


	/**
	 *
	 */
	public function saveTimeLine($response);


	/**
	 *
	 **/
	public function sendSms($response, $timeline = null);

	/**
	 *
	 */
	public function boot();

	/**
	 * 
	 */
	public function listen();

	/**
	 *
	 */
	public function api($type);

	/**
	 * 
	 */
	public function checkAbilityForUser($user = null);

}
