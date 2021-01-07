<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PageSpeedDesktopAudits extends ServiceAuditsPrototype
{
    public function audit(): HasOne
    {
        return $this->hasOne(DesktopAudits::class, 'id', 'audits_id');
    }

    public function getServiceName(): string
    {
        return 'desktop';
    }

    public function getHeaders(): Collection
    {
        return DesktopAudits::all();
    }
}
