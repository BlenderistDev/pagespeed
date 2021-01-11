<?php

namespace Tests\Unit\App\Components\Audits\PageSpeed;

use App\Components\Audits\PageSpeed\DesktopPageSpeed;
use App\Components\Audits\PageSpeed\PageSpeedRequestFacade;
use App\Models\PageSpeedDesktopAudits;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use React\Promise\Deferred;
use React\EventLoop;
use function Clue\React\Block\await;

class DesktopPageSpeedTest extends TestCase
{
    use DatabaseMigrations;

    public function testGetAuditResults(): void
    {
        PageSpeedDesktopAudits::factory()->withMeausureId(1)->create();
        PageSpeedDesktopAudits::factory()->withMeausureId(2)->create();
        PageSpeedDesktopAudits::factory()->withMeausureId(3)->create();
        PageSpeedDesktopAudits::factory()->withMeausureId(4)->create();
        PageSpeedDesktopAudits::factory()->withMeausureId(5)->create();
        $desktopAudits = new DesktopPageSpeed();
        $auditResults = $desktopAudits->getAuditResults(['measurements_id' => [1, 3]]);
        $this->assertCount(2, $auditResults);
    }

    public function testAllMeasurementResults()
    {
        $measureId = 3;
        $resultCount = 5;
        PageSpeedDesktopAudits::factory()->withMeausureId($measureId)->withUniqueAuditId()->count($resultCount)->create();
        $desktopAudits = new DesktopPageSpeed();
        $auditResults = $desktopAudits->getAuditResults(['measurements_id' => [1, 3]]);
        $this->assertCount($resultCount, $auditResults[$measureId]);
    }

    public function testMakeDesktopAudit(): void
    {
        $deferred = new Deferred();
        $promise = $deferred->promise();
        $deferred->resolve(json_decode(file_get_contents(__DIR__ . '/PageSpeedResponseSample.json'), true));
        PageSpeedRequestFacade::shouldReceive('makeAuditRequest')->once()->andReturn($promise);

        $loop = EventLoop\Factory::create();
        $audit = new DesktopPageSpeed();
        await($audit->makeAudit('https://mebelverona.ru', 1, $loop), $loop);

        $this->assertDatabaseHas('desktop_audits', []);
        $this->assertDatabaseHas('page_speed_desktop_audits', []);
    }

    public function testLinkName(): void
    {
        $desktopPageSpeed = new DesktopPageSpeed();
        $this->assertEquals('measureDesktop', $desktopPageSpeed->getLinkName());
    }

    public function testRequestException(): void
    {
        $deferred = new Deferred();
        $promise = $deferred->promise();
        $deferred->reject('error');
        PageSpeedRequestFacade::shouldReceive('makeAuditRequest')->once()->andReturn($promise);
        $this->expectException(\Exception::class);
        $loop = EventLoop\Factory::create();
        $audit = new DesktopPageSpeed();
        await($audit->makeAudit('https://mebelverona.ru', 1, $loop), $loop);
    }
}
