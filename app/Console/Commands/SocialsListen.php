<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Social;

class SocialsListen extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'socials:listen';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $vkontakte = Social::get('vkontakte');

        $vkontakte->listen();

        $instagram = Social::get('instagram');

        $instagram->listen();
    }
}
