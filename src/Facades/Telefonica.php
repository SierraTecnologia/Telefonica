<?php

namespace Telefonica\Facades;

use Illuminate\Support\Facades\Facade;

class Telefonica extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'telefonica';
    }
}
