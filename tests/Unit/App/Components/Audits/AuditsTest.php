<?php

namespace Tests\Unit;

use App\Components\Audits\Audits;
use App\Components\Audits\PageSpeed\PageSpeedRequestFacade;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Faker;
use React\Promise\Deferred;

class AuditsTest extends TestCase
{
    use DatabaseMigrations;

    public function testMakeAudit()
    {
        $deferred = new Deferred();
        $promise = $deferred->promise();
        $deferred->resolve(json_decode(file_get_contents(__DIR__ . '/PageSpeed/PageSpeedResponseSample.json'), true));

        PageSpeedRequestFacade::shouldReceive('makeAuditRequest')->twice()->andReturn($promise);
        
        $faker = Faker\Factory::create();
        $audit = new Audits();
        $audit->makeAudits($faker->url, 1);
    }
}
