<?php

namespace Tests\Unit;

use App\Models\RegularAudits;
use Cron\CronExpression;
use Illuminate\Support\Carbon;
use PHPUnit\Framework\TestCase;

class RegularAuditsTest extends TestCase
{
    public function testGetCronStringAttributeStars()
    {
        $regularAudit = RegularAudits::factory()->stars()->make();
        $this->assertTrue(CronExpression::isValidExpression($regularAudit->getCronStringAttribute()));
    }

    public function testGetCronStringAttributeRanges()
    {
        $regularAudit = RegularAudits::factory()->ranges()->make();
        $this->assertTrue(CronExpression::isValidExpression($regularAudit->getCronStringAttribute()));
    }

    public function testGetCronStringAttributeEnums()
    {
        $regularAudit = RegularAudits::factory()->enums()->make();
        $this->assertTrue(CronExpression::isValidExpression($regularAudit->getCronStringAttribute()));
    }

    public function testGetCronStringAttributePeriods()
    {
        $regularAudit = RegularAudits::factory()->periods()->make();
        $this->assertTrue(CronExpression::isValidExpression($regularAudit->getCronStringAttribute()));
    }

    public function testIsDueStars()
    {
        $regularAudit = RegularAudits::factory()->stars()->make();
        $this->assertTrue($regularAudit->isDue());
    }

    public function testIsDueCurrentMinute()
    {
        $regularAudit = RegularAudits::factory()->stars()->make();
        $date = Carbon::now();
        $regularAudit->minute = $date->minute;
        $this->assertTrue($regularAudit->isDue());
    }
}
