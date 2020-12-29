<?php

namespace Tests\Unit\App\Http\Controllers;

use App\Models\Measurements;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class MeasurementsControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function testIndexResponseOk()
    {
        $this->post('/api/measurements')->assertOk();
    }

    public function testPagination()
    {
        $onPage = 5;
        Event::fake();
        Measurements::factory()->count(20)->create();
        $response = $this->post('/api/measurements', [
            'page' => [
                'onPage' => $onPage
            ],
        ]);
        $response->assertJsonCount($onPage, 'data');
    }

    public function testAllCount()
    {
        $total = 20;
        Event::fake();
        Measurements::factory()->count($total)->create();
        $this->post('/api/measurements')->assertJsonFragment(['total' => $total]);
    }

    public function testFilterByDomain()
    {
        $total = 20;
        $domain = 'https://google.com';
        Event::fake();
        Measurements::factory()->count($total)->create();
        Measurements::factory()->domain($domain)->count($total)->create();
        $response = $this->post('/api/measurements', [
            'filter' => [
                'domain' => $domain,
            ],
        ])->json();
        foreach ($response['data'] as $item) {
            $this->assertStringContainsString($domain, $item['domain']);
        }
    }

    public function testFilterByComment()
    {
        $total = 20;
        $comment = 'test_comment';
        Event::fake();
        Measurements::factory()->count($total)->create();
        Measurements::factory()->comment($comment)->count($total)->create();
        $response = $this->post('/api/measurements', [
            'filter' => [
                'comment' => $comment,
            ],
        ])->json();
        foreach ($response['data'] as $item) {
            $this->assertStringContainsString($comment, $item['comment']);
        }
    }
}
