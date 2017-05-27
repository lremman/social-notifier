<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Viber\Bot as ViberBot;
use Viber\Api\Sender as ViberSender;
use Viber\Client as ViberClient;
use App\ViberSubscription;
use App\ViberAccount;
use App\User;

class ViberController extends Controller
{

	public $name = 'SocialNotifier';

	public $avatar = 'https://developers.viber.com/images/devlogo.png';
	/**
	 * [vebhook description]
	 * @return [type] [description]
	 */
    public function webhook(){

    	$token = config('services.viber.key');

    	$botSender = new ViberSender([
		    'name' => $this->name,
		    'avatar' => $this->avatar,
		]);

		try {
		    $bot = new ViberBot(['token' => $token]);
		    $bot
		    ->onText('|subscribe:.*|si', function ($event) use ($bot, $botSender) {

		    	$subscribeResultMessage = $this->subscribe($event);

		        $bot->getClient()->sendMessage(
		            (new \Viber\Api\Message\Text())
		            ->setSender($botSender)
		            ->setReceiver($event->getSender()->getId())
		            ->setText($subscribeResultMessage)
		        );
		    })
		    ->run();
		} catch (\Exception $e) {

		}
    }

    /**
     *
     */
    public function subscribe($event)
    {
    	try {

	    	$message = $event->getMessage()->getText();

	    	$message = array_get(explode('subscribe:', $message), 1);
	    	$message = array_get(explode(' ', $message), 0);


	    	$subscription = ViberSubscription::query()
	    		->where('subscription_code', $message)
	    		->first()
	    	;

	    	if ($user = User::find($subscription->user_id)) {

	    		ViberAccount::create([
	    			'viber_user_id' => $event->getSender()->getId(),
	    			'user_id' => $user->id,
	    			'name' => $event->getSender()->getName(),
	    			'avatar' => $event->getSender()->getAvatar(),
	    		]);

	    		ViberSubscription::whereUserId($user->id)->delete();

	    		return _('Аккаунт Viber успішно приєднано до профілю ' . $user->name);
	    	}
    	} catch (\Exception $e) {
    		return $e->getMessage();
    	}

    	return _('Аккаунт не приєднано: сталася помилка, або код вказано не вірно');
    }

    /**
     * 
     */
    public function send($name, $avatar, $user, $message)
    {

    	if(!$user->viber_id) {
    		return false;
    	}

    	$token = config('services.viber.key');

    	$botSender = new ViberSender([
		    'name' => $name,
		    'avatar' => $avatar,
		]);

		(new ViberClient(['token' => $token]))->sendMessage(
            (new \Viber\Api\Message\Text())
            ->setSender($botSender)
            ->setReceiver($user->viber_id)
            ->setText($message)
        );
    }

    /**
     * 
     */
    public function sendImage($name, $avatar, $user, $message, $media)
    {

    	if(!$user->viber_id) {
    		return false;
    	}

    	$token = config('services.viber.key');

    	$botSender = new ViberSender([
		    'name' => $name,
		    'avatar' => $avatar,
		]);

		(new ViberClient(['token' => $token]))->sendMessage(
            (new \Viber\Api\Message\Picture())
            ->setSender($botSender)
            ->setReceiver($user->viber_id)
            ->setText($message)
            ->setMedia($media)
        );
    }
}

