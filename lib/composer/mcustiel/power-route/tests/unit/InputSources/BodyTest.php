<?php

namespace Mcustiel\PowerRoute\Tests\Unit\InputSources;

use Mcustiel\PowerRoute\InputSources\Body;
use Psr\Http\Message\StreamInterface;

class BodyTest extends AbstractInputSourceTest
{
    public function setUp()
    {
        parent::setUp();
        $this->evaluator = new Body();
    }

    /**
     * @test
     */
    public function shouldReturnTheMethodInUpperCase()
    {
        $bodyMock = $this->getMockBuilder(StreamInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $bodyMock->expects($this->once())
            ->method('__toString')
            ->willReturn('potato');

        $this->request
            ->expects($this->once())
            ->method('getBody')
            ->willReturn($bodyMock);
        $this->assertSame('potato', $this->evaluator->getValue($this->request));
    }
}
