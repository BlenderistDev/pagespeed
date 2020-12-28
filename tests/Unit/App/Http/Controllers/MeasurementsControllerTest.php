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
}