<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ViberAccount extends Model
{
	public $timestamps = false;

    protected $fillable = [
    	'user_id',
    	'viber_user_id',
    	'name',
    	'avatar',
    ];
}
