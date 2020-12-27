<?php

namespace Tests\Unit;

use App\Components\Audits\PageSpeed\DesktopPageSpeed;
use App\Models\DesktopAudits;
use App\Models\PageSpeedDesktopAudits;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class DesktopPageSpeedTest extends TestCase
{
    use DatabaseMigrations;

    public function testGetAuditResults()
    {
        PageSpeedDesktopAudits::factory()->withMeausureId(1)->create();
        PageSpeedDesktopAudits::factory()->withMeausureId(2)->create();
        PageSpeedDesktopAudits::factory()->withMeausureId(3)->create();
        PageSpeedDesktopAudits::factory()->withMeausureId(4)->create();
        PageSpeedDesktopAudits::factory()->withMeausureId(5)->create();
        $desktopAudits = new DesktopPageSpeed();
        $auditResults = $desktopAudits->getAuditResults([1, 3]);
        $this->assertCount(2, $auditResults);
    }

    public function testAllMeasurementResults()
    {
        $measureId = 3;
        $resultCount = 5;
        PageSpeedDesktopAudits::factory()->withMeausureId($measureId)->withUniqueAuditId()->count($resultCount)->create();
        $desktopAudits = new DesktopPageSpeed();
        $auditResults = $desktopAudits->getAuditResults([$measureId]);
        $this->assertCount($resultCount, $auditResults[$measureId]);
    }
}
