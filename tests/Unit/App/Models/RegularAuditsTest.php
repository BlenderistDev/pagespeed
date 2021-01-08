<?php

namespace Tests\Unit\App\Models;

use App\Models\RegularAudits;
use Cron\CronExpression;
use Illuminate\Support\Carbon;
use PHPUnit\Framework\TestCase;

class RegularAuditsTest extends TestCase
{
    public function testGetCronStringAttributeStars(): void
    {
        $regularAudit = RegularAudits::factory()->stars()->make();
        $this->assertTrue(CronExpression::isValidExpression($regularAudit->getCronStringAttribute()));
    }

    public function testGetCronStringAttributeRanges(): void
    {
        $regularAudit = RegularAudits::factory()->ranges()->make();
        $this->assertTrue(CronExpression::isValidExpression($regularAudit->getCronStringAttribute()));
    }

    public function testGetCronStringAttributeEnums(): void
    {
        $regularAudit = RegularAudits::factory()->enums()->make();
        $this->assertTrue(CronExpression::isValidExpression($regularAudit->getCronStringAttribute()));
    }

    public function testGetCronStringAttributePeriods(): void
    {
        $regularAudit = RegularAudits::factory()->periods()->make();
        $this->assertTrue(CronExpression::isValidExpression($regularAudit->getCronStringAttribute()));
    }

    public function testIsDueStars(): void
    {
        $regularAudit = RegularAudits::factory()->stars()->make();
        $this->assertTrue($regularAudit->isDue());
    }

    public function testIsDueCurrentMinute(): void
    {
        $regularAudit = RegularAudits::factory()->stars()->make();
        $date = Carbon::now();
        $regularAudit->minute = $date->minute;
        $this->assertTrue($regularAudit->isDue());
    }
}
