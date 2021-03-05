<?php

namespace App\Components\Audits\PageSpeed;

use App\Models\DesktopAudits;
use App\Models\PageSpeedDesktopAudits;
use Database\Factories\AuditResultFactoryPrototype;
use Database\Factories\AuditsFactoryPrototype;

class DesktopPageSpeed extends PageSpeed
{
    private const STRATEGY = 'DESKTOP';

    protected function getStrategy(): string
    {
        return self::STRATEGY;
    }

    protected function getAuditsFactory(): AuditsFactoryPrototype
    {
        return DesktopAudits::factory();
    }

    public function getAuditResultFactory(): AuditResultFactoryPrototype
    {
        return PageSpeedDesktopAudits::factory();
    }

    public function getLinkName(): string
    {
        return 'measureDesktop';
    }
}
