<?php

namespace MRGear\PersianNormalizer\Facade;

use Illuminate\Support\Facades\Facade;

class Normalizer extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'mrgear-persian-normalizer'; // Name of the binding in the service provider
    }
}
