<?php

namespace App\Observers;

use App\Components\Audits\Audits;
use App\Models\Measurements;

class MeasurementObserver
{
    public function created(Measurements $measure): void
    {
        $url =  $measure->domain;
        Audits::makeAudits($url, $measure->id);
    }
}
