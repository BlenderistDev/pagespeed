<?php

namespace App\Jobs;

use App\Models\Measurements;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class MakeAudit implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private string $url = '';

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $url) 
    {
        $this->url = $url;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Measurements $measurements)
    {
        $measurements->domain = $this->url;
        $measurements->comment = "regular audit";
        $measurements->save();
    }

    public function uniqueId(): string
    {
        return $this->url;
    }
}
