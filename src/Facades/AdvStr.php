<?php

namespace mpstenson\AdvStr\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \mpstenson\AdvStr\AdvStr
 */
class AdvStr extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \mpstenson\AdvStr\AdvStr::class;
    }
}
