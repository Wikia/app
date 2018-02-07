<?php

namespace Mcustiel\PowerRoute\Tests\Unit\Factories;

use Mcustiel\Creature\CreatorInterface;
use Mcustiel\PowerRoute\Common\Factories\InputSourceFactory;
use Mcustiel\PowerRoute\InputSources\InputSourceInterface;

class InputSourceFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldReturnAnInstanceAndSetArguments()
    {
        $creator = $this->getMockBuilder(CreatorInterface::class)->disableOriginalConstructor()->getMock();

        $mock = $this->getMockBuilder(InputSourceInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $creator->expects($this->once())
            ->method('getInstance')
            ->willReturn($mock);

        $factory = new InputSourceFactory(['potato' => $creator]);
        $argumentClassObject = $factory->createFromConfig(['potato' => 'tomato']);
        $this->assertSame($mock, $argumentClassObject->getInstance());
        $this->assertSame('tomato', $argumentClassObject->getArgument());
    }
}
