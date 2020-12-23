<?php

namespace App\Components\Audits;

use App\Components\Audits\PageSpeed\DesktopPageSpeed;
use App\Components\Audits\PageSpeed\MobilePageSpeed;
use function Clue\React\Block\awaitAll;
use React\EventLoop;

class Audits
{
    public function makeAudits(string $url, int $foreignId): void
    {
        $loop = EventLoop\Factory::create();
        $audits = [];
        foreach ($this->getAuditServices() as $auditService) {
            $audits []= $auditService->makeAudit($url, $foreignId, $loop);
        }
        try {
            awaitAll($audits, $loop, 120);
        } catch(\Exception $e) {
            logger($e);
        }
    }

    public function getAuditCollection(): AuditCollection
    {
        return new AuditCollection($this->getAuditServices());
    }

    public function getAuditResults($measureIdList): array
    {
        foreach ($this->getAuditServices() as $serviceName => $service) {
            $auditResults[$serviceName] = $service->getAuditResults($measureIdList);
        }
        return $auditResults ?? [];
    }

    /**
     * @return IAuditService[]
     */
    private function getAuditServices(): array
    {
        return [
            'mobile' => new MobilePageSpeed(),
            'desktop' => new DesktopPageSpeed(),
        ];
    }
}
