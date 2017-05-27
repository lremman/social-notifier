<?php

namespace App\Ext\SocialDrivers\Vendor\Providers;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\ServiceProvider;
use Social;

class SocialDriversServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
         // $vkontakte = Social::get('vkontakte');

         // $vkontakte->listen();

         //$vkontakte->resolveUrl('https://vk.com/masha.mashkaaa');

        // dd($vkontakte->getSettingsData());
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        app()->singleton(
            'social',
            \App\Ext\SocialDrivers\Social::class
        );
    }
}
