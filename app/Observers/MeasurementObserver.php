<?php

namespace App\Observers;

use App\Components\Audits\Audits;
use App\Models\Measurements;

class MeasurementObserver
{
    public function created(Measurements $measure) 
    {
        $url =  $measure->domain;
        $audits = new Audits();
        $audits->makeAudits($url, $measure->id);
    }
}
