<?php

namespace App\Observers;

use App\Components\Audits\AuditFacade;
use App\Models\Measurements;

class MeasurementObserver
{
    public function created(Measurements $measure): void
    {
        $url =  $measure->domain;
        AuditFacade::makeAudits($url, $measure->id);
    }
}
