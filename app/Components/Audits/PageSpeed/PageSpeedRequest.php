<?php

namespace App\Components\Audits\PageSpeed;

use Psr\Http\Message\ResponseInterface;
use React\EventLoop\LoopInterface;
use React\Http\Browser;
use React\Promise\PromiseInterface;

class PageSpeedRequest
{
    private const PAGESPEED_API_LINK = "https://www.googleapis.com/pagespeedonline/v5/runPagespeed";

    private const Locate = 'ru';

    public static function makeAuditRequest(LoopInterface &$loop, string $url, $strategy): PromiseInterface
    {
        $key = self::getKey();
        $browser = (new Browser($loop))->withTimeout(180);
        return $browser
            ->get(self::PAGESPEED_API_LINK . "?url=$url&key=$key&strategy=$strategy&locale=" . self::Locate)
            ->then(function(ResponseInterface $response): array {  
                return json_decode($response->getBody()->getContents(), true);
            });
    }

    private static function getKey(): string
    {
        return env('GOOGLE_DEVELOPER_KEY', '');
    }
}