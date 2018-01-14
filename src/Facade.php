<?php

namespace Tijdmachine\Active;

class Facade extends \Illuminate\Support\Facades\Facade
{
    protected static function getFacadeAccessor()
    {
        return Active::class;
    }
}
