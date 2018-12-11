<?php

namespace Onlinechecwriter\Socialite\QuickBooks;

use Laravel\Socialite\SocialiteServiceProvider;
use Laravel\Socialite\Contracts\Factory;
use Laravel\Socialite\Facades\Socialite;


class QuickBooksServiceProvider extends SocialiteServiceProvider
{
      protected $defer = false;
    /**
     * Execute the provider.
     */
    
    public function boot()
    {
        Socialite::extend('quickbooks2018', function ($app) {
            $config = $app['config']['services.quickbooks'];

            return Socialite::buildProvider(QuickBooksSocialiteProvider::class, $config);
        });
    }
    
    
   
}
