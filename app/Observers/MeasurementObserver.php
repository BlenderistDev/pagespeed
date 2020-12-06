<?php

namespace App\Observers;

use App\Models\Measurements;
use App\Services\GooglePageSpeed;

class MeasurementObserver
{
    public function created(Measurements $measure) 
    {
        $sUrl =  $measure->domain;
        $oGooglePageSpeed = new GooglePageSpeed();
        $oGooglePageSpeed->makePageSpeedAudits($sUrl, $measure->id);
    }
}
