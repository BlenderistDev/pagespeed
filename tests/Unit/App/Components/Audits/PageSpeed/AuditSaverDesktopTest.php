<?php

namespace Tests\Unit\App\Components\Audits\PageSpeed;

use App\Components\Audits\PageSpeed\AuditSaver;
use App\Models\DesktopAudits;
use App\Models\PageSpeedDesktopAudits;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AuditSaverDesktopTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
        $auditsData = json_decode(file_get_contents(__DIR__ . '/PageSpeedResponseSample.json'), true);
        AuditSaver::makeGooglePageSpeedAudits($auditsData, DesktopAudits::factory(), PageSpeedDesktopAudits::factory());
    }

    public function testSave(): void
    {
        $this->assertGreaterThan(1, DesktopAudits::all()->count());
    }

    public function testScoreSave(): void
    {
        $this->assertDatabaseHas('desktop_audits', ['name' => 'score']);
    }

    public function testSaveAllResults(): void
    {
        $this->assertEquals(PageSpeedDesktopAudits::all()->count(), DesktopAudits::all()->count());
        $this->assertDatabaseHas('page_speed_desktop_audits', []);
    }
}
