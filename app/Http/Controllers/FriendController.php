<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AttachSocial;
use App\Http\Requests\AddFriend;
use Social;
use App\FriendSocial;
use App\ListenedEvent;
use App\Friend;

class FriendController extends Controller
{
    /**
     * 
     */
    public function getSettings($friendId)
    {
        $friend = Friend::whereUserId(auth()->id())->findOrFail($friendId);
        
        $accounts = FriendSocial::whereFriendId($friendId)->orderBy('provider', 'asc')->get();

        $events = [];

        $accounts->map(function($account) use (&$events) {
            $allowed = ListenedEvent::query()
                ->where('user_id', auth()->id())
                ->where('provider', $account->provider)
                ->where('friend_remote_id', $account->remote_id)
                ->pluck('event')
            ;

            $events[$account->remote_id] = collect(Social::get($account->provider)
                ->getSettingsData($account->remote_id))
                ->filter(function($item, $key) use ($allowed) {
                    return $allowed->contains($key);
                })
            ;
        });

    	return view('friend.settings.main', [
            'friend' => $friend,
            'friendId' => $friendId,
            'accounts' => $accounts,
            'events' => $events,
        ]);
    }

    /**
     * 
     */
    public function postAttachAccount(AttachSocial $request, $friendId) 
    {
    	$provider = $request->get('provider');
        $remoteId = Social::get($provider)->resolveUrl($request->get('url'));

        $userData = Social::get($provider)->getUserInfo($remoteId);

        FriendSocial::whereProvider($provider)->whereRemoteId($remoteId)->delete();

        FriendSocial::firstOrCreate([
            'provider' => $provider,
            'remote_id' => $remoteId,
            'friend_id' => $friendId,
            'user_id' => auth()->id(),
            'description' => $request->get('description'),
            'remote_first_name' => $userData['first_name'],
            'remote_last_name' => $userData['last_name'],
            'remote_image' => $userData['image'],
        ]);

        return response()->json([
            'message' => 'success'
        ], 200);
    }

    /**
     * 
     */
    public function getModalEvents($friendId, $provider, $remoteId) 
    {
        $options = Social::get($provider)->getSettingsData($remoteId);

        $allowed = ListenedEvent::query()
            ->where('user_id', auth()->id())
            ->where('provider', $provider)
            ->where('friend_remote_id', $remoteId)
            ->get()
        ;

        $allowSms = object_get($allowed->first(), 'allow_sms', false);
        $allowedEvents = $allowed->pluck('event');

        return view('friend.settings.events-setup-modal', [
            'friendId' => $friendId,
            'provider' => $provider,
            'options' => $options,
            'remoteId' => $remoteId,
            'allowedEvents' => $allowedEvents,
            'allowSms' => $allowSms,
        ]);
    }

    /**
     * 
     */
    public function saveModalEvents($friendId, $provider, $remoteId) 
    {
        ListenedEvent::query()
            ->where('user_id', auth()->id())
            ->where('provider', $provider)
            ->where('friend_remote_id', $remoteId)
            ->delete()
        ;

        foreach(request('events', []) as $event) {
            ListenedEvent::create([
                'user_id' => auth()->id(),
                'provider' => $provider,
                'friend_remote_id' => $remoteId,
                'event' => $event,
                'allow_sms' => request('allow_sms') ? 1 : 0,
            ]);
        }

        return response()->json([
            'message' => 'success',
            'redirect_url' => action('FriendController@getSettings', $friendId)
        ], 200);                 
    }

    /**
     * 
     */
    public function getList()
    {
        $friends = Friend::whereUserId(auth()->id())->get();
        return view('friend.list', [
            'friends' => $friends,
        ]);
    }

    /**
     * 
     */
    public function postAdd(AddFriend $request)
    {
        Friend::create([
            'first_name' => $request->get('first_name'), 
            'last_name' => $request->get('last_name'),
            'photo_storage_id' => 1,
            'user_id' => auth()->id(),
        ]);

        return response()->json([
            'message' => 'success',
        ], 200); 
    }
}
