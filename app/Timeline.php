<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Friend;

class Timeline extends Model
{

	protected $fillable = [
	    'avatar_image',
	    'attached_photo',
	    'provider',
	    'friend_id',
	    'page_url',
	    'description',
    ];

    /**
     * 
     */
    public function friend()
    {
    	return $this->belongsTo(Friend::class);
    }

    public function toViber()
    {
    	if($this->attached_photo) {
    		return $this->sendViberImage();
    	}

    	return $this->sendViberText();
    }

    public function sendViberText()
    {
    	return app()->call('App\Http\Controllers\ViberController@send', [
    		'name' => data_get($this, 'friend.first_name') . ' ' . data_get($this, 'friend.last_name'),
    		'avatar' => $this->avatar_image,
    		'user' => User::find(data_get($this, 'friend.user.id')),
    		'message' => str_limit($this->description, 110),
    	]);
    }

    public function sendViberImage()
    {
    	return app()->call('App\Http\Controllers\ViberController@sendImage', [
    		'name' => data_get($this, 'friend.first_name') . ' ' . data_get($this, 'friend.last_name'),
    		'avatar' => $this->avatar_image,
    		'user' => User::find(data_get($this, 'friend.user.id')),
    		'message' => str_limit($this->description, 110),
    		'media' => $this->attached_photo,
    	]);
    }

    public function toSms()
    {
    	
    }

}
