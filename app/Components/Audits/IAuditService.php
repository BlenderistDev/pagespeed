<?php

namespace App\Components\Audits;

use Database\Factories\AuditResultFactoryPrototype;
use Database\Factories\AuditsFactoryPrototype;
use Illuminate\Support\Collection;
use React\EventLoop\LoopInterface;

interface IAuditService
{
    public function makeAudit(string $url, int $iMeasureId, LoopInterface &$loop);
    public function getAuditResultFactory(): AuditResultFactoryPrototype;
    public function getAuditsFactory(): AuditsFactoryPrototype;
    public function getServiceName(): String;
    public function getLinkName(): String;
    public function parseServicesFromCollection(Collection $measurements): Collection;
    public function getAuditResults(array $measureIdList): Collection;
}