<?php

namespace Mcustiel\Creature\Unit;

use Mcustiel\Creature\SingletonCallbackCreator;
use Mcustiel\Tests\Fixtures\Dummy;

class SingletonCallbackCreatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldReturnTheReturnValueFromTheCallback()
    {
        $callback = function () {
            return new Dummy(uniqid());
        };

        $creator = new SingletonCallbackCreator($callback);

        $value1 = $creator->getInstance();
        $this->assertInstanceOf(Dummy::class, $value1);
        $value2 = $creator->getInstance();
        $this->assertSame($value1, $value2);
        $this->assertSame($value1->getArg1(), $value2->getArg1());
    }
}
