<?php

namespace Mcustiel\Creature\Unit;

use Mcustiel\Creature\ObjectDistributor;

class ObjectDistributorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldReturnAnInstanceOfTheSpecifiedClassWithArguments()
    {
        $creator = new ObjectDistributor('potato');

        $value = $creator->getInstance();
        $this->assertSame('potato', $value);
    }
}
