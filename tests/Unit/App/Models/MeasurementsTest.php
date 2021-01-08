<?php

namespace Tests\Unit\App\Models;

use App\Models\Measurements;
use App\Models\PageSpeedDesktopAudits;
use App\Models\PageSpeedMobileAudits;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class MeasurementsTest extends TestCase
{
    use DatabaseMigrations;

    public function testMeasure(): void
    {
        Event::fake();
        $auditCount = 4;
        $measurement = Measurements::factory()
            ->has(PageSpeedMobileAudits::factory()->count($auditCount), 'measure')
            ->create();

        $this->assertCount($auditCount, $measurement->measure);
    }

    public function testMeasureDesktop(): void
    {
        Event::fake();
        $auditCount = 6;
        $measurement = Measurements::factory()
            ->has(PageSpeedDesktopAudits::factory()->count($auditCount), 'measure')
            ->create();

        $this->assertCount($auditCount, $measurement->measureDesktop);
    }
}
