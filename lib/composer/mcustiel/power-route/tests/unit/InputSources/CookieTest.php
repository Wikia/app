<?php

namespace Mcustiel\PowerRoute\Tests\Unit\InputSources;

use Mcustiel\PowerRoute\InputSources\Cookie;

class CookieTest extends AbstractInputSourceTest
{
    public function setUp()
    {
        parent::setUp();
        $this->evaluator = new Cookie();
    }

    /**
     * @test
     */
    public function shouldReturnTheValueOfTheCookie()
    {
        $this->request
            ->expects($this->once())
            ->method('getCookieParams')
            ->willReturn(['banana' => 'potato']);
        $this->assertSame('potato', $this->evaluator->getValue($this->request, 'banana'));
    }

    /**
     * @test
     */
    public function shouldReturnNullCookieIsNotSet()
    {
        $this->request
            ->expects($this->once())
            ->method('getCookieParams')
            ->willReturn(['banana' => 'potato']);
        $this->assertNull($this->evaluator->getValue($this->request, 'coconut'));
    }
}
