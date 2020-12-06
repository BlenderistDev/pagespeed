<?php

namespace App\Services;

use App\Models\ServiceAuditsPrototype;
use Illuminate\Support\Collection;

class AuditService
{
    
    private ServiceAuditsPrototype $model;

    public function __construct(ServiceAuditsPrototype $model)
    {
        $this->model = $model;
    }

    public function parseServicesFromCollection(Collection $measurements, string $linkName): Collection
    {
        $audits = $measurements->pluck($linkName)->flatten()->groupBy(['measurements_id']);
        $audits = $audits->transform(function($item) {
            return $item->keyBy('audits_id');
        });
        return $audits;
    }

    public function getServiceName()
    {
        return $this->model->getServiceName();
    }

    public function getHeaders()
    {
        return $this->model->getHeaders();
    }
}