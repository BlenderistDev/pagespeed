<?php

namespace Tests\Unit\App\Http\Controllers;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class AuditResultControllerTest extends TestCase
{
    use DatabaseMigrations;
    use WithoutMiddleware;

    public function testIndexResponseOk()
    {
        $response = $this->get(route('audits.index'))->assertOk();
    }
}
