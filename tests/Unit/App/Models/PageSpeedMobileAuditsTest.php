<?php

namespace Tests\Unit\Models;

use App\Models\Audits;
use App\Models\PageSpeedMobileAudits;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class PageSpeedMobileAuditsTest extends TestCase
{
    use DatabaseMigrations;

    public function testServiceName()
    {
        $audit = new PageSpeedMobileAudits();
        $this->assertNotEmpty($audit->getServiceName());
        $this->assertIsString($audit->getServiceName());
        $this->assertEquals($audit->getServiceName(), 'mobile');
    }

    public function testGetHeadersReturnAllHeaders()
    {
        $headersCount = 10;
        Audits::factory()->count($headersCount)->create();

        $audit = new PageSpeedMobileAudits();
        $this->assertContainsOnlyInstancesOf(Audits::class , $audit->getHeaders());
        $this->assertCount($headersCount, $audit->getHeaders());
    }
}
