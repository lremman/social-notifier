<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Friend;

class FriendSocial extends Model
{
    protected $table = 'friends_socials';

    protected $fillable = [
    	'provider',
        'remote_id',
        'friend_id',
        'user_id',
        'remote_first_name',
        'remote_last_name',
        'description',
        'remote_image',
    ];

    /**
     * 
     */
    public function friend()
    {
        return $this->belongsTo(Friend::class);
    }
}
