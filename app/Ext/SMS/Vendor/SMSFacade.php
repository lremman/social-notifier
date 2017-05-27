<?php

namespace App\Ext\SMS\Vendor;

use Illuminate\Support\Facades\Facade;

/**
 * @see \DummyTarget
 */
class SMSFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'ext.sms.sender';
    }
}
