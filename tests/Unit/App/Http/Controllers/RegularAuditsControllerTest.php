<?php

namespace Tests\Unit\App\Http\Controllers;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class RegularAuditsControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function testIndexResponseOk()
    {
        $this->withoutMiddleware();
        $this->get('/api/regular-audits')->assertOk();
    }

    public function testOnlyAuthAccess()
    {
        $this->getJson('/api/regular-audits')->assertUnauthorized();
        $this->putJson('/api/regular-audits')->assertUnauthorized();
    }
}