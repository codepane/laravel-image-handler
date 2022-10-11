<?php

namespace CodePane\LaravelImageHandler\Facades;

use Illuminate\Support\Facades\Facade;

class ImageHandler extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'imagehandler';
    }
}
