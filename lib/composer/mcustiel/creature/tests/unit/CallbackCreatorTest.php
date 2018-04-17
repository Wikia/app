<?php

namespace Mcustiel\Creature\Unit;

use Mcustiel\Creature\CallbackCreator;

class CallbackCreatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldReturnTheReturnValueFromTheCallback()
    {
        $callback = function () {
            return 'Some return value';
        };

        $creator = new CallbackCreator($callback);

        $value = $creator->getInstance();
        $this->assertSame('Some return value', $value);
    }
}
