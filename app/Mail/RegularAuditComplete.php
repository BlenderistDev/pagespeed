<?php

namespace App\Mail;

use App\Models\Measurements;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegularAuditComplete extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(private Measurements $measurement)
    {
    }

    public function build(): self
    {
        return $this->from('noreplay@smoke-e.ru')
            ->view('emails.regularAuditComplete', [
                'measurement' => $this->measurement,
            ]);
    }
}
