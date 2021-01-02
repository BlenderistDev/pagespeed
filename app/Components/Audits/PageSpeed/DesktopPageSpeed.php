<?php

namespace App\Components\Audits\PageSpeed;

use App\Models\DesktopAudits;
use App\Models\PageSpeedDesktopAudits;
use Database\Factories\AuditResultFactoryPrototype;
use Database\Factories\AuditsFactoryPrototype;

class DesktopPageSpeed extends PageSpeed
{
    protected function getStrategy(): string
    {
        return "DESKTOP";
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
