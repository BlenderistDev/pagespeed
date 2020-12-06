<?php

namespace App\Services;

use App\Models\Audits;
use App\Models\DesktopAudits;
use App\Models\PageSpeedDesktopAudits;
use App\Models\PageSpeedMobileAudits;
use Psr\Http\Message\ResponseInterface;
use React\EventLoop\Factory;
use React\Http\Browser;
use function Clue\React\Block\awaitAll;

class GooglePageSpeed
{
    private const PAGESPEED_API_LINK = "https://www.googleapis.com/pagespeedonline/v5/runPagespeed";

    private $browser;

    private $key;

    public function __construct()
    {
        $this->key = env('GOOGLE_DEVELOPER_KEY', '');
        $this->loop = Factory::create();
        $browser = new Browser($this->loop);
        $this->browser = $browser->withTimeout(180);
    }

    public function makePageSpeedAudits($url, $iMeasureId)
    {
        try {
            awaitAll([
                $this->pagespeed($url, $iMeasureId, 'MOBILE', Audits::class, PageSpeedMobileAudits::class),
                $this->pagespeed($url, $iMeasureId, 'DESKTOP', DesktopAudits::class, PageSpeedDesktopAudits::class)
            ], $this->loop, 120);
        } catch(\Exception $e) {
            while($e->getPrevious()) {
                $e = $e->getPrevious();
            }
            var_dump($e);
        }
    }

    protected function pagespeed($url, $iMeasureId, $strategy, $Audits, $ResultModel) 
    {
        return $this->browser->get(self::PAGESPEED_API_LINK . "?url=$url&key=" . $this->key . "&strategy=$strategy")
            ->then(function(ResponseInterface $response) use ($iMeasureId, $Audits, $ResultModel) {
                $aResults = json_decode($response->getBody()->getContents(), true);
                AuditSaver::makeGooglePageSpeedAudits($aResults, $iMeasureId, $Audits, $ResultModel);
        }, function (\Exception $error) {
            var_dump($error);
        });
    }
}