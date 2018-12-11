<?php

namespace SocialiteProviders\QuickBookSocialite;
use SocialiteProviders\Manager\SocialiteWasCalled;

class QuickBooks2018ExtendSocialite
{
    /**
     * Execute the provider.
     */
    public function handle(SocialiteWasCalled $socialiteWasCalled)
    {
        $socialiteWasCalled->extendSocialite('quickbooks2018', __NAMESPACE__.'\Provider');
    }
}
