<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegularAuditComplete extends Mailable
{
    use Queueable, SerializesModels;

    public $measurement;
 
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($measurement)
    {
        $this->measurement = $measurement;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('noreplay@smoke-e.ru')
            ->view('emails.regularAuditComplete', [
                'measurement' => $this->measurement,
                'desktopAudits' => $this->measurement->measureDesktop,
                'desktopAudits' => $this->measurement->measureDesktop,
            ]);
    }
}
