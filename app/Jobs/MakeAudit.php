<?php

namespace App\Jobs;

use App\Mail\RegularAuditComplete;
use App\Models\Measurements;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class MakeAudit implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private string $url = '';

    private array $email;

    /**
     * Create a new job instance.
     *
     * @param string $url
     */
    public function __construct(string $url, string $email = '')
    {
        $this->url = $url;
        $this->email = explode(',', $email);
    }

    /**
     * Execute the job.
     *
     * @param Measurements $measurements
     * @return void
     */
    public function handle(Measurements $measurements)
    {
        $measurements->domain = $this->url;
        $measurements->comment = "regular audit";
        $measurements->save();
        if ($this->email) {
            foreach($this->email as $email) {
                Mail::to(trim($email))->send(new RegularAuditComplete($measurements));
            }
           
        }
    }

    public function uniqueId(): string
    {
        return $this->url;
    }
}
