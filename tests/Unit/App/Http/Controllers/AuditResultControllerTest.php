<?php

namespace Tests\Unit\App\Http\Controllers;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class AuditResultControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function testIndexResponseOk()
    {
        $this->post('/api/audit-results')->assertOk();
    }

    public function testAllServicesInResponse()
    {
        $this->post('/api/audit-results')->assertJsonStructure([
            'mobile' => [],
            'desktop' => [],
        ]);
    }
}