<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\EditProfile;
use App\ViberSubscription;
use App\ViberAccount;
use SMS;

class ProfileController extends Controller
{
    /**
     * 
     */
    public function editProfile()
    {
    	$data = auth()->user()->toArray();
    	$old = array_merge(old(), $data);

    	if(!$viberId = auth()->user()->viber_id) {

    		$viberCode = $this->viberActivationCode();
    		ViberSubscription::whereUserId(auth()->id())->delete();
    		ViberSubscription::create([
    			'user_id' => auth()->id(),
    			'subscription_code' => $viberCode,
    		]);

    		$viberData = null;

    	} else {

    		$viberData = ViberAccount::whereUserId(auth()->id())->first(); 
    		$viberCode = null;

    	}
    	
	   	return view('profile.edit', [
    		'old' => $old,
    		'viberCode' => $viberCode,
    		'viberData' => $viberData,
    	]);
    }


    /**
     * 
     */
    public function viberActivationCode()
    {
    	return rand(100000, 999999);
    }

    /**
     * 
     */
    public function postEditProfile(EditProfile $request)
    {
        $telephone = SMS::formatPhone($request->get('telephone'));
    	auth()->user()->update([
            'name' => $request->get('name'),
            'telephone' => $telephone,
        ]);

        return redirect(action('TimelineController@getTimeline'));
    }
}
