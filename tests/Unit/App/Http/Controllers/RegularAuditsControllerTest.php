<?php

namespace Tests\Unit\App\Http\Controllers;

use App\Models\RegularAudits;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Faker;

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

    public function testIndex()
    {
        $faker = Faker\Factory::create();
        $count = $faker->randomDigit;
        $this->withoutMiddleware();
        RegularAudits::factory()->count($count)->create();
        $this->get('/api/regular-audits')->assertJsonCount($count);
    }

    public function testStore()
    {
        $this->withoutMiddleware();
        $regularAudit = RegularAudits::factory()->stars()->make();
        $this->put('/api/regular-audits', $regularAudit->getAttributes());
        $this->assertDatabaseHas('regular_audits', $regularAudit->getAttributes());
    }
}
