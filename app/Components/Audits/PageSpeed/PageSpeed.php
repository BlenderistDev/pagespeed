<?php

namespace App\Components\Audits\PageSpeed;

use App\Components\Audits\IAuditService;
use Database\Factories\AuditResultFactoryPrototype;
use Database\Factories\AuditsFactoryPrototype;
use Illuminate\Support\Collection;
use React\EventLoop\LoopInterface;
use React\Promise\PromiseInterface;

abstract class PageSpeed implements IAuditService
{
    public function makeAudit(string $url, int $iMeasureId, LoopInterface &$loop): PromiseInterface
    {
        $auditResultFactory = $this->getAuditResultFactory()->state(['measurements_id' => $iMeasureId]);
        $auditFactory = $this->getAuditsFactory();
        return PageSpeedRequestFacade::makeAuditRequest($loop, $url, $this->getStrategy())
            ->then(function(array $response) use ($auditFactory, $auditResultFactory) {
                AuditSaver::makeGooglePageSpeedAudits($response, $auditFactory, $auditResultFactory);
            });
    }

    public function getAuditResults(array $measureIdList): Collection
    {
        $audits = $this->getAuditResultFactory()->modelName()::byMeausrements($measureIdList)
            ->get()
            ->groupBy(['measurements_id'])
        ;
        $audits = $audits->transform(function($item) {
            return $item->keyBy('audits_id');
        });
        return $audits;
    }

    public abstract function getAuditResultFactory(): AuditResultFactoryPrototype;

    protected abstract function getAuditsFactory(): AuditsFactoryPrototype;

    protected abstract function getStrategy(): string;

    public abstract function getLinkName(): string;
}
