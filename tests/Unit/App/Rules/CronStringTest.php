<?php

namespace Tests\Unit;

use App\Exceptions\CronStringException;
use App\Rules\CronString;
use PHPUnit\Framework\TestCase;

class CronStringTest extends TestCase
{
    /**
     * @dataProvider CronStringsProvider
     */
    public function testPasses($attribute, $max)
    {
        $cronStringRule = new CronString();
        $this->assertTrue($cronStringRule->passes($attribute, '1'));
        $this->assertTrue($cronStringRule->passes($attribute, '*'));
        $this->assertTrue($cronStringRule->passes($attribute, '*/10'));
        $this->assertTrue($cronStringRule->passes($attribute, "1-$max"));

        $this->assertFalse($cronStringRule->passes($attribute, '*/*'));
        $this->assertFalse($cronStringRule->passes($attribute, (string) $max + 1));
        $this->assertFalse($cronStringRule->passes($attribute, '-4'));
    }

    public function testPassesNotInList()
    {
        $cronStringRule = new CronString();
        $this->expectException(CronStringException::class);
        $cronStringRule->passes('something', '*');
    }

    public function testIncorrectMessage()
    {
        $cronStringRule = new CronString();
        $this->assertEquals('Некорректное значение', $cronStringRule->message());
    }

    /**
     * Для каждого элемента cron строки
     * Указывается максимальное допустимое значение
     */
    public function CronStringsProvider()
    {
        return [
            ['minute', 59],
            ['hour', 23],
            ['month_day', 31],
            ['month', 12],
            ['week_day', 7],
        ];
    }
}
