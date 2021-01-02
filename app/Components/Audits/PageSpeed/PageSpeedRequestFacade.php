<?php

namespace App\Components\Audits\PageSpeed;

use App\Components\Audits\PageSpeed\PageSpeedRequest;
use \Illuminate\Support\Facades\Facade;

class PageSpeedRequestFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return PageSpeedRequest::class;
    }
}
