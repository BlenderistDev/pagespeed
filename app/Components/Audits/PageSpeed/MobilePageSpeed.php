<?php

namespace App\Components\Audits\PageSpeed;

use App\Models\Audits;
use App\Models\PageSpeedMobileAudits;
use Database\Factories\AuditResultFactoryPrototype;
use Database\Factories\AuditsFactoryPrototype;

class MobilePageSpeed extends PageSpeed
{
    const STRATEGY = "MOBILE";

    protected function getStrategy(): string
    {
        return self::STRATEGY;
    }

    protected function getAuditsFactory(): AuditsFactoryPrototype
    {
        return Audits::factory();
    }

    public function getAuditResultFactory(): AuditResultFactoryPrototype
    {
        return PageSpeedMobileAudits::factory();
    }

    public function getLinkName(): string
    {
        return 'measure';
    }
}
