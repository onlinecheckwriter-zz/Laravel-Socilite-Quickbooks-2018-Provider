<?php

namespace Onlinecheckwriter\Socialite\Quickbooks

use Laravel\Socialite\SocialiteServiceProvider;
use Laravel\Socialite\Contracts\Factory;
use Laravel\Socialite\Facades\Socialite;


class QuickbooksServiceProvider extends SocialiteServiceProvider
{
      protected $defer = false;
    /**
     * Execute the provider.
     */
    
    public function boot()
    {
        Socialite::extend('quickbooks2018', function ($app) {
            $config = $app['config']['services.quickbooks2018'];

            return Socialite::buildProvider(QuickbookProvider::class, $config);
        });
    }
    
    
   
}
