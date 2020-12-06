<?php

namespace Tests\Unit\Models;

use App\Models\DesktopAudits;
use App\Models\PageSpeedDesktopAudits;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class PageSpeedDesktopAuditsTest extends TestCase
{
    use DatabaseMigrations;

    public function testServiceName()
    {
        $audit = new PageSpeedDesktopAudits();
        $this->assertNotEmpty($audit->getServiceName());
        $this->assertIsString($audit->getServiceName());
    }

    public function testGetHeaders()
    {
        $audit = new PageSpeedDesktopAudits();
        DesktopAudits::factory()->count(5)->create();
        $headers = $audit->getHeaders();
        $this->assertContainsOnlyInstancesOf(DesktopAudits::class , $headers);
    }
}
