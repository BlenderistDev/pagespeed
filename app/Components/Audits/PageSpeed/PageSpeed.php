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

    private const Locate = 'ru';

    public function makeAudit(string $url, int $iMeasureId, LoopInterface &$loop): PromiseInterface
    {
        $key = $this->getKey();
        $auditResultFactory = $this->getAuditResultFactory()->state(['measurements_id' => $iMeasureId]);
        $auditFactory = $this->getAuditsFactory();
        $strategy = $this->getStrategy();
        $browser = (new Browser($loop))->withTimeout(180);
        return $browser->get(self::PAGESPEED_API_LINK . "?url=$url&key=$key&strategy=$strategy&locale=" . self::Locate)
            ->then(function(ResponseInterface $response) use ($auditFactory, $auditResultFactory) {
                $aResults = json_decode($response->getBody()->getContents(), true);
                AuditSaver::makeGooglePageSpeedAudits($aResults, $auditFactory, $auditResultFactory);
            }, function (\Exception $error) {
                throw $error;
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

    private function getKey(): string
    {
        return env('GOOGLE_DEVELOPER_KEY', '');
    }
}
