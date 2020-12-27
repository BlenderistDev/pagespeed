<?php

namespace Tests\Unit\App\Http\Controllers;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class AuditsControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function testIndexResponseOk()
    {
        $this->get('/api/audits')->assertOk();
    }

    public function testAllServicesInResponse()
    {
        $this->get('/api/audits')->assertJsonStructure([
            'mobile' => [],
            'desktop' => [],
        ]);
    }
}
