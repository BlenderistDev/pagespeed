<?php

namespace Tests\Unit;

use App\Components\Audits\PageSpeed\MobilePageSpeed;
use App\Models\PageSpeedMobileAudits;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class MobilePageSpeedTest extends TestCase
{
    use DatabaseMigrations;

    public function testGetAuditResults()
    {
        PageSpeedMobileAudits::factory()->withMeausureId(1)->create();
        PageSpeedMobileAudits::factory()->withMeausureId(2)->create();
        PageSpeedMobileAudits::factory()->withMeausureId(3)->create();
        PageSpeedMobileAudits::factory()->withMeausureId(4)->create();
        PageSpeedMobileAudits::factory()->withMeausureId(5)->create();
        $desktopAudits = new MobilePageSpeed();
        $auditResults = $desktopAudits->getAuditResults([1, 3]);
        $this->assertCount(2, $auditResults);
    }

    public function testAllMeasurementResults()
    {
        $measureId = 3;
        $resultCount = 5;
        PageSpeedMobileAudits::factory()->withMeausureId($measureId)->withUniqueAuditId()->count($resultCount)->create();
        $desktopAudits = new MobilePageSpeed();
        $auditResults = $desktopAudits->getAuditResults([$measureId]);
        $this->assertCount($resultCount, $auditResults[$measureId]);
    }
}
