<?php

namespace App\Ext\SocialDrivers\Plugins\Instagram\Events;

use App\Ext\SocialDrivers\Vendor\AbstractClasses\AbstractEvent;
use App\LastState;
use App\ListenedEvent;
use App\User;
use App\Timeline;
use App\FriendSocial;

class UserPostNewPhoto extends UserChangeAvatar
{
	/**
	 * 
	 */
	public function getSettingTitle()
	{
		return 'Користувач опублікував нову світлину';
	}

	/**
	 * 
	 */
	public function getSettingDescription()
	{
		return 'Відслідкування події: Користувач опублікував нову світлину';
	}

	/**
	 * 
	 */
	public function getSettingIcon()
	{
		return 'fa fa-image';
	}

	/**
	 * 
	 */
	public function checkAbilityForUser($user = null)
	{
		$response = $this->api()->call('media.get', [
			'user_id' => $user,
			'fields' => ['images'],
			'limit' => 1,
		]);

		return (array_get($response, '0.images.standard_resolution.url')) && $user ? true : false;
	}

	/**
	 * 
	 */
	public function getResponse($users)
	{
		$response = $this->api()->call('users.media.get', [
			'user_ids' => $users,
			'fields' => ['images','user'],
			'limit' => 1,
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
		return md5((string) array_get($response, '0.images.standard_resolution.url')) !== $lastState;
	}

	/**
	 *
	 */
	public function loadLastState($response)
	{
		return LastState::getState($this->getMorphClass(), array_get($response, '0.user.id'));
	}

	/**
	 * 
	 */
	public function saveState($response)
	{
		LastState::saveState($this->getMorphClass(), array_get($response, '0.user.id'), md5(array_get($response, '0.images.standard_resolution.url')));
	}

	/**
	 * 
	 */
	public function getEventUsers($response, $sms = null)
	{
		$userIds = ListenedEvent::query()
            ->where('event', $this->getMorphClass())
            ->where('provider', $this->social->getProvider())
            ->where('friend_remote_id', array_get($response, '0.user.id'))
            
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
	public function saveTimeLine($response)
	{
		$users = $this->getEventUsers($response);

		foreach($users as $user) {

			$friendSocial = FriendSocial::query()
				->whereRemoteId(array_get($response, '0.user.id'))
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
			    'attached_photo' => array_get($response, '0.images.standard_resolution.url'),
			    'provider' => $this->social->getProvider(),
			    'page_url' => 'https://www.instagram.com/' . data_get($response, '0.user.username'),
			    'description' => array_get($response, '0.user.full_name') . ' ' . _('опублікував нову світлину'),
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