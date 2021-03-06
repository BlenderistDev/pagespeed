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

    private array $email = [];

    private const REGULAR_AUDIT_COMMENT = 'regular audit';

    /**
     * Create a new job instance.
     *
     * @param string $url
     */
    public function __construct(private string $url, string $email = '')
    {
        if ($email) {
            $this->email = explode(',', $email);
        }
    }

    /**
     * Execute the job.
     *
     * @param Measurements $measurements
     * @return void
     */
    public function handle(Measurements $measurements): void
    {
        $measurements->domain = $this->url;
        $measurements->comment = self::REGULAR_AUDIT_COMMENT;
        $measurements->save();
        $this->sendMail($measurements);
    }

    public function uniqueId(): string
    {
        return $this->url;
    }

    private function sendMail(Measurements $measurements): void
    {
        foreach($this->email as $email) {
            Mail::to(trim($email))->queue(new RegularAuditComplete($measurements));
        }
    }
}
