<?php

namespace App\Ext\SocialDrivers\Vendor\AbstractClasses;

use App\Ext\SocialDrivers\Vendor\Interfaces\SocialInterface;

abstract class AbstractSocial implements SocialInterface
{
    /**
     *
     */
    protected $plugins = [];

    /**
     * 
     */
    public function __construct()
    {
        $this->registerPlugins();
    }

    protected function registerPlugins()
    {
        foreach ($this->register() as $provider => $class) {
            $this->plugins[$provider] = new $class;
        }
    }

    /**
     * 
     */
    protected function register()
    {
        return [];
    }

    /**
     * 
     */
    public function get($social)
    {
        if (!isset($this->plugins[$social])) {
            throw new \Exception('Social plugin with provider name [' . $social . '] not found');
        }

        return $this->plugins[$social];
    }
}