<?php

namespace Tests\Unit\App\Http\Controllers;

use App\Components\Audits\PageSpeed\DesktopPageSpeed;
use App\Models\Measurements;
use App\Models\PageSpeedDesktopAudits;
use App\Models\PageSpeedMobileAudits;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class MeasurementsControllerTest extends TestCase
{
    use DatabaseMigrations;

    private $totalMeasurements = 20;

    public function testIndexResponseOk(): void
    {
        $this->post('/api/measurements')->assertOk();
    }

    public function testPagination(): void
    {
        Event::fake();
        Measurements::factory()->count($this->totalMeasurements)->create();

        $onPage = 5;
        $response = $this->post('/api/measurements', [
            'page' => [
                'onPage' => $onPage,
            ],
        ]);

        $response->assertJsonCount($onPage, 'data');
    }

    public function testAllCount(): void
    {
        Event::fake();
        Measurements::factory()->count($this->totalMeasurements)->create();

        $this->post('/api/measurements')->assertJsonFragment(['total' => $this->totalMeasurements]);
    }

    public function testFilterByDomain(): void
    {
        $domain = 'https://google.com';
        Event::fake();
        Measurements::factory()->count($this->totalMeasurements)->create();
        Measurements::factory()->domain($domain)->count(5)->create();

        $response = $this->post('/api/measurements', [
            'filter' => [
                'domain' => $domain,
            ],
        ])->json();
        
        foreach ($response['data'] as $item) {
            $this->assertStringContainsString($domain, $item['domain']);
        }
    }

    public function testFilterByComment(): void
    {
        Event::fake();
        Measurements::factory()->count($this->totalMeasurements)->create();
        $comment = 'test_comment';

        Measurements::factory()->comment($comment)->count(5)->create();
        $response = $this->post('/api/measurements', [
            'filter' => [
                'comment' => $comment,
            ],
        ])->json();

        foreach ($response['data'] as $item) {
            $this->assertStringContainsString($comment, $item['comment']);
        }
    }

    public function testSortByCreatedAt(): void
    {
        Event::fake();
        Measurements::factory()->count($this->totalMeasurements)->create();
        $field = 'created_at';

        $response = $this->post('/api/measurements', [
            'sort' => [
                'field' => $field,
                'way' => 'ASC',
            ],
        ])->json();
        $items = collect($response['data']);
        $this->assertEquals($items->pluck('id'), $items->sortBy($field)->pluck('id'));

        $response = $this->post('/api/measurements', [
            'sort' => [
                'field' => $field,
                'way' => 'DESC',
            ],
        ])->json();
        $items = collect($response['data']);
        $this->assertEquals($items->pluck('id'), $items->sortByDesc($field)->pluck('id'));
    }

    public function testSortByDomain(): void
    {
        Event::fake();
        Measurements::factory()->count($this->totalMeasurements)->create();
        $field = 'domain';

        $response = $this->post('/api/measurements', [
            'sort' => [
                'field' => $field,
                'way' => 'ASC',
            ],
        ])->json();
        $items = collect($response['data']);
        $this->assertEquals($items->pluck('id'), $items->sortBy($field)->pluck('id'));

        $response = $this->post('/api/measurements', [
            'sort' => [
                'field' => $field,
                'way' => 'DESC',
            ],
        ])->json();
        $items = collect($response['data']);
        $this->assertEquals($items->pluck('id'), $items->sortByDesc($field)->pluck('id'));
    }

    public function testSortByComment(): void
    {
        Event::fake();
        Measurements::factory()->count($this->totalMeasurements)->create();
        $field = 'comment';

        $response = $this->post('/api/measurements', [
            'sort' => [
                'field' => $field,
                'way' => 'ASC',
            ],
        ])->json();
        $items = collect($response['data']);
        $this->assertEquals($items->pluck('id'), $items->sortBy($field)->pluck('id'));

        $response = $this->post('/api/measurements', [
            'sort' => [
                'field' => $field,
                'way' => 'DESC',
            ],
        ])->json();
        $items = collect($response['data']);
        $this->assertEquals($items->pluck('id'), $items->sortByDesc($field)->pluck('id'));
    }

    public function testSortByDesktopServiceField()
    {
        $field = 3;
        $service = 'desktop';
        Event::fake();
        Measurements::factory()
            ->count($this->totalMeasurements)
            ->has(PageSpeedDesktopAudits::factory()->audit($field), 'measureDesktop')
            ->create();
        
        $response = $this->post('/api/measurements', [
            'sort' => [
                'field' => $field,
                'way' => 'ASC',
                'service' => $service,
            ],
        ])->json('data');

        $auditResults = $this->post('/api/audit-results', [
            'idList' => collect($response)->pluck('id')->toArray(),
        ])->json();

        $items = collect($response)->sortBy(function ($measure) use ($auditResults, $field, $service) {
            return $auditResults[$service][$measure['id']][$field]['value'];
        });

        $this->assertEquals(collect($response)->pluck('id'), $items->pluck('id'));
    }

    public function testSortByMobileServiceField()
    {
        $field = 3;
        $service = 'mobile';
        Event::fake();
        Measurements::factory()
            ->count($this->totalMeasurements)
            ->has(PageSpeedMobileAudits::factory()->audit($field), 'measure')
            ->create();
        
        $response = $this->post('/api/measurements', [
            'sort' => [
                'field' => $field,
                'way' => 'DESC',
                'service' => $service,
            ],
        ])->json('data');

        $auditResults = $this->post('/api/audit-results', [
            'idList' => collect($response)->pluck('id')->toArray(),
        ])->json();

        $items = collect($response)->sortByDesc(function ($measure) use ($auditResults, $field, $service) {
            return $auditResults[$service][$measure['id']][$field]['value'];
        });

        $this->assertEquals(collect($response)->pluck('id'), $items->pluck('id'));
    }

    public function testStore()
    {
        Event::fake();
        $measurement = Measurements::factory()->makeOne();
        $this->post('/api/measurements/store', $measurement->attributesToArray());
        $this->assertDatabaseHas('measurements', $measurement->attributesToArray());
    }
}