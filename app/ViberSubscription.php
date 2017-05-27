<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ViberSubscription extends Model
{
	public $timestamps = false;
	
    protected $fillable = [
    	'user_id',
    	'subscription_code',
    	'viber_id',
    ];
}
