<?php

namespace Tests\Unit\App\Http\Controllers;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class MeasurementsControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function testIndexResponseOk()
    {
        $this->post('/api/measurements')->assertOk();
    }
}