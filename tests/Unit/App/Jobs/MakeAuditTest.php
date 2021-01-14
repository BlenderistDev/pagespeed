<?php

namespace Tests\Unit\App\Jobs;

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

    public function testGetUniqueId(): void
    {
        $job = new MakeAudit($this->url);
        $this->assertEquals($this->url, $job->uniqueId());
    }

    public function testJobHandle(): void
    {
        Event::fake();
        MakeAudit::dispatch($this->url);
        $this->assertDatabaseHas('measurements', [
            'domain' => $this->url,
        ]);
    }

    public function testResultsEmailSend(): void
    {
        Event::fake();
        Mail::fake();
        $faker = Faker\Factory::create();
        MakeAudit::dispatch($this->url, $faker->email);
        Mail::assertSent(RegularAuditComplete::class);
    }

    public function testResultsManyEmailSend(): void
    {
        Event::fake();
        Mail::fake();
        $faker = Faker\Factory::create();
        $email = $faker->email . ',' . $faker->email . ',' . $faker->email;
        MakeAudit::dispatch($this->url, $email);
        Mail::assertSent(RegularAuditComplete::class, 3);
    }

    public function testResultsEmailNotSendWithoutEmail(): void
    {
        Event::fake();
        Mail::fake();
        MakeAudit::dispatch($this->url);
        Mail::assertNothingSent();
    }
}
