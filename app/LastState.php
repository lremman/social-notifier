<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LastState extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'gateway', 'data', 'remote_id'
    ];

    public $timestamps = false;

    public static function getState($gateway, $remoteId)
    {
    	if(!$model = static::whereGateway($gateway)->whereRemoteId($remoteId)->first()) {
    		return null;
    	}
    	return $model->data;
    }

    public static function saveState($gateway, $remoteId ,$data)
    {
    	static::where('gateway', $gateway)->where('remote_id', $remoteId)->delete();
    	
    	return static::create([
    		'gateway' => $gateway,
            'remote_id' => $remoteId,
    		'data' => $data,
    	]);
    }
}
