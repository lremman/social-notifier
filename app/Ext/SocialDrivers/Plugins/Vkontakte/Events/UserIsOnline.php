<?php

namespace App\Ext\SocialDrivers\Plugins\Vkontakte\Events;

use App\Ext\SocialDrivers\Vendor\AbstractClasses\AbstractEvent;
use App\LastState;
use App\ListenedEvent;
use App\User;
use App\Timeline;
use App\FriendSocial;

class UserIsOnline extends AbstractEvent
{

	/**
	 * 
	 */
	public function getSettingTitle()
	{
		return 'Користувач увійшов в мережу';
	}

	/**
	 * 
	 */
	public function getSettingDescription()
	{
		return 'Відслідкування події: користувач увійшов в мережу';
	}

	/**
	 * 
	 */
	public function getSettingIcon()
	{
		return 'fa fa-sign-in';
	}

	/**
	 * 
	 */
	public function checkAbilityForUser($user = null)
	{
		$response = $this->api()->call('users.get', [
			'user_ids' => [$user],
			'fields' => ['online', 'last_seen'],
		]);

		return (array_get($response, 'online') !== false) && $user ? true : false;
	}

	/**
	 * 
	 */
	public function getResponse($users)
	{
		$response = $this->api()->call('users.get', [
			'user_ids' => $users,
			'fields' => ['online', 'last_seen'],
		]);

		$response = collect($response);

		return $response;
	}

	/**
	 *
	 */
	public function loadLastState($response)
	{
		return LastState::getState($this->getMorphClass(), array_get($response, 'id'));
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

		return md5((string) array_get($response, 'online')) !== $lastState;
	}

	/**
	 * 
	 */
	public function saveState($response)
	{
		LastState::saveState($this->getMorphClass(), array_get($response, 'id'), md5(array_get($response, 'online')));
	}

	/**
	 * 
	 */
	public function getEventUsers($response, $sms = null)
	{
		$userIds = ListenedEvent::query()
            ->where('event', $this->getMorphClass())
            ->where('provider', $this->social->getProvider())
            ->where('friend_remote_id', array_get($response, 'id'))
            
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
		if(array_get($response, 'online') != 1) {
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
			    'description' => array_get($response, 'first_name') . ' ' . array_get($response, 'last_name') . ' ' . _('увійшов до мережі'),
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