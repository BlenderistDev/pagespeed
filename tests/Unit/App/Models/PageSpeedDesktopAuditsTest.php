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
        $this->assertEquals($audit->getServiceName(), 'desktop');
    }

    public function testGetHeadersReturnAllHeaders()
    {
        $headersCount = 10;
        DesktopAudits::factory()->count($headersCount)->create();

        $audit = new PageSpeedDesktopAudits();
        $this->assertContainsOnlyInstancesOf(DesktopAudits::class , $audit->getHeaders());
        $this->assertCount($headersCount, $audit->getHeaders());
    }
}
