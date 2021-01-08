<?php

namespace Tests\Unit\App\Models;

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

    public function testGetHeaders(): void
    {
        $headersCount = 10;
        DesktopAudits::factory()->count($headersCount)->create();

        $this->assertContainsOnlyInstancesOf(DesktopAudits::class , $this->model->getHeaders());
        $this->assertCount($headersCount, $this->model->getHeaders());
    }

    public function testAudit(): void
    {
        $auditResult = PageSpeedDesktopAudits::factory()->has(DesktopAudits::factory(), 'audit')->create();
        $this->assertNotEmpty($auditResult->audit);
        $this->assertInstanceOf(DesktopAudits::class ,$auditResult->audit);
    }

    public function testScopeByMeausrements(): void
    {
        $correctMeasurementId = 2;
        $correctResultsCount = 5;
        $wrongMeasurementId = 4;
        PageSpeedDesktopAudits::factory()->withMeausureId($correctMeasurementId)->count($correctResultsCount)->create();
        PageSpeedDesktopAudits::factory()->withMeausureId($wrongMeasurementId)->count(2)->create();

        $auditResults = PageSpeedDesktopAudits::byMeausrements([2])->get();
        $this->assertCount($correctResultsCount, $auditResults);
        foreach ($auditResults as $auditResult) {
            $this->assertEquals($correctMeasurementId, $auditResult->measurements_id);
        }
    }
}
