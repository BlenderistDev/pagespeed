<?php

namespace Tests\Unit\App\Components\Audits;

use App\Components\Audits\PageSpeed\MobilePageSpeed;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use function Clue\React\Block\await;
use React\EventLoop;

class MobilePageSpeedTest extends TestCase
{
    use DatabaseMigrations;

//    /**
//     * @throws \Exception
//     */
//    public function testMakeAudit()
//    {
//        $pageSpeed = new MobilePageSpeed();
//        $loop = EventLoop\Factory::create();
//        await($pageSpeed->makeAudit('https://google.com', 12, $loop), $loop,120)->then(function () {
//            $this->assertTrue(true);
//        });
//    }
}
