<?php

namespace Mcustiel\PowerRoute\Tests\Unit\InputSources;

use Mcustiel\PowerRoute\InputSources\Header;

class HeaderTest extends AbstractInputSourceTest
{
    public function setUp()
    {
        parent::setUp();
        $this->evaluator = new Header();
    }

    /**
     * @test
     */
    public function shouldReturnTheValueOfTheHeader()
    {
        $this->request->expects($this->once())
            ->method('getHeaderLine')
            ->with('X-Banana')
            ->willReturn('potato');
        $this->assertSame('potato', $this->evaluator->getValue($this->request, 'X-Banana'));
    }

    /**
     * @test
     */
    public function shouldPassNullToMatcherIfHeaderIsNotSet()
    {
        $this->request
            ->expects($this->once())
            ->method('getHeaderLine')
            ->with('X-Banana')
            ->willReturn('');
        $this->assertNull($this->evaluator->getValue($this->request, 'X-Banana'));
    }
}
