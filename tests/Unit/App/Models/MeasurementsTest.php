<?php

namespace Tests\Unit\Models;

use App\Models\Measurements;
use App\Models\PageSpeedDesktopAudits;
use App\Models\PageSpeedMobileAudits;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class MeasurementsTest extends TestCase
{
    use DatabaseMigrations;

    private $model;

    public function testMeasure()
    {
        Event::fake();
        $auditCount = 4;
        $measurement = Measurements::factory()
            ->has(PageSpeedMobileAudits::factory()->count($auditCount), 'measure')
            ->create();

        $this->assertCount($auditCount, $measurement->measure);
    }

    public function testMeasureDesktop()
    {
        Event::fake();
        $auditCount = 6;
        $measurement = Measurements::factory()
            ->has(PageSpeedDesktopAudits::factory()->count($auditCount), 'measure')
            ->create();

        $this->assertCount($auditCount, $measurement->measureDesktop);
    }
}