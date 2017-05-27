<?php

namespace App\Ext\SocialDrivers\Plugins\Vkontakte\Events;

use App\FriendSocial;
use App\Timeline;

class UserIsOffline extends UserIsOnline
{

	/**
	 * 
	 */
	public function getSettingTitle()
	{
		return 'Користувач покинув мережу';
	}

	/**
	 * 
	 */
	public function getSettingDescription()
	{
		return 'Відслідкування події: користувач покинув мережу';
	}

	/**
	 * 
	 */
	public function getSettingIcon()
	{
		return 'fa fa-sign-out';
	}

	/**
	 *
	 */
	public function saveTimeLine($response)
	{
		if(array_get($response, 'online') != 0) {
			return false;
		}

		$users = $this->getEventUsers($response);

		foreach($users as $user) {

			$friendSocial = FriendSocial::query()
				->whereRemoteId(array_get($response, 'id'))
				->whereProvider($this->social->getProvider())
				->whereUserId($user->id)
				->first()
			;

			if(!$friendSocial) {
				return false;
			}

     		$timeline = Timeline::create([
     			'friend_id' => data_get($friendSocial, 'friend.id'),
     			'avatar_image' => data_get($friendSocial, 'remote_image'),
			    'attached_photo' => null,
			    'provider' => $this->social->getProvider(),
			    'page_url' => 'http://vk.com/id' . data_get($friendSocial, 'remote_id'),
			    'description' => array_get($response, 'first_name') . ' ' . array_get($response, 'last_name') . ' ' . _('вийшов з мережі'),
			]);

			$this->sendSms($response, $timeline);
		}

	}

	/**
	 *
	 **/
	public function sendSms($response, $timeline = null)
	{

		$timeline->toViber();
		
		$text = 'VK: ' . array_get($response, 'first_name') . ' ' . array_get($response, 'last_name') . ' is online';

		//dd($text);
	}
}