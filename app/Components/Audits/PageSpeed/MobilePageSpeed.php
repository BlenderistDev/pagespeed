<?php

namespace App\Components\Audits\PageSpeed;

use App\Models\Audits;
use App\Models\PageSpeedMobileAudits;
use Database\Factories\AuditResultFactoryPrototype;
use Database\Factories\AuditsFactoryPrototype;

class MobilePageSpeed extends PageSpeed
{
    protected function getStrategy(): string
    {
        return "MOBILE";
    }

    protected function getAuditsFactory(): AuditsFactoryPrototype
    {
        return Audits::factory();
    }

    public function getAuditResultFactory(): AuditResultFactoryPrototype
    {
        return PageSpeedMobileAudits::factory();
    }

    protected function getServiceName(): string
    {
        return 'mobile';
    }

    public function getLinkName(): string
    {
        return 'measure';
    }
}
