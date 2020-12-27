<?php

namespace Tests\Unit\Models;

use App\Models\Audits;
use App\Models\PageSpeedMobileAudits;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class PageSpeedMobileAuditsTest extends TestCase
{
    use DatabaseMigrations;

    private $model;

    protected function setUp(): void
    {
        $this->model = new PageSpeedMobileAudits();
        parent::setUp();
    }

    public function testServiceName(): void
    {
        $this->assertNotEmpty($this->model->getServiceName());
        $this->assertIsString($this->model->getServiceName());
        $this->assertEquals($this->model->getServiceName(), 'mobile');
    }

    public function testGetHeaders(): void
    {
        $headersCount = 10;
        Audits::factory()->count($headersCount)->create();

        $this->assertContainsOnlyInstancesOf(Audits::class , $this->model->getHeaders());
        $this->assertCount($headersCount, $this->model->getHeaders());
    }
}
