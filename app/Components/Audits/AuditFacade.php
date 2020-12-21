<?php

namespace App\Components\Audits;

use \Illuminate\Support\Facades\Facade;

class AuditFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return Audits::class;
    }
}
