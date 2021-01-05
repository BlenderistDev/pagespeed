<?php

namespace Tests\Unit\Models;

use App\Jobs\MakeAudit;
use App\Mail\RegularAuditComplete;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Faker;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;

class MakeAuditTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        $faker = Faker\Factory::create();
        $this->url = $faker->url;
        parent::setUp();
    }

    public function testGetUniqueId()
    {
        $job = new MakeAudit($this->url);
        $this->assertEquals($this->url, $job->uniqueId());
    }

    public function testJobHandle()
    {
        Event::fake();
        MakeAudit::dispatch($this->url);
        $this->assertDatabaseHas('measurements', [
            'domain' => $this->url,
        ]);
    }

    public function testResultsEmailSend()
    {
        Event::fake();
        Mail::fake();
        $faker = Faker\Factory::create();
        MakeAudit::dispatch($this->url, $faker->email);
        Mail::assertSent(RegularAuditComplete::class);
    }

    public function testResultsEmailNotSendWithoutEmail()
    {
        Event::fake();
        Mail::fake();
        MakeAudit::dispatch($this->url);
        Mail::assertNothingSent();
    }
}
