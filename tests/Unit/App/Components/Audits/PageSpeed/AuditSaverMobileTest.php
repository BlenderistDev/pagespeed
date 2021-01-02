<?php

namespace Tests\Unit;

use App\Components\Audits\PageSpeed\AuditSaver;
use App\Models\Audits;
use App\Models\PageSpeedMobileAudits;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AuditSaverMobileTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
        $auditsData = json_decode(file_get_contents(__DIR__ . '/PageSpeedResponseSample.json'), true);
        AuditSaver::makeGooglePageSpeedAudits($auditsData, Audits::factory(), PageSpeedMobileAudits::factory());
        
    }

    public function testSave(): void
    {
        $this->assertGreaterThan(1, Audits::all()->count());
    }

    public function testScoreSave(): void
    {
        $this->assertDatabaseHas('audits', ['name' => 'score']);
    }

    public function testSaveAllResults(): void
    {
        $this->assertEquals(PageSpeedMobileAudits::all()->count(), Audits::all()->count());
        $this->assertDatabaseHas('page_speed_mobile_audits', []);
    }
}
