<?php

namespace Tests\Unit\App\Components\Audits;

use App\Components\Audits\AuditCollection;
use App\Components\Audits\PageSpeed\DesktopPageSpeed;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class AuditCollectionTest extends TestCase
{
    use DatabaseMigrations;

    public function testConstructMobile()
    {
        // $auditCollection = new AuditCollection([new DesktopPageSpeed()]);

    }

    // public function testServiceName()
    // {
    //     $audit = new PageSpeedDesktopAudits();
    //     $this->assertNotEmpty($audit->getServiceName());
    //     $this->assertIsString($audit->getServiceName());
    // }

    // public function testGetHeaders()
    // {
    //     $audit = new PageSpeedDesktopAudits();
    //     DesktopAudits::factory()->count(5)->create();
    //     $headers = $audit->getHeaders();
    //     $this->assertContainsOnlyInstancesOf(DesktopAudits::class , $headers);
    // }
}
