<?php

namespace App\Components\Audits;

use App\Components\Audits\PageSpeed\DesktopPageSpeed;
use App\Components\Audits\PageSpeed\MobilePageSpeed;
use function Clue\React\Block\awaitAll;
use React\EventLoop;

class Audits
{
    public static function makeAudits(string $url, int $foreignId): void
    {
        $loop = EventLoop\Factory::create();
        $audits = [];
        foreach (self::getAuditServices() as $auditService) {
            $audits []= $auditService->makeAudit($url, $foreignId, $loop);
        }
        try {
            awaitAll($audits, $loop, 120);
        } catch(\Exception $e) {
            logger($e);
        }
    }

    public static function getAuditCollection(): AuditCollection
    {
        return new AuditCollection(self::getAuditServices());
    }

    public static function getAuditResults(array $filter): array
    {
        foreach (self::getAuditServices() as $serviceName => $service) {
            $auditResults[$serviceName] = $service->getAuditResults($filter);
        }
        return $auditResults ?? [];
    }

    public static function getAuditResultsByDomain(string $domain): array
    {
        foreach (self::getAuditServices() as $serviceName => $service) {
            $auditResults[$serviceName] = $service->getAuditResultsByDomain($domain);
        }
        return $auditResults ?? [];
    }

    public static function getAuditResultById(int $id): array
    {
      foreach (self::getAuditServices() as $serviceName => $service) {
        $auditResult[$serviceName] = $service->getAuditResultsById($id);
      }
      return $auditResult ?? [];
    }

    /**
     * @return IAuditService[]
     */
    private static function getAuditServices(): array
    {
        return [
            'mobile' => new MobilePageSpeed(),
            'desktop' => new DesktopPageSpeed(),
        ];
    }
}
