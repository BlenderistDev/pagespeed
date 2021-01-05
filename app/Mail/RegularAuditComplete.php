<?php

namespace App\Mail;

use App\Models\Measurements;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegularAuditComplete extends Mailable
{
    use Queueable, SerializesModels;
 
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(private Measurements $measurement)
    {
        $this->measurement = $measurement;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): self
    {
        return $this->from('noreplay@smoke-e.ru')
            ->view('emails.regularAuditComplete', [
                'measurement' => $this->measurement,
            ]);
    }
}
