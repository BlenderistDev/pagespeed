<?php

namespace Tests\Unit\Models;

use App\Models\DesktopAudits;
use App\Models\PageSpeedDesktopAudits;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class PageSpeedDesktopAuditsTest extends TestCase
{
    use DatabaseMigrations;

    private $model;

    protected function setUp(): void
    {
        $this->model = new PageSpeedDesktopAudits();
        parent::setUp();
    }

    public function testServiceName(): void
    {
        $this->assertNotEmpty($this->model->getServiceName());
        $this->assertIsString($this->model->getServiceName());
        $this->assertEquals($this->model->getServiceName(), 'desktop');
    }

    public function testGetHeaders():void
    {
        $headersCount = 10;
        DesktopAudits::factory()->count($headersCount)->create();

        $this->assertContainsOnlyInstancesOf(DesktopAudits::class , $this->model->getHeaders());
        $this->assertCount($headersCount, $this->model->getHeaders());
    }
}
