<?php

namespace Tests\Unit\App\Http\Controllers;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class AuditResultControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function testIndexResponseOk(): void
    {
        $this->post('/api/audit-results')->assertOk();
    }

    public function testAllServicesInResponse(): void
    {
        $this->post('/api/audit-results')->assertJsonStructure([
            'mobile' => [],
            'desktop' => [],
        ]);
    }
}