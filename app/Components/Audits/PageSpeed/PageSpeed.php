<?php

namespace App\Components\Audits\PageSpeed;

use App\Components\Audits\IAuditService;
use Database\Factories\AuditResultFactoryPrototype;
use Database\Factories\AuditsFactoryPrototype;
use Illuminate\Support\Collection;
use Psr\Http\Message\ResponseInterface;
use React\EventLoop\LoopInterface;
use React\Http\Browser;
use React\Promise\PromiseInterface;

abstract class PageSpeed implements IAuditService
{
    private const PAGESPEED_API_LINK = "https://www.googleapis.com/pagespeedonline/v5/runPagespeed";

    public abstract function getAuditResultFactory(): AuditResultFactoryPrototype;

    public abstract function getAuditsFactory(): AuditsFactoryPrototype;

    protected abstract function getStrategy(): string;

    public abstract function getLinkName(): string;

    public function makeAudit(string $url, int $iMeasureId, LoopInterface &$loop): PromiseInterface
    {
        $key = $this->getKey();
        $auditResultFactory = $this->getAuditResultFactory()->state(['measurements_id' => $iMeasureId]);
        $auditFactory = $this->getAuditsFactory();
        $strategy = $this->getStrategy();
        $browser = (new Browser($loop))->withTimeout(180);
        return $browser->get(self::PAGESPEED_API_LINK . "?url=$url&key=$key&strategy=$strategy")
            ->then(function(ResponseInterface $response) use ($auditFactory, $auditResultFactory) {
                $aResults = json_decode($response->getBody()->getContents(), true);
                AuditSaver::makeGooglePageSpeedAudits($aResults, $auditFactory, $auditResultFactory);
        }, function (\Exception $error) {
            throw $error;
        });
    }

    private function getKey(): string
    {
        return env('GOOGLE_DEVELOPER_KEY', '');
    }

    public function parseServicesFromCollection(Collection $measurements): Collection
    {
        $linkName = $this->getLinkName();
        $audits = $measurements->pluck($linkName)->flatten()->groupBy(['measurements_id']);
        $audits = $audits->transform(function($item) {
            return $item->keyBy('audits_id');
        });
        return $audits;
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
        // var_dump($measureIdList);
        return $audits;
        
        // exit;
        // $audits = $audits->transform(function($item) {
        //     return $item->keyBy('audits_id');
        // });
        return $audits;
    }
}