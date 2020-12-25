<?php

namespace Tests\Unit\App\Http\Controllers;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function testIndexResponseOk()
    {
        $this->withoutMiddleware();
        $this->get('/home')->assertOk();
    }
}