<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ListenedEvent extends Model
{
    protected $fillable = [
    	'provider',
        'event',
        'user_id',
        'friend_remote_id',
        'allow_sms',
    ];
}
