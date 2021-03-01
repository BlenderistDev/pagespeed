<?php

namespace App\Mail;

use App\Models\Measurements;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegularAuditComplete extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(private Measurements $measurement) {}

    public function build(): self
    {
        return $this->from('noreplay@smoke-e.ru')
            ->markdown('emails.regularAuditComplete', [
                'measurement' => $this->measurement,
                'url' => $this->getMeasurementUrl(),
            ]);
    }

    private function getMeasurementUrl(): string
    {
        return env('APP_URL') . "/audit/{$this->measurement->id}";
    }
}
