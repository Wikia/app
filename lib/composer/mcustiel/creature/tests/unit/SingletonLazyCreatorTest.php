<?php

namespace Mcustiel\Creature\Unit;

use Mcustiel\Creature\SingletonLazyCreator;
use Mcustiel\Tests\Fixtures\Dummy;

class SingletonLazyCreatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldReturnTheReturnValueFromTheCallback()
    {
        $creator = new SingletonLazyCreator(Dummy::class, [uniqid()]);

        $value1 = $creator->getInstance();
        $this->assertInstanceOf(Dummy::class, $value1);
        $value2 = $creator->getInstance();
        $this->assertSame($value1, $value2);
        $this->assertSame($value1->getArg1(), $value2->getArg1());
    }
}
