<?php
/**
 * This file is part of mockable-datetime.
 *
 * mockable-datetime is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * mockable-datetime is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with mockable-datetime.  If not, see <http://www.gnu.org/licenses/>.
 */
namespace Unit;

use Mcustiel\Mockable\DateTimeUtils;
use Mcustiel\Mockable\DateTime;

class DateTimeTest extends \PHPUnit_Framework_TestCase
{
    const SLEEP_TIME_IN_SECONDS = 3;

    /**
     * @test
     */
    public function shouldReturnAFixedTimeEveryTimeItIsCalled()
    {
        $expected = \DateTime::createFromFormat('Y-m-d H:i:s', '2000-01-01 00:00:01')->getTimestamp();
        DateTimeUtils::setCurrentTimestampFixed($expected);
        $dateTime = new DateTime();

        $this->assertEquals($expected, $dateTime->toPhpDateTime()->getTimestamp());
        sleep(self::SLEEP_TIME_IN_SECONDS);
        $this->assertEquals($expected, $dateTime->toPhpDateTime()->getTimestamp());
    }

    /**
     * @test
     */
    public function shouldReturnAFixedTimeEveryTimeItIsCalledInDifferentTimezone()
    {
        $expected = \DateTime::createFromFormat(
            'Y-m-d H:i:s',
            '2000-01-01 00:00:01',
            new \DateTimeZone('America/New_York')
        )->getTimestamp();
        DateTimeUtils::setCurrentTimestampFixed($expected);

        $dateTime = new DateTime();
        $phpDateTime = $dateTime->toPhpDateTime();

        $this->assertEquals($expected, $phpDateTime->getTimestamp());
        sleep(self::SLEEP_TIME_IN_SECONDS);
        $this->assertEquals($expected, $phpDateTime->getTimestamp());
    }

    /**
     * @test
     */
    public function shouldReturnTimeBasedInAnOffsetEveryTimeIsCalled()
    {
        $expected = \DateTime::createFromFormat('Y-m-d H:i:s', '2000-01-01 00:00:01')->getTimestamp();
        DateTimeUtils::setCurrentTimestampOffset($expected);
        $dateTime = new DateTime();

        $this->assertEquals($expected, $dateTime->toPhpDateTime()->getTimestamp());
        sleep(self::SLEEP_TIME_IN_SECONDS);
        $this->assertEquals(
            $expected + self::SLEEP_TIME_IN_SECONDS,
            $dateTime->toPhpDateTime()->getTimestamp()
        );
    }

    /**
     * @test
     */
    public function shouldReturnTimeBasedInAnOffsetEveryTimeIsCalledInDifferentTimezone()
    {
        $expected = \DateTime::createFromFormat(
            'Y-m-d H:i:s',
            '2000-01-01 00:00:01',
            new \DateTimeZone('America/New_York')
        )->getTimestamp();
        DateTimeUtils::setCurrentTimestampOffset($expected);
        $dateTime = new DateTime();

        $this->assertEquals($expected, $dateTime->toPhpDateTime()->getTimestamp());
        sleep(self::SLEEP_TIME_IN_SECONDS);
        $this->assertEquals(
            $expected + self::SLEEP_TIME_IN_SECONDS,
            $dateTime->toPhpDateTime()->getTimestamp()
        );
    }

    /**
     * @test
     */
    public function shouldReturnSystemTimeEveryTimeIsCalled()
    {
        DateTimeUtils::setCurrentTimestampSystem();
        $dateTime = new DateTime();

        $this->assertEquals(
            (new \DateTime())->getTimestamp(),
            $dateTime->toPhpDateTime()->getTimestamp()
        );
        sleep(self::SLEEP_TIME_IN_SECONDS);
        $this->assertEquals(
            (new \DateTime())->getTimestamp(),
            $dateTime->toPhpDateTime()->getTimestamp()
        );
    }
}
