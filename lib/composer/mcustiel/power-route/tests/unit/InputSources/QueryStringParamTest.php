<?php

namespace Mcustiel\PowerRoute\Tests\Unit\InputSources;

use Mcustiel\PowerRoute\InputSources\QueryStringParam;

class QueryStringParamTest extends AbstractInputSourceTest
{
    public function setUp()
    {
        parent::setUp();
        $this->evaluator = new QueryStringParam();
    }

    /**
     * @test
     */
    public function shouldReturnTheQueryStringParam()
    {
        $this->request
            ->expects($this->once())
            ->method('getQueryParams')
            ->willReturn(['banana' => 'potato']);
        $this->assertSame('potato', $this->evaluator->getValue($this->request, 'banana'));
    }

    /**
     * @test
     */
    public function shouldReturnNullIfQueryStringParamIsNotSet()
    {
        $this->request
            ->expects($this->once())
            ->method('getQueryParams')
            ->willReturn(['banana' => 'potato']);
        $this->assertNull($this->evaluator->getValue($this->request, 'coconut'));
    }
}
