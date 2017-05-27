<?php

namespace App\Ext\SocialDrivers;

use App\Ext\SocialDrivers\Vendor\AbstractClasses\AbstractSocial;
use App\Ext\SocialDrivers\Plugins;

class Social extends AbstractSocial
{
    /**
     * 
     */
    protected function register()
    {
        return [
            'vkontakte' => Plugins\Vkontakte\Vkontakte::class,
            'instagram' => Plugins\Instagram\Instagram::class,
        ];
    }
}
