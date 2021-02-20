<?php

namespace App\Components\Audits;

use Illuminate\Support\Collection;
use React\EventLoop\LoopInterface;
use Database\Factories\AuditResultFactoryPrototype;

interface IAuditService
{
    public function makeAudit(string $url, int $iMeasureId, LoopInterface &$loop);
    public function getAuditResults(array $filter): Collection;
    public function getAuditResultFactory(): AuditResultFactoryPrototype;
    public function getLinkName(): string;
    public function getAuditResultsByDomain(string $domain): array;
    public function getAuditResultsById(int $id): array;
}
