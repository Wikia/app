<?php

namespace Mcustiel\Creature\Unit;

use Mcustiel\Creature\LazyCreator;
use Mcustiel\Tests\Fixtures\Dummy;

class LazyCreatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldReturnAnInstanceOfTheSpecifiedClassWithArguments()
    {
        $creator = new LazyCreator(Dummy::class, ['potato', new Dummy('tomato')]);

        $dummy = $creator->getInstance();
        $this->assertInstanceOf(Dummy::class, $dummy);
        $this->assertSame('potato', $dummy->getArg1());
        $this->assertInstanceOf(Dummy::class, $dummy->getArg2());
        $this->assertSame('tomato', $dummy->getArg2()->getArg1());
    }

    /**
     * @test
     */
    public function shouldReturnAnInstanceOfTheSpecifiedClassWithOptionalArguments()
    {
        $creator = new LazyCreator(Dummy::class, ['potato']);

        $dummy = $creator->getInstance();
        $this->assertInstanceOf(Dummy::class, $dummy);
        $this->assertSame('potato', $dummy->getArg1());
        $this->assertNull($dummy->getArg2());
    }

    /**
     * @test
     */
    public function shouldFailIfTheClassDoesNotExist()
    {
        $creator = new LazyCreator('IDontExist', ['potato']);

        $this->setExpectedException(
            \RuntimeException::class,
            'Error creating instance. Class does not exists: IDontExist'
        );

        $creator->getInstance();

    }
}
