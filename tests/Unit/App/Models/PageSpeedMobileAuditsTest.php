<?php

namespace Tests\Unit\App\Models;

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

    public function testAudit(): void
    {
        $auditResult = PageSpeedMobileAudits::factory()->has(Audits::factory(), 'audit')->create();
        $this->assertNotEmpty($auditResult->audit);
        $this->assertInstanceOf(Audits::class ,$auditResult->audit);
    }

    public function testScopeByMeausrements(): void
    {
        $correctMeasurementId = 2;
        $correctResultsCount = 5;
        $wrongMeasurementId = 4;
        PageSpeedMobileAudits::factory()->withMeausureId($correctMeasurementId)->count($correctResultsCount)->create();
        PageSpeedMobileAudits::factory()->withMeausureId($wrongMeasurementId)->count(2)->create();

        $auditResults = PageSpeedMobileAudits::byMeausrements([2])->get();
        $this->assertCount($correctResultsCount, $auditResults);
        foreach ($auditResults as $auditResult) {
            $this->assertEquals($correctMeasurementId, $auditResult->measurements_id);
        }
    }
}
