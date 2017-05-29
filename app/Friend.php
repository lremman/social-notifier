<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\FriendSocial;
use App\User;

class Friend extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'photo_storage_id', 'user_id', 'description'
    ];

    /**
     * 
     */
    public function socials()
    {
    	return $this->hasMany(FriendSocial::class);
    }

    /**
     * 
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
