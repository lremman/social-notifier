<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\ViberAccount;
use App\Friend;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'is_confirmed', 'telephone'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * 
     */
    public function getViberIdAttribute()
    {
        return $this->viber ? $this->viber->viber_user_id : null;
    }

    /**
     * 
     */
    public function viber()
    {
        return $this->hasOne(ViberAccount::class);
    }

    /**
     * 
     */
    public function friends()
    {
        return $this->hasMany(Friend::class);
    }
}
