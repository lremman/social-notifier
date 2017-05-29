<?php

namespace App\Ext\SocialDrivers\Plugins\Instagram\Events;

use App\Ext\SocialDrivers\Vendor\AbstractClasses\AbstractEvent;
use App\LastState;
use App\ListenedEvent;
use App\User;
use App\Timeline;
use App\FriendSocial;

class UserChangeAvatar extends AbstractEvent
{

	/**
	 * 
	 */
	public function getSettingTitle()
	{
		return 'Змінив аватар';
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
	public function getEventUsers($response, $sms = null)
	{
		$userIds = ListenedEvent::query()
            ->where('event', $this->getMorphClass())
            ->where('provider', $this->social->getProvider())
            ->where('friend_remote_id', array_get($response, 'pk'))
            
        ;

        if($sms) {
        	$userIds = $userIds->where('allow_sms', 1);
        }

        $userIds = $userIds->pluck('user_id');

        return User::findMany($userIds);
	}

	/**
	 * 
	 */
	public function checkAbilityForUser($user = null)
	{
		$response = $this->api()->call('user.get', [
			'user_id' => $user,
		]);

		return (array_get($response, 'profile_pic_url')) && $user ? true : false;
	}

	/**
	 * 
	 */
	public function getResponse($users)
	{
		$response = $this->api()->call('users.get', [
			'user_ids' => $users,
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
		return md5((string) array_get($response, 'profile_pic_url')) !== $lastState;
	}

	/**
	 *
	 */
	public function loadLastState($response)
	{
		return LastState::getState($this->getMorphClass(), array_get($response, 'pk'));
	}

	/**
	 * 
	 */
	public function saveState($response)
	{
		LastState::saveState($this->getMorphClass(), array_get($response, 'pk'), md5(array_get($response, 'profile_pic_url')));
	}

	/**
	 *
	 */
	public function saveTimeLine($response)
	{
		$users = $this->getEventUsers($response);

		foreach($users as $user) {

			$friendSocial = FriendSocial::query()
				->whereRemoteId(array_get($response, 'pk'))
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
			    'attached_photo' => array_get($response, 'profile_pic_url'),
			    'provider' => $this->social->getProvider(),
			    'page_url' => 'https://www.instagram.com/' . data_get($response, 'username'),
			    'description' => array_get($response, 'full_name') . ' ' . _('змінив фотографію профіля'),
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