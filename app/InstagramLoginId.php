<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InstagramLoginId extends Model
{
	protected $table = 'instagram_logins_ids';

    public $timestamps = false;
	
    protected $fillable = [
    	'login',
    	'id',
    ];
}
