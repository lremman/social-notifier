<?php

namespace App\Ext\SocialDrivers\Vendor\Interfaces;

interface PluginInterface
{
    public function api($type);

    public function boot();
}