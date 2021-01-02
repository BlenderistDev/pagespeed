<?php

namespace Tests\Unit;

use App\Components\Audits\PageSpeed\MobilePageSpeed;
use App\Components\Audits\PageSpeed\PageSpeedRequestFacade;
use App\Models\PageSpeedMobileAudits;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use React\EventLoop;
use React\Promise\Deferred;
use function Clue\React\Block\await;

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

    public function testMakeAudit()
    {
        $deferred = new Deferred();
        $promise = $deferred->promise();
        $deferred->resolve(json_decode(file_get_contents(__DIR__ . '/PageSpeedResponseSample.json'), true));

        PageSpeedRequestFacade::shouldReceive('makeAuditRequest')->once()->andReturn($promise);
        $loop = EventLoop\Factory::create();
        $audit = new MobilePageSpeed();
        await($audit->makeAudit('https://mebelverona.ru', 1, $loop), $loop);
        $this->assertDatabaseHas('audits', []);
        $this->assertDatabaseHas('page_speed_mobile_audits', []);
    }

    public function testLinkName(): void
    {
        $mobilePageSpeed = new MobilePageSpeed();
        $this->assertEquals('measure', $mobilePageSpeed->getLinkName());
    }

    public function testRequestException(): void
    {
        $deferred = new Deferred();
        $promise = $deferred->promise();
        $deferred->reject('error');
        PageSpeedRequestFacade::shouldReceive('makeAuditRequest')->once()->andReturn($promise);
        $this->expectException(\Exception::class);
        $loop = EventLoop\Factory::create();
        $audit = new MobilePageSpeed();
        await($audit->makeAudit('https://mebelverona.ru', 1, $loop), $loop);
    }
}
