<?php

namespace App\Ext\SocialDrivers\Plugins\Vkontakte\Events;

use App\LastState;
use App\ListenedEvent;
use App\User;
use App\Timeline;
use App\FriendSocial;

class UserChangeAvatar extends UserIsOnline
{

	/**
	 * 
	 */
	public function getSettingTitle()
	{
		return 'Користувач змінив фотографію профілю';
	}

	/**
	 * 
	 */
	public function getSettingDescription()
	{
		return 'Відслідкування події: Користувач змінив фотографію профілю';
	}

	/**
	 * 
	 */
	public function getSettingIcon()
	{
		return 'fa fa-user-circle-o';
	}

	/**
	 * 
	 */
	public function checkAbilityForUser($user = null)
	{
		$response = $this->api()->call('users.get', [
			'user_ids' => [$user],
			'fields' => ['photo_max'],
		]);

		return (array_get($response, '0.photo_max')) && $user ? true : false;
	}

	/**
	 * 
	 */
	public function getResponse($users)
	{
		$response = $this->api()->call('users.get', [
			'user_ids' => $users,
			'fields' => ['photo_max', 'photo_max_orig'],
		]);

		$response = collect($response);

		return $response;
	}

	/**
	 * 
	 */
	public function isIntercepted($response, $lastState)
	{
		if (!$lastState) {
			$this->saveState($response);
			return false;
		}

		return md5((string) array_get($response, 'photo_max')) !== $lastState;
	}

	/**
	 * 
	 */
	public function saveState($response)
	{
		LastState::saveState($this->getMorphClass(), array_get($response, 'id'), md5(array_get($response, 'photo_max')));
	}

	/**
	 *
	 */
	public function saveTimeLine($response)
	{
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
			    'attached_photo' => array_get($response, 'photo_max_orig'),
			    'provider' => $this->social->getProvider(),
			    'page_url' => 'https://vk.com/id' . data_get($friendSocial, 'remote_id'),
			    'description' => array_get($response, 'first_name') . ' ' . array_get($response, 'last_name') . ' ' . _('змінив фотографію профіля'),
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