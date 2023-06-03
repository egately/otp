<?php

namespace Egate\EgateOtp\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Egate\EgateOtp\EgateOtp
 */
class EgateOtp extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Egate\EgateOtp\EgateOtp::class;
    }
}
