<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PageSpeedMobileAudits extends ServiceAuditsPrototype
{
    public function audit(): HasOne
    {
        return $this->hasOne(Audits::class, 'id');
    }

    public function getServiceName(): string
    {
        return 'mobile';
    }

    public function getHeaders(): Collection
    {
        return Audits::all();
    }
}
